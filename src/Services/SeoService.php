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
     * FAQPage schema
     *
     * @param array<array{question: string, answer: string}> $faqs
     */
    public function faqSchema(array $faqs): array
    {
        $entities = array_map(fn($faq) => [
            "@type"          => "Question",
            "name"           => $faq['question'],
            "acceptedAnswer" => ["@type" => "Answer", "text" => $faq['answer']],
        ], $faqs);

        return [
            "@context"   => "https://schema.org",
            "@type"      => "FAQPage",
            "mainEntity" => $entities,
        ];
    }

    /**
     * BreadcrumbList schema
     *
     * @param array<array{name: string, url: string}> $items
     */
    public function breadcrumbSchema(array $items): array
    {
        $elements = [];
        foreach ($items as $pos => $item) {
            $elements[] = [
                "@type"    => "ListItem",
                "position" => $pos + 1,
                "name"     => $item['name'],
                "item"     => $item['url'],
            ];
        }

        return [
            "@context"        => "https://schema.org",
            "@type"           => "BreadcrumbList",
            "itemListElement" => $elements,
        ];
    }

    /**
     * Person schema (for agents)
     */
    public function personSchema(array $agent): array
    {
        return [
            "@context"   => "https://schema.org",
            "@type"      => "Person",
            "name"       => $agent['name'] ?? '',
            "jobTitle"   => $agent['specialties'][0] ?? 'Agente Inmobiliario',
            "email"      => $agent['email'] ?? '',
            "telephone"  => $agent['phone'] ?? '',
            "worksFor"   => [
                "@type" => "Organization",
                "name"  => "HAVRE ESTATES",
            ],
            "knowsLanguage" => $agent['languages'] ?? ['es'],
        ];
    }

    /**
     * Review / AggregateRating schema
     *
     * @param array<array{author: string, rating: int, body: string}> $reviews
     */
    public function reviewSchema(array $reviews, string $itemName = 'HAVRE ESTATES'): array
    {
        $reviewItems = array_map(fn($r) => [
            "@type"         => "Review",
            "author"        => ["@type" => "Person", "name" => $r['author']],
            "reviewRating"  => ["@type" => "Rating", "ratingValue" => $r['rating'], "bestRating" => 5],
            "reviewBody"    => $r['body'],
        ], $reviews);

        $avgRating = count($reviews)
            ? array_sum(array_column($reviews, 'rating')) / count($reviews)
            : 5;

        return [
            "@context"        => "https://schema.org",
            "@type"           => "LocalBusiness",
            "name"            => $itemName,
            "aggregateRating" => [
                "@type"       => "AggregateRating",
                "ratingValue" => round($avgRating, 1),
                "reviewCount" => count($reviews),
            ],
            "review" => $reviewItems,
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
