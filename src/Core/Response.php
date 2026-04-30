<?php

namespace App\Core;

/**
 * HTTP Response Object
 * 
 * Gestiona la respuesta HTTP incluyendo headers, status code y contenido.
 */
class Response
{
    private int $statusCode = 200;
    private array $headers = [];
    private string|array $body = '';

    public function __construct(string|array $body = '', int $statusCode = 200)
    {
        $this->body = $body;
        $this->statusCode = $statusCode;
        $this->setHeader('Content-Type', 'text/html; charset=utf-8');
    }

    public function setStatusCode(int $code): self
    {
        $this->statusCode = $code;

        return $this;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function setHeader(string $name, string $value): self
    {
        $this->headers[$name] = $value;

        return $this;
    }

    public function setBody(string|array $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getBody(): string|array
    {
        return $this->body;
    }

    public function setHeaders(array $headers): self
    {
        $this->headers = array_merge($this->headers, $headers);

        return $this;
    }

    public function getHeader(string $name): string|null
    {
        return $this->headers[$name] ?? null;
    }

    public function json(array $data, int $statusCode = 200): self
    {
        $this->statusCode = $statusCode;
        $this->body = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $this->setHeader('Content-Type', 'application/json');

        return $this;
    }

    public function redirect(string $url, int $statusCode = 302): self
    {
        $this->statusCode = $statusCode;
        $this->setHeader('Location', $url);

        return $this;
    }

    public function send(): void
    {
        // Send status code
        http_response_code($this->statusCode);

        // Send headers
        foreach ($this->headers as $name => $value) {
            header("{$name}: {$value}");
        }

        // Send body
        if (is_array($this->body)) {
            echo json_encode($this->body, JSON_UNESCAPED_UNICODE);
        } else {
            echo $this->body;
        }

        exit;
    }
}
