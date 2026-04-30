<?php

/**
 * Web Routes
 * 
 * Define todas las rutas de la aplicación.
 */

/** @var \App\Core\Router $router */

// Home
$router->get('/', function(\App\Core\Request $request) {
    $controller = new \App\Controllers\HomeController($request);
    return $controller->index();
});

// Newsletter subscription (home)
$router->post('/newsletter/subscribe', function(\App\Core\Request $request) {
    $controller = new \App\Controllers\HomeController($request);
    return $controller->subscribe();
});

// Venta
$router->get('/venta', function(\App\Core\Request $request) {
    $property = new \App\Models\Property();
    $geo = new \App\Services\GeoService();
    $seo = new \App\Services\SeoService();
    $controller = new \App\Controllers\VentaController($property, $geo, $seo);
    return $controller->index($request);
});

// AJAX - Load more properties
$router->get('/venta/load-more', function(\App\Core\Request $request) {
    $property = new \App\Models\Property();
    $geo = new \App\Services\GeoService();
    $seo = new \App\Services\SeoService();
    $controller = new \App\Controllers\VentaController($property, $geo, $seo);
    return $controller->loadMore($request);
});

// Renta
$router->get('/renta', function(\App\Core\Request $request) {
    $property = new \App\Models\Property();
    $geo = new \App\Services\GeoService();
    $seo = new \App\Services\SeoService();
    $controller = new \App\Controllers\RentaController($property, $geo, $seo);
    return $controller->index($request);
});

// Desarrollos
$router->get('/desarrollos', function(\App\Core\Request $request) {
    $property = new \App\Models\Property();
    $geo = new \App\Services\GeoService();
    $seo = new \App\Services\SeoService();
    $controller = new \App\Controllers\DesarrollosController($property, $geo, $seo);
    return $controller->index($request);
});

// Contacto
$router->get('/contacto', function(\App\Core\Request $request) {
    $controller = new \App\Controllers\ContactoController();
    return $controller->index($request);
});

// Contacto - Send chat message
$router->post('/contacto/send', function(\App\Core\Request $request) {
    $controller = new \App\Controllers\ContactoController();
    return $controller->send($request);
});

// Contacto - SSE stream
$router->get('/contacto/stream', function(\App\Core\Request $request) {
    $controller = new \App\Controllers\ContactoController();
    return $controller->stream($request);
});

// API - Properties by country
$router->get('/api/properties/{country}', function(\App\Core\Request $request) {
    $country = $request->getParam('country', 'MX');
    $model = new \App\Models\Property();
    $properties = $model->getByCountry($country);
    
    return (new \App\Core\Response())->json($properties);
});

// SEO - Dynamic sitemap.xml
$router->get('/sitemap.xml', function(\App\Core\Request $request) {
    $model = new \App\Models\Property();
    $entries = $model->getSitemapEntries(1000);

    $xml = (new \App\Services\SitemapService())->generate($entries);

    return (new \App\Core\Response($xml))
        ->setHeader('Content-Type', 'application/xml; charset=utf-8')
        ->setHeader('Cache-Control', 'public, max-age=900');
});

// SEO - robots.txt
$router->get('/robots.txt', function(\App\Core\Request $request) {
    $baseUrl = rtrim(\App\Core\Env::get('APP_URL', 'http://localhost:8000'), '/');
    $content = "User-agent: *\n";
    $content .= "Allow: /\n";
    $content .= "Disallow: /storage/\n";
    $content .= "Disallow: /vendor/\n";
    $content .= "Sitemap: {$baseUrl}/sitemap.xml\n";

    return (new \App\Core\Response($content))
        ->setHeader('Content-Type', 'text/plain; charset=utf-8')
        ->setHeader('Cache-Control', 'public, max-age=3600');
});

