<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\DB;
use App\Core\Env;
use App\Services\GeoService;
use App\Services\SeoService;
use App\Services\CsrfService;
use App\Services\RateLimitService;
use App\Models\Property;

/**
 * Home Controller
 * 
 * Maneja la landing principal con GEO detection.
 */
class HomeController extends Controller
{
    public function index(): Response
    {
        // Detect country from visitor IP
        $geoService = new GeoService();
        $countryCode = $geoService->getCountryFromIp();

        // Get featured properties for detected country
        $propertyModel = new Property();
        $featured = $propertyModel->getFeatured($countryCode, 6);

        // Setup SEO
        $seoService = new SeoService('/', $countryCode);
        $seoService
            ->setTitle('HAVRE ESTATES - Inmobiliaria Premium MX · CO · CL')
            ->setDescription('Descubre propiedades de lujo en México, Colombia y Chile. Venta, renta y desarrollos inmobiliarios de clase mundial.')
            ->setCanonical(rtrim(Env::get('APP_URL', 'http://localhost:8000'), '/') . '/')
            ->addOgTag('title', 'HAVRE ESTATES - Plataforma Inmobiliaria Premium')
            ->addOgTag('description', 'Propiedades premium en 3 países')
            ->addOgTag('type', 'website');

        $seoService->addJsonLd($seoService->organizationSchema());

        $csrfService = new CsrfService();

        // Prepare data
        $data = [
            'country' => $countryCode,
            'currency' => $geoService->getCurrencyByCountry($countryCode),
            'phone' => $geoService->getPhoneByCountry($countryCode),
            'featured_properties' => $featured,
            'newsletter_csrf_token' => $csrfService->getToken('newsletter_form'),
            'newsletter_status' => (string) $this->request->getQuery('newsletter', ''),
            'seo_tags' => $seoService->renderMetaTags(),
            'seo_json_ld' => $seoService->renderJsonLd()
        ];

        // Render page with extracted variables
        extract($data);

        ob_start();
        include ROOT_PATH . '/src/Views/pages/home.php';
        $content = ob_get_clean();

        // Render inside main layout to keep nav/footer and SEO tags
        ob_start();
        include ROOT_PATH . '/src/Views/layouts/main.php';
        $html = ob_get_clean();

        return new Response($html);
    }

    public function subscribe(): Response
    {
        $csrfService = new CsrfService();
        $rateLimit = new RateLimitService();

        $honeypot = trim((string) $this->request->getPost('website', ''));
        if ($honeypot !== '') {
            return (new Response())->redirect('/?newsletter=ok');
        }

        $csrfToken = (string) $this->request->getPost('csrf_token', '');
        if (!$csrfService->validateAndRotate($csrfToken, 'newsletter_form')) {
            return (new Response())->redirect('/?newsletter=csrf_error');
        }

        $limit = $rateLimit->check('newsletter:' . $this->request->getIp(), 8, 3600);
        if (!$limit['allowed']) {
            return (new Response())->redirect('/?newsletter=rate_limited');
        }

        $email = filter_var((string) $this->request->getPost('email', ''), FILTER_VALIDATE_EMAIL);
        if (!$email) {
            return (new Response())->redirect('/?newsletter=invalid_email');
        }

        $name = trim((string) $this->request->getPost('name', 'Newsletter Lead'));
        $countryCode = (new GeoService())->getCountryFromIp($this->request->getIp()) ?? Env::get('DEFAULT_COUNTRY', 'MX');

        try {
            DB::getInstance()->query(
                'INSERT INTO leads (name, email, country_code, source_page, ip_hash) VALUES (?, ?, ?, ?, ?)',
                [
                    mb_substr($name === '' ? 'Newsletter Lead' : $name, 0, 100),
                    $email,
                    $countryCode,
                    'home_newsletter',
                    hash('sha256', $this->request->getIp()),
                ]
            );
        } catch (\Throwable $e) {
            error_log('Newsletter subscribe error: ' . $e->getMessage());
            return (new Response())->redirect('/?newsletter=server_error');
        }

        return (new Response())->redirect('/?newsletter=ok');
    }
}
