<?php

namespace App\Services;

use App\Core\Env;

/**
 * SEO Service
 * 
 * Genera meta tags, JSON-LD structured data, og tags y sitemap.
 */
class SeoService
{
    private array $metaTags = [];
    private array $jsonLd = [];
    private string $currentUrl = '';
    private string $currentCountry = 'MX';

    public function __construct(string $url = '', string $country = 'MX')
    {
        $this->currentUrl = $url ?: $_SERVER['REQUEST_URI'] ?? '';
        $this->currentCountry = $country;
    }

    /**
     * Set page title
     */
    public function setTitle(string $title): self
    {
        $this->metaTags['title'] = $title;

        return $this;
    }

    /**
     * Set meta description
     */
    public function setDescription(string $description): self
    {
        $this->metaTags['description'] = substr($description, 0, 160);

        return $this;
    }

    /**
     * Set canonical URL
     */
    public function setCanonical(string $url): self
    {
        $this->metaTags['canonical'] = $url;

        return $this;
    }

    /**
     * Add Open Graph tag
     */
    public function addOgTag(string $property, string $content): self
    {
        $this->metaTags['og:' . $property] = $content;

        return $this;
    }

    /**
     * Add JSON-LD schema
     */
    public function addJsonLd(array $schema): self
    {
        $this->jsonLd[] = $schema;

        return $this;
    }

    /**
     * Organization schema
     */
    public function organizationSchema(): array
    {
        return [
            "@context" => "https://schema.org",
            "@type" => "RealEstateAgent",
            "name" => "HAVRE ESTATES",
            "description" => "Plataforma inmobiliaria premium en México, Colombia y Chile",
            "url" => Env::get('APP_URL', 'https://havre-estates.com'),
            "telephone" => "+52 55 4169 8259",
            "sameAs" => [
                "https://www.facebook.com/havre-estates",
                "https://www.instagram.com/havre-estates",
                "https://www.linkedin.com/company/havre-estates"
            ]
        ];
    }

    /**
     * Real estate listing schema
     */
    public function propertySchema(array $property): array
    {
        return [
            "@context" => "https://schema.org",
            "@type" => "RealEstateListing",
            "name" => $property['meta_title'] ?? 'Propiedad',
            "description" => $property['meta_desc'] ?? '',
            "url" => $this->currentUrl,
            "price" => $property['price'] ?? 0,
            "priceCurrency" => $property['currency'] ?? 'MXN',
            "numberOfBedrooms" => $property['bedrooms'] ?? 0,
            "numberOfBathrooms" => $property['bathrooms'] ?? 0,
            "floorSize" => [
                "@type" => "QuantitativeValue",
                "value" => $property['sqm'] ?? 0,
                "unitCode" => "MTK"
            ],
            "areaServed" => $property['country_code'] ?? 'MX',
            "geo" => [
                "@type" => "GeoCoordinates",
                "latitude" => $property['lat'] ?? 0,
                "longitude" => $property['lng'] ?? 0
            ]
        ];
    }

    /**
     * Render meta tags HTML
     */
    public function renderMetaTags(): string
    {
        $html = '';

        // Title
        if (isset($this->metaTags['title'])) {
            $html .= '<title>' . htmlspecialchars($this->metaTags['title']) . '</title>' . "\n";
        }

        // Description
        if (isset($this->metaTags['description'])) {
            $html .= '<meta name="description" content="' . htmlspecialchars($this->metaTags['description']) . '">' . "\n";
        }

        // Canonical
        if (isset($this->metaTags['canonical'])) {
            $html .= '<link rel="canonical" href="' . htmlspecialchars($this->metaTags['canonical']) . '">' . "\n";
        }

        // Open Graph / Twitter Cards
        foreach ($this->metaTags as $key => $value) {
            if (str_starts_with($key, 'og:')) {
                $html .= '<meta property="' . htmlspecialchars($key) . '" content="' . htmlspecialchars($value) . '">' . "\n";
            }
        }

        // hreflang for multi-country
        $countries = explode(',', Env::get('COUNTRIES', 'MX,CO,CL'));
        foreach ($countries as $country) {
            $langCode = strtolower($country) . '-' . strtoupper($country);
            $html .= '<link rel="alternate" hreflang="' . $langCode . '" href="' . htmlspecialchars($this->currentUrl) . '?country=' . $country . '">' . "\n";
        }

        return $html;
    }

    /**
     * Render JSON-LD scripts
     */
    public function renderJsonLd(): string
    {
        if (empty($this->jsonLd)) {
            return '';
        }

        $scripts = '';
        foreach ($this->jsonLd as $schema) {
            $scripts .= '<script type="application/ld+json">' . "\n";
            $scripts .= json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . "\n";
            $scripts .= '</script>' . "\n";
        }

        return $scripts;
    }
}
