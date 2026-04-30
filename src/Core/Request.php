<?php

namespace App\Core;

/**
 * HTTP Request Object
 * 
 * Encapsula todos los datos de la request HTTP.
 */
class Request
{
    private string $method;
    private string $path;
    private array $query = [];
    private array $post = [];
    private array $params = [];
    private array $headers = [];

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $this->query = $_GET;
        $this->post = $_POST;
        $this->params = [];

        // Parse headers (getallheaders() only available in Apache SAPI)
        if (function_exists('getallheaders')) {
            foreach (getallheaders() as $name => $value) {
                $this->headers[strtolower($name)] = $value;
            }
        } else {
            // Fallback for SAPIs where getallheaders() is not available
            foreach ($_SERVER as $key => $value) {
                if (str_starts_with($key, 'HTTP_')) {
                    $headerName = strtolower(str_replace('_', '-', substr($key, 5)));
                    $this->headers[$headerName] = $value;
                }
            }
        }
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getPath(): string
    {
        return rtrim($this->path, '/') ?: '/';
    }

    public function getQuery(string $key = null, mixed $default = null): mixed
    {
        if ($key === null) {
            return $this->query;
        }

        return $this->query[$key] ?? $default;
    }

    public function getPost(string $key = null, mixed $default = null): mixed
    {
        if ($key === null) {
            return $this->post;
        }

        return $this->post[$key] ?? $default;
    }

    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    public function getParam(string $key, mixed $default = null): mixed
    {
        return $this->params[$key] ?? $default;
    }

    public function getHeader(string $name, mixed $default = null): mixed
    {
        return $this->headers[strtolower($name)] ?? $default;
    }

    public function isAjax(): bool
    {
        return strtolower($this->getHeader('X-Requested-With', '')) === 'xmlhttprequest';
    }

    public function isPost(): bool
    {
        return $this->method === 'POST';
    }

    public function isGet(): bool
    {
        return $this->method === 'GET';
    }

    public function getInput(string $key, mixed $default = null): mixed
    {
        return $this->isPost() 
            ? $this->getPost($key, $default)
            : $this->getQuery($key, $default);
    }

    public function getIp(): string
    {
        $forwarded = $this->getHeader('X-Forwarded-For');
        if (!empty($forwarded)) {
            $parts = explode(',', $forwarded);
            return trim($parts[0]);
        }

        return $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    }
}
