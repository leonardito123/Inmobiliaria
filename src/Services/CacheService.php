<?php

namespace App\Services;

use App\Core\Env;

/**
 * Cache Service
 * 
 * Caché de vistas compiladas con TTL usando archivos locales.
 * Sin Redis, sin Memcached - solo filesystem.
 */
class CacheService
{
    private string $cachePath;
    private int $ttl;
    private bool $enabled;

    public function __construct()
    {
        $this->cachePath = ROOT_PATH . '/storage/cache';
        $this->ttl = (int) Env::get('CACHE_TTL', 3600);
        $this->enabled = (bool) Env::get('CACHE_ENABLED', false);
    }

    /**
     * Get cached value
     */
    public function get(string $key): mixed
    {
        if (!$this->enabled) {
            return null;
        }

        $file = $this->getCacheFile($key);

        if (!file_exists($file)) {
            return null;
        }

        $data = unserialize(file_get_contents($file));

        // Check expiry
        if ($data['expiry'] < time()) {
            unlink($file);

            return null;
        }

        return $data['value'];
    }

    /**
     * Set cache value
     */
    public function set(string $key, mixed $value, int $ttl = null): void
    {
        if (!$this->enabled) {
            return;
        }

        $ttl = $ttl ?? $this->ttl;
        $file = $this->getCacheFile($key);
        $data = [
            'value' => $value,
            'expiry' => time() + $ttl
        ];

        file_put_contents($file, serialize($data));
    }

    /**
     * Delete cache
     */
    public function forget(string $key): void
    {
        $file = $this->getCacheFile($key);

        if (file_exists($file)) {
            unlink($file);
        }
    }

    /**
     * Flush all cache
     */
    public function flush(): void
    {
        $files = glob($this->cachePath . '/*.cache');

        foreach ($files as $file) {
            unlink($file);
        }
    }

    /**
     * Get cache file path
     */
    private function getCacheFile(string $key): string
    {
        $hash = md5($key);

        return $this->cachePath . '/' . $hash . '.cache';
    }
}
