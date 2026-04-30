<?php

declare(strict_types=1);

namespace App\Services;

/**
 * MailService — envío de correos via PHP mail() o SMTP (smtp_host en .env).
 *
 * Variables .env esperadas:
 *   MAIL_FROM      dirección remitente (default: noreply@havre-estates.com)
 *   MAIL_FROM_NAME nombre del remitente
 *   SMTP_HOST      host SMTP (vacío = usar mail() nativo)
 *   SMTP_PORT      puerto SMTP (default 587)
 *   SMTP_USER      usuario SMTP
 *   SMTP_PASS      contraseña SMTP
 */
class MailService
{
    private string $from;
    private string $fromName;

    public function __construct()
    {
        $this->from     = Env::get('MAIL_FROM', 'noreply@havre-estates.com');
        $this->fromName = Env::get('MAIL_FROM_NAME', 'HAVRE ESTATES');
    }

    /**
     * Envía un correo de texto plano o HTML.
     *
     * @param string $to      Destinatario
     * @param string $subject Asunto
     * @param string $body    Cuerpo HTML
     * @param array  $extra   Headers adicionales opcionales
     */
    public function send(string $to, string $subject, string $body, array $extra = []): bool
    {
        if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= "From: {$this->fromName} <{$this->from}>\r\n";
        $headers .= "Reply-To: {$this->from}\r\n";
        $headers .= "X-Mailer: HAVRE-ESTATES/PHP\r\n";

        foreach ($extra as $name => $value) {
            $headers .= "{$name}: {$value}\r\n";
        }

        return mail(
            $to,
            mb_encode_mimeheader($subject, 'UTF-8', 'B'),
            $body,
            $headers
        );
    }

    /**
     * Notificación de nuevo lead al equipo interno.
     */
    public function notifyLead(array $lead): bool
    {
        $to      = Env::get('MAIL_LEADS_TO', $this->from);
        $subject = 'Nuevo lead: ' . htmlspecialchars($lead['name'] ?? 'Sin nombre', ENT_QUOTES);
        $score   = (int) ($lead['score'] ?? 0);

        $body = "<h2>Nuevo lead recibido</h2>"
            . "<p><strong>Nombre:</strong> " . htmlspecialchars($lead['name'] ?? '', ENT_QUOTES) . "</p>"
            . "<p><strong>Email:</strong> "  . htmlspecialchars($lead['email'] ?? '', ENT_QUOTES) . "</p>"
            . "<p><strong>Teléfono:</strong> " . htmlspecialchars($lead['phone'] ?? '', ENT_QUOTES) . "</p>"
            . "<p><strong>País:</strong> "   . htmlspecialchars($lead['country_code'] ?? '', ENT_QUOTES) . "</p>"
            . "<p><strong>Página origen:</strong> " . htmlspecialchars($lead['source_page'] ?? '', ENT_QUOTES) . "</p>"
            . "<p><strong>Score:</strong> {$score}/100</p>";

        return $this->send($to, $subject, $body);
    }

    /**
     * Confirmación de suscripción a newsletter.
     */
    public function confirmNewsletter(string $email, string $countryCode = 'MX'): bool
    {
        $subject = '¡Bienvenido a HAVRE ESTATES!';
        $body    = "<h2>Gracias por suscribirte</h2>"
            . "<p>Recibirás las mejores propiedades de lujo en tu país.</p>"
            . "<p style='color:#999;font-size:12px;'>Si no solicitaste esta suscripción, ignora este mensaje.</p>";

        return $this->send($email, $subject, $body);
    }
}
