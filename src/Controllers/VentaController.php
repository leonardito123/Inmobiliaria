<?php

namespace App\Controllers;

use App\Core\Env;
use App\Core\Request;
use App\Core\Response;
use App\Models\Property;
use App\Services\GeoService;
use App\Services\SeoService;

class VentaController
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
        // Detectar país del visitante
        $countryCode = $this->geoService->getCountryFromIp() ?? Env::get('APP_COUNTRY', 'MX');
        
        // Parámetros de filtro
        $city = (string) $request->getQuery('city', '');
        $bedrooms = (int) $request->getQuery('bedrooms', 0);
        $priceMin = (int) $request->getQuery('price_min', 0);
        $priceMax = (int) $request->getQuery('price_max', 0);
        $cursor = $request->getQuery('cursor', null);
        $limit = 6; // Propiedades por página
        
        // Construir filtros
        $filters = [
            'type' => 'venta',
            'country_code' => $countryCode,
            'status' => 'available'
        ];
        
        if ($city) {
            $filters['city'] = $city;
        }
        if ($bedrooms > 0) {
            $filters['bedrooms'] = $bedrooms;
        }
        if ($priceMin > 0) {
            $filters['price_min'] = $priceMin;
        }
        if ($priceMax > 0) {
            $filters['price_max'] = $priceMax;
        }
        
        // Traer propiedades con cursor pagination
        $properties = $this->propertyModel->getFiltered($filters, $cursor, $limit + 1);
        
        // Verificar si hay más registros
        $hasMore = count($properties) > $limit;
        $properties = array_slice($properties, 0, $limit);
        
        // Calcular próximo cursor
        $nextCursor = $hasMore && count($properties) > 0 
            ? base64_encode('id:' . end($properties)['id']) 
            : null;
        
        // SEO
        $this->seoService->setTitle("Propiedades en {$countryCode} | Venta | HAVRE ESTATES");
        $this->seoService->setDescription("Descubre nuestras mejores propiedades en venta. Filtros avanzados y búsqueda por ciudad, habitaciones y precio.");
        $this->seoService->setCanonical(rtrim(Env::get('APP_URL', 'http://localhost:8000'), '/') . '/venta');
        if (!empty($properties)) {
            $this->seoService->addJsonLd($this->seoService->propertySchema($properties[0]));
        }
        
        // Extraer variables para la vista
        extract([
            'properties' => $properties,
            'country' => $countryCode,
            'country_code' => $countryCode,
            'currency' => $this->geoService->getCurrencyByCountry($countryCode),
            'filters' => [
                'city' => $city,
                'bedrooms' => $bedrooms,
                'price_min' => $priceMin,
                'price_max' => $priceMax
            ],
            'pagination' => [
                'has_more' => $hasMore,
                'next_cursor' => $nextCursor
            ],
            'seo_tags' => $this->seoService->renderMetaTags(),
            'seo_json_ld' => $this->seoService->renderJsonLd(),
        ]);
        
        ob_start();
        include __DIR__ . '/../Views/pages/venta.php';
        $content = ob_get_clean();

        ob_start();
        include ROOT_PATH . '/src/Views/layouts/main.php';
        $html = ob_get_clean();

        return new Response($html);
    }

    /**
     * API endpoint para infinite scroll (AJAX)
     */
    public function loadMore(Request $request): Response
    {
        if (!$request->isAjax()) {
            return (new Response())->json(['error' => 'Invalid request'], 400);
        }

        $countryCode = Env::get('APP_COUNTRY', 'MX');
        $cursor = $request->getQuery('cursor');
        $city = (string) $request->getQuery('city', '');
        $bedrooms = (int) $request->getQuery('bedrooms', 0);
        $priceMin = (int) $request->getQuery('price_min', 0);
        $priceMax = (int) $request->getQuery('price_max', 0);
        $limit = 6;

        $filters = [
            'type' => 'venta',
            'country_code' => $countryCode,
            'status' => 'available'
        ];
        
        if ($city) {
            $filters['city'] = $city;
        }
        if ($bedrooms > 0) {
            $filters['bedrooms'] = $bedrooms;
        }
        if ($priceMin > 0) {
            $filters['price_min'] = $priceMin;
        }
        if ($priceMax > 0) {
            $filters['price_max'] = $priceMax;
        }

        $properties = $this->propertyModel->getFiltered($filters, $cursor, $limit + 1);
        $hasMore = count($properties) > $limit;
        $properties = array_slice($properties, 0, $limit);

        $nextCursor = $hasMore && count($properties) > 0 
            ? base64_encode('id:' . end($properties)['id']) 
            : null;

        return (new Response())->json([
            'properties' => $properties,
            'has_more' => $hasMore,
            'next_cursor' => $nextCursor
        ]);
    }
}
