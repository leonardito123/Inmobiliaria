<?php

namespace App\Services;

/**
 * CSRF protection service with per-form tokens and rotation.
 */
class CsrfService
{
    private string $sessionKey = 'csrf_tokens';

    public function getToken(string $form = 'default'): string
    {
        if (!isset($_SESSION[$this->sessionKey])) {
            $_SESSION[$this->sessionKey] = [];
        }

        if (empty($_SESSION[$this->sessionKey][$form])) {
            $_SESSION[$this->sessionKey][$form] = bin2hex(random_bytes(32));
        }

        return $_SESSION[$this->sessionKey][$form];
    }

    public function rotateToken(string $form = 'default'): string
    {
        if (!isset($_SESSION[$this->sessionKey])) {
            $_SESSION[$this->sessionKey] = [];
        }

        $_SESSION[$this->sessionKey][$form] = bin2hex(random_bytes(32));

        return $_SESSION[$this->sessionKey][$form];
    }

    public function validateAndRotate(?string $token, string $form = 'default'): bool
    {
        $stored = $this->getToken($form);

        if (!$token || !hash_equals($stored, $token)) {
            return false;
        }

        $this->rotateToken($form);

        return true;
    }
}
