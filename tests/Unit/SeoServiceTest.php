<?php

namespace Tests\Unit;

use App\Services\SeoService;
use Tests\BaseTestCase;

/**
 * SEO Service Tests
 */
class SeoServiceTest extends BaseTestCase
{
    private SeoService $seoService;

    protected function setUp(): void
    {
        $this->seoService = new SeoService('/', 'MX');
    }

    public function testSeoServiceSetTitle(): void
    {
        $this->seoService->setTitle('Test Page');

        $html = $this->seoService->renderMetaTags();

        $this->assertStringContainsString('<title>Test Page</title>', $html);
    }

    public function testSeoServiceSetDescription(): void
    {
        $description = 'This is a test description';
        $this->seoService->setDescription($description);

        $html = $this->seoService->renderMetaTags();

        $this->assertStringContainsString('name="description"', $html);
    }

    public function testSeoServiceTruncatesDescription(): void
    {
        $longDesc = str_repeat('a', 200);
        $this->seoService->setDescription($longDesc);

        $html = $this->seoService->renderMetaTags();

        $this->assertLessThanOrEqual(160, strlen(strip_tags($html)));
    }

    public function testSeoServiceOrganizationSchema(): void
    {
        $schema = $this->seoService->organizationSchema();

        $this->assertIsArray($schema);
        $this->assertEquals('https://schema.org', $schema['@context']);
        $this->assertEquals('RealEstateAgent', $schema['@type']);
        $this->assertStringContainsString('HAVRE', $schema['name']);
    }

    public function testSeoServicePropertySchema(): void
    {
        $property = [
            'meta_title' => 'Luxury Apartment',
            'price' => 500000,
            'currency' => 'MXN',
            'bedrooms' => 3,
            'bathrooms' => 2,
            'sqm' => 150,
            'country_code' => 'MX',
            'lat' => 19.4326,
            'lng' => -99.1332
        ];

        $schema = $this->seoService->propertySchema($property);

        $this->assertEquals('https://schema.org', $schema['@context']);
        $this->assertEquals('RealEstateListing', $schema['@type']);
        $this->assertEquals('Luxury Apartment', $schema['name']);
        $this->assertEquals(500000, $schema['price']);
    }

    public function testSeoServiceJsonLdOutput(): void
    {
        $this->seoService->addJsonLd(['@context' => 'https://schema.org', '@type' => 'Organization']);

        $output = $this->seoService->renderJsonLd();

        $this->assertStringContainsString('<script type="application/ld+json">', $output);
        $this->assertStringContainsString('schema.org', $output);
    }
}
