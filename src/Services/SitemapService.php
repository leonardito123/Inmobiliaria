<?php

namespace App\Services;

use App\Core\Env;

/**
 * Dynamic sitemap.xml generator.
 */
class SitemapService
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = rtrim(Env::get('APP_URL', 'http://localhost:8000'), '/');
    }

    public function generate(array $propertyEntries = []): string
    {
        $staticUrls = [
            ['loc' => $this->baseUrl . '/', 'priority' => '1.0', 'changefreq' => 'daily'],
            ['loc' => $this->baseUrl . '/venta', 'priority' => '0.9', 'changefreq' => 'daily'],
            ['loc' => $this->baseUrl . '/renta', 'priority' => '0.9', 'changefreq' => 'daily'],
            ['loc' => $this->baseUrl . '/desarrollos', 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['loc' => $this->baseUrl . '/contacto', 'priority' => '0.8', 'changefreq' => 'monthly'],
        ];

        $xml = [];
        $xml[] = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($staticUrls as $entry) {
            $xml[] = '  <url>';
            $xml[] = '    <loc>' . htmlspecialchars($entry['loc'], ENT_XML1) . '</loc>';
            $xml[] = '    <changefreq>' . $entry['changefreq'] . '</changefreq>';
            $xml[] = '    <priority>' . $entry['priority'] . '</priority>';
            $xml[] = '  </url>';
        }

        foreach ($propertyEntries as $entry) {
            $loc = $this->baseUrl . '/venta?slug=' . urlencode((string) ($entry['slug'] ?? ''));
            $lastmod = !empty($entry['updated_at']) ? date('c', strtotime((string) $entry['updated_at'])) : null;

            $xml[] = '  <url>';
            $xml[] = '    <loc>' . htmlspecialchars($loc, ENT_XML1) . '</loc>';
            if ($lastmod) {
                $xml[] = '    <lastmod>' . htmlspecialchars($lastmod, ENT_XML1) . '</lastmod>';
            }
            $xml[] = '    <changefreq>weekly</changefreq>';
            $xml[] = '    <priority>0.7</priority>';
            $xml[] = '  </url>';
        }

        $xml[] = '</urlset>';

        return implode("\n", $xml);
    }
}
