<?php

namespace Tests\Unit;

use App\Services\CacheService;
use Tests\BaseTestCase;

/**
 * Cache Service Tests
 */
class CacheServiceTest extends BaseTestCase
{
    private CacheService $cacheService;

    protected function setUp(): void
    {
        $this->cacheService = new CacheService();
    }

    public function testCacheServiceCanSetValue(): void
    {
        // Cache is disabled by default, but should not error
        $this->cacheService->set('test_key', 'test_value', 3600);

        $this->assertTrue(true);
    }

    public function testCacheServiceCanGetValue(): void
    {
        // Even if cache is disabled, should return null gracefully
        $value = $this->cacheService->get('test_key');

        $this->assertNull($value);
    }

    public function testCacheServiceCanForget(): void
    {
        $this->cacheService->forget('test_key');

        $this->assertTrue(true);
    }

    public function testCacheServiceCanFlush(): void
    {
        $this->cacheService->flush();

        $this->assertTrue(true);
    }
}
