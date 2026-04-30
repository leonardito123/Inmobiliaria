<?php

namespace App\Services;

use App\Core\Env;

/**
 * Geolocation Service
 * 
 * Detecta país del visitante por IP usando MaxMind GeoLite2.
 * Sin API calls - base de datos local.
 */
class GeoService
{
    private string $dbPath;

    public function __construct()
    {
        $this->dbPath = ROOT_PATH . '/' . Env::get('GEOIP_DB_PATH', 'storage/geo/GeoLite2-City.mmdb');
    }

    /**
     * Get country code from IP
     * 
     * Returns: 'MX', 'CO', 'CL' or null if not available
     */
    public function getCountryFromIp(string $ip = null): string|null
    {
        $ip = $ip ?? $_SERVER['REMOTE_ADDR'] ?? '::1';

        // Allowed countries for HAVRE ESTATES
        $allowedCountries = explode(',', Env::get('COUNTRIES', 'MX,CO,CL'));

        // If DB doesn't exist, return default
        if (!file_exists($this->dbPath)) {
            return Env::get('DEFAULT_COUNTRY', 'MX');
        }

        try {
            $reader = new \GeoIp2\Database\Reader($this->dbPath);
            $record = $reader->city($ip);
            $countryCode = $record->country->isoCode;

            // Return only if in allowed countries
            if (in_array($countryCode, $allowedCountries)) {
                return $countryCode;
            }

            return Env::get('DEFAULT_COUNTRY', 'MX');
        } catch (\Exception $e) {
            error_log('GeoService error: ' . $e->getMessage());

            return Env::get('DEFAULT_COUNTRY', 'MX');
        }
    }

    /**
     * Get currency by country
     */
    public function getCurrencyByCountry(string $countryCode): string
    {
        $currencies = [
            'MX' => 'MXN',
            'CO' => 'COP',
            'CL' => 'CLP'
        ];

        return $currencies[$countryCode] ?? 'MXN';
    }

    /**
     * Get phone number by country
     */
    public function getPhoneByCountry(string $countryCode): string
    {
        $phones = [
            'MX' => '+52 55 4169 8259',
            'CO' => '+57 1 8000 000',
            'CL' => '+56 2 2000 0000'
        ];

        return $phones[$countryCode] ?? $phones['MX'];
    }

    /**
     * Get default city by country
     */
    public function getDefaultCityByCountry(string $countryCode): string
    {
        $cities = [
            'MX' => 'Ciudad de México',
            'CO' => 'Bogotá',
            'CL' => 'Santiago'
        ];

        return $cities[$countryCode] ?? 'Ciudad de México';
    }
}
