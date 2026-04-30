<?php

namespace App\Services;

/**
 * File-based sliding window rate limiter.
 */
class RateLimitService
{
    private string $storagePath;

    public function __construct()
    {
        $this->storagePath = ROOT_PATH . '/storage/cache/ratelimit';
        if (!is_dir($this->storagePath)) {
            mkdir($this->storagePath, 0777, true);
        }
    }

    public function check(string $key, int $maxAttempts, int $windowSeconds): array
    {
        $now = time();
        $file = $this->storagePath . '/' . md5($key) . '.json';

        $timestamps = [];
        if (file_exists($file)) {
            $raw = file_get_contents($file);
            $decoded = json_decode($raw ?: '[]', true);
            if (is_array($decoded)) {
                $timestamps = array_values(array_filter($decoded, fn($ts) => is_int($ts) || ctype_digit((string) $ts)));
            }
        }

        $windowStart = $now - $windowSeconds;
        $timestamps = array_values(array_filter($timestamps, fn($ts) => (int) $ts >= $windowStart));

        if (count($timestamps) >= $maxAttempts) {
            $retryAfter = max(1, $windowSeconds - ($now - (int) min($timestamps)));

            file_put_contents($file, json_encode($timestamps));

            return [
                'allowed' => false,
                'remaining' => 0,
                'retry_after' => $retryAfter,
            ];
        }

        $timestamps[] = $now;
        file_put_contents($file, json_encode($timestamps));

        return [
            'allowed' => true,
            'remaining' => max(0, $maxAttempts - count($timestamps)),
            'retry_after' => 0,
        ];
    }
}
