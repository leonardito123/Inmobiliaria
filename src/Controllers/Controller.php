<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;

/**
 * Base Controller
 * 
 * Clase padre para todos los controladores.
 * Proporciona helpers para renderizar vistas y respuestas.
 */
abstract class Controller
{
    protected Request $request;
    protected Response $response;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->response = new Response();
    }

    /**
     * Render view
     */
    protected function render(string $view, array $data = []): Response
    {
        ob_start();

        extract($data);
        include ROOT_PATH . '/src/Views/pages/' . $view . '.php';

        $html = ob_get_clean();

        return $this->response
            ->setHeader('Content-Type', 'text/html; charset=utf-8')
            ->setBody($html);
    }

    /**
     * Return JSON response
     */
    protected function json(array $data, int $statusCode = 200): Response
    {
        return $this->response->json($data, $statusCode);
    }

    /**
     * Redirect
     */
    protected function redirect(string $url): Response
    {
        return $this->response->redirect($url);
    }

    /**
     * Return content
     */
    protected function content(string $content, int $statusCode = 200): Response
    {
        $this->response->setStatusCode($statusCode);
        $this->response->setBody($content);

        return $this->response;
    }
}
