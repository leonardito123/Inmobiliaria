<?php

namespace App\Services;

use App\Core\Env;

/**
 * reCAPTCHA v3 verification helper.
 */
class RecaptchaService
{
    public function isEnabled(): bool
    {
        return filter_var(Env::get('RECAPTCHA_ENABLED', 'false'), FILTER_VALIDATE_BOOLEAN);
    }

    public function getSiteKey(): ?string
    {
        return Env::get('RECAPTCHA_SITE_KEY');
    }

    public function verify(?string $token, ?string $ip = null): bool
    {
        if (!$this->isEnabled()) {
            return true;
        }

        $secret = Env::get('RECAPTCHA_SECRET_KEY');
        if (!$secret || !$token) {
            return false;
        }

        $postData = http_build_query([
            'secret' => $secret,
            'response' => $token,
            'remoteip' => $ip ?: '',
        ]);

        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'content' => $postData,
                'timeout' => 5,
            ],
        ]);

        $response = @file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
        if ($response === false) {
            return false;
        }

        $decoded = json_decode($response, true);
        if (!is_array($decoded)) {
            return false;
        }

        $success = (bool) ($decoded['success'] ?? false);
        $score = (float) ($decoded['score'] ?? 0.0);

        return $success && $score >= 0.5;
    }
}
