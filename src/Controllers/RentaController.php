<?php

namespace App\Controllers;

use App\Core\Env;
use App\Core\Request;
use App\Core\Response;
use App\Models\Property;
use App\Services\GeoService;
use App\Services\SeoService;

class RentaController
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
        $bedrooms = (int) $request->getQuery('bedrooms', 0);
        $priceMax = (int) $request->getQuery('price_max', 0);

        $filters = [
            'type' => 'renta',
            'country_code' => $countryCode,
            'status' => 'available',
        ];

        if ($city !== '') {
            $filters['city'] = $city;
        }
        if ($bedrooms > 0) {
            $filters['bedrooms'] = $bedrooms;
        }
        if ($priceMax > 0) {
            $filters['price_max'] = $priceMax;
        }

        $properties = $this->propertyModel->getFiltered($filters, null, 12);

        $this->seoService->setTitle("Rentas Premium en {$countryCode} | HAVRE ESTATES");
        $this->seoService->setDescription('Encuentra propiedades en renta con calendario interactivo de disponibilidad y filtros por ciudad, precio y habitaciones.');
        $this->seoService->setCanonical(rtrim(Env::get('APP_URL', 'http://localhost:8000'), '/') . '/renta');
        if (!empty($properties)) {
            $this->seoService->addJsonLd($this->seoService->propertySchema($properties[0]));
        }

        extract([
            'properties' => $properties,
            'country' => $countryCode,
            'country_code' => $countryCode,
            'currency' => $this->geoService->getCurrencyByCountry($countryCode),
            'filters' => [
                'city' => $city,
                'bedrooms' => $bedrooms,
                'price_max' => $priceMax,
            ],
            'seo_tags' => $this->seoService->renderMetaTags(),
            'seo_json_ld' => $this->seoService->renderJsonLd(),
        ]);

        ob_start();
        include __DIR__ . '/../Views/pages/renta.php';
        $content = ob_get_clean();

        ob_start();
        include ROOT_PATH . '/src/Views/layouts/main.php';
        $html = ob_get_clean();

        return new Response($html);
    }
}
