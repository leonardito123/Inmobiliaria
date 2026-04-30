<?php

namespace App\Core;

/**
 * Router PHP Artesanal
 * 
 * Router basado en regex con soporte para named parameters, middlewares y métodos HTTP.
 * Sin dependencias externas - implementación pura en PHP.
 */
class Router
{
    private array $routes = [];
    private array $middlewares = [];

    /**
     * Register GET route
     */
    public function get(string $path, string|callable $handler): self
    {
        return $this->route('GET', $path, $handler);
    }

    /**
     * Register POST route
     */
    public function post(string $path, string|callable $handler): self
    {
        return $this->route('POST', $path, $handler);
    }

    /**
     * Register route
     */
    public function route(string $method, string $path, string|callable $handler): self
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler,
            'pattern' => $this->pathToRegex($path),
        ];

        return $this;
    }

    /**
     * Add middleware
     */
    public function middleware(Middleware $middleware): self
    {
        $this->middlewares[] = $middleware;

        return $this;
    }

    /**
     * Convert path to regex pattern
     * 
     * /venta/{id}/fotos → /venta/(?P<id>\d+)/fotos
     */
    private function pathToRegex(string $path): string
    {
        $pattern = preg_replace_callback(
            '/{(\w+)}/',
            fn($matches) => '(?P<' . $matches[1] . '>\w+)',
            $path
        );

        return '#^' . $pattern . '$#';
    }

    /**
     * Dispatch request to handler
     */
    public function dispatch(): void
    {
        $request = new Request();
        $response = new Response();

        $path = $request->getPath();
        $method = $request->getMethod();

        // Find matching route
        $matched = null;
        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            if (preg_match($route['pattern'], $path, $matches)) {
                $matched = $route;

                // Extract named parameters
                $params = [];
                foreach ($matches as $key => $value) {
                    if (!is_numeric($key)) {
                        $params[$key] = $value;
                    }
                }
                $request->setParams($params);

                break;
            }
        }

        if (!$matched) {
            $response->setStatusCode(404);
            $response->setBody('404 Not Found');
            $response->send();
        }

        // Execute middlewares
        $handler = $matched['handler'];
        $middlewareStack = $this->buildMiddlewareStack($handler);

        try {
            $middlewareStack($request);
        } catch (\Throwable $e) {
            error_log('Router error: ' . $e->getMessage());
            $response->setStatusCode(500);
            $response->setBody('Internal Server Error');
            $response->send();
        }
    }

    /**
     * Build middleware stack
     */
    private function buildMiddlewareStack(callable $handler): callable
    {
        $next = function($request) use ($handler) {
            $response = call_user_func($handler, $request);
            
            // If handler returns Response, send it
            if ($response instanceof Response) {
                $response->send();
            }
        };

        foreach (array_reverse($this->middlewares) as $middleware) {
            $next = function($request) use ($middleware, $next) {
                return $middleware->handle($request, fn($r) => $next($r));
            };
        }

        return $next;
    }
}
