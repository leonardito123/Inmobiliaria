<?php

namespace Tests\Unit;

use App\Services\GeoService;
use Tests\BaseTestCase;

/**
 * GeoService Tests
 */
class GeoServiceTest extends BaseTestCase
{
    private GeoService $geoService;

    protected function setUp(): void
    {
        $this->geoService = new GeoService();
    }

    public function testGeoServiceGetCountryReturnsString(): void
    {
        $country = $this->geoService->getCountryFromIp('127.0.0.1');

        $this->assertIsString($country);
    }

    public function testGeoServiceReturnsValidCountryCode(): void
    {
        $country = $this->geoService->getCountryFromIp('127.0.0.1');

        $this->assertTrue(in_array($country, ['MX', 'CO', 'CL']));
    }

    public function testGeoServiceGetCurrency(): void
    {
        $currencyMX = $this->geoService->getCurrencyByCountry('MX');
        $currencyCO = $this->geoService->getCurrencyByCountry('CO');
        $currencyCL = $this->geoService->getCurrencyByCountry('CL');

        $this->assertEquals('MXN', $currencyMX);
        $this->assertEquals('COP', $currencyCO);
        $this->assertEquals('CLP', $currencyCL);
    }

    public function testGeoServiceGetPhone(): void
    {
        $phoneMX = $this->geoService->getPhoneByCountry('MX');

        $this->assertIsString($phoneMX);
        $this->assertStringContainsString('+52', $phoneMX);
    }

    public function testGeoServiceGetDefaultCity(): void
    {
        $cityMX = $this->geoService->getDefaultCityByCountry('MX');

        $this->assertEquals('Ciudad de México', $cityMX);
    }
}
