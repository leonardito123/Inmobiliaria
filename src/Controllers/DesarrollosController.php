<?php

namespace App\Controllers;

use App\Core\Env;
use App\Core\Request;
use App\Core\Response;
use App\Models\Property;
use App\Services\GeoService;
use App\Services\SeoService;

class DesarrollosController
{
    private Property $propertyModel;
    private GeoService $geoService;
    private SeoService $seoService;

    public function __construct(Property $propertyModel, GeoService $geoService, SeoService $seoService)
    {
        $this->propertyModel = $propertyModel;
        $this->geoService = $geoService;
        $this->seoService = $seoService;
    }

    public function index(Request $request): Response
    {
        $countryCode = $this->geoService->getCountryFromIp() ?? Env::get('APP_COUNTRY', 'MX');

        $city = (string) $request->getQuery('city', '');
        $filters = [
            'type' => 'desarrollo',
            'country_code' => $countryCode,
            'status' => 'available',
        ];

        if ($city !== '') {
            $filters['city'] = $city;
        }

        $developments = $this->propertyModel->getFiltered($filters, null, 8);

        $this->seoService->setTitle("Desarrollos Inmobiliarios en {$countryCode} | HAVRE ESTATES");
        $this->seoService->setDescription('Explora desarrollos exclusivos con masterplans interactivos, fases de construcción y unidades disponibles.');
        $this->seoService->setCanonical(rtrim(Env::get('APP_URL', 'http://localhost:8000'), '/') . '/desarrollos');
        if (!empty($developments)) {
            $this->seoService->addJsonLd($this->seoService->propertySchema($developments[0]));
        }

        extract([
            'developments' => $developments,
            'country' => $countryCode,
            'country_code' => $countryCode,
            'currency' => $this->geoService->getCurrencyByCountry($countryCode),
            'city' => $city,
            'seo_tags' => $this->seoService->renderMetaTags(),
            'seo_json_ld' => $this->seoService->renderJsonLd(),
        ]);

        ob_start();
        include __DIR__ . '/../Views/pages/desarrollos.php';
        $content = ob_get_clean();

        ob_start();
        include ROOT_PATH . '/src/Views/layouts/main.php';
        $html = ob_get_clean();

        return new Response($html);
    }
}
