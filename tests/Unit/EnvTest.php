<?php

namespace Tests\Unit;

use App\Core\Env;
use Tests\BaseTestCase;

/**
 * Environment Configuration Tests
 */
class EnvTest extends BaseTestCase
{
    protected function setUp(): void
    {
        // Reload env for each test
        Env::load(ROOT_PATH . '/.env');
    }

    public function testEnvGet(): void
    {
        $appEnv = Env::get('APP_ENV', 'development');

        $this->assertIsString($appEnv);
    }

    public function testEnvGetWithDefault(): void
    {
        $value = Env::get('NONEXISTENT_VAR_XXXXXX', 'default');

        $this->assertEquals('default', $value);
    }

    public function testEnvCountriesParsed(): void
    {
        $countries = Env::get('COUNTRIES', 'MX,CO,CL');

        $this->assertStringContainsString('MX', $countries);
        $this->assertStringContainsString('CO', $countries);
        $this->assertStringContainsString('CL', $countries);
    }
}

