<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\Env;
use App\Services\GeoService;
use App\Services\SeoService;
use App\Services\CsrfService;
use App\Services\RateLimitService;
use App\Services\RecaptchaService;

class ContactoController
{
    private string $chatFile;

    public function __construct()
    {
        $dir = ROOT_PATH . '/storage/chat';
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $this->chatFile = $dir . '/messages.json';
        if (!file_exists($this->chatFile)) {
            file_put_contents($this->chatFile, json_encode([], JSON_UNESCAPED_UNICODE));
        }
    }

    public function index(Request $request): Response
    {
        $geoService = new GeoService();
        $countryCode = $geoService->getCountryFromIp();

        $seoService = new SeoService('/contacto', $countryCode);
        $seoService
            ->setTitle('Contacto | HAVRE ESTATES')
            ->setDescription('Habla con nuestro equipo de asesoria inmobiliaria en tiempo real por chat SSE.')
            ->setCanonical(rtrim(Env::get('APP_URL', 'http://localhost:8000'), '/') . '/contacto');
        $seoService->addJsonLd($seoService->organizationSchema());

        $csrfService = new CsrfService();
        $recaptchaService = new RecaptchaService();

        extract([
            'country' => $countryCode,
            'currency' => $geoService->getCurrencyByCountry($countryCode),
            'chat_csrf_token' => $csrfService->getToken('contact_chat_form'),
            'recaptcha_site_key' => $recaptchaService->getSiteKey(),
            'recaptcha_enabled' => $recaptchaService->isEnabled(),
            'seo_tags' => $seoService->renderMetaTags(),
            'seo_json_ld' => $seoService->renderJsonLd(),
        ]);

        ob_start();
        include __DIR__ . '/../Views/pages/contacto.php';
        $content = ob_get_clean();

        ob_start();
        include ROOT_PATH . '/src/Views/layouts/main.php';
        $html = ob_get_clean();

        return new Response($html);
    }

    public function send(Request $request): Response
    {
        $csrfService = new CsrfService();
        $rateLimit = new RateLimitService();
        $recaptcha = new RecaptchaService();

        $honeypot = trim((string) $request->getPost('website', ''));
        if ($honeypot !== '') {
            return (new Response())->json(['ok' => true], 200);
        }

        $csrfToken = (string) $request->getPost('csrf_token', '');
        if (!$csrfService->validateAndRotate($csrfToken, 'contact_chat_form')) {
            return (new Response())->json([
                'ok' => false,
                'error' => 'CSRF token invalido',
            ], 419);
        }

        $limit = $rateLimit->check('chat:' . $request->getIp(), 20, 300);
        if (!$limit['allowed']) {
            return (new Response())->json([
                'ok' => false,
                'error' => 'Demasiadas solicitudes. Intenta mas tarde.',
                'retry_after' => $limit['retry_after'],
            ], 429);
        }

        if (!$recaptcha->verify((string) $request->getPost('recaptcha_token', ''), $request->getIp())) {
            return (new Response())->json([
                'ok' => false,
                'error' => 'Verificacion anti-bot fallida',
            ], 422);
        }

        $name = trim((string) $request->getPost('name', 'Visitante'));
        $message = trim((string) $request->getPost('message', ''));

        if ($message === '') {
            return (new Response())->json([
                'ok' => false,
                'error' => 'Mensaje vacio',
            ], 422);
        }

        $payload = [
            'id' => uniqid('msg_', true),
            'name' => $name === '' ? 'Visitante' : mb_substr($name, 0, 60),
            'message' => mb_substr($message, 0, 500),
            'ts' => time(),
        ];

        $messages = $this->readMessages();
        $messages[] = $payload;
        $messages = array_slice($messages, -100);

        file_put_contents($this->chatFile, json_encode($messages, JSON_UNESCAPED_UNICODE));

        $nextToken = (new CsrfService())->getToken('contact_chat_form');

        return (new Response())->json([
            'ok' => true,
            'item' => $payload,
            'csrf_token' => $nextToken,
        ]);
    }

    public function stream(Request $request): Response
    {
        $since = (int) $request->getQuery('since', 0);
        $messages = $this->readMessages();

        $newMessages = array_values(array_filter(
            $messages,
            fn(array $item) => (int) ($item['ts'] ?? 0) > $since
        ));

        $body = '';
        foreach ($newMessages as $item) {
            $body .= "event: message\n";
            $body .= 'data: ' . json_encode($item, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n\n";
        }

        if ($body === '') {
            $body .= "event: ping\n";
            $body .= 'data: ' . json_encode(['ts' => time()]) . "\n\n";
        }

        return (new Response($body))
            ->setHeader('Content-Type', 'text/event-stream')
            ->setHeader('Cache-Control', 'no-cache, no-transform')
            ->setHeader('Connection', 'keep-alive')
            ->setHeader('X-Accel-Buffering', 'no');
    }

    private function readMessages(): array
    {
        $raw = @file_get_contents($this->chatFile);
        if ($raw === false || $raw === '') {
            return [];
        }

        $decoded = json_decode($raw, true);
        return is_array($decoded) ? $decoded : [];
    }
}
