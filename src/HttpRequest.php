<?php
/**
 * HTTP Request Handler using cURL
 * 
 * @author Okanlawon Anuoluwapo
 * @package AnuDev\CurlHttpRequest
 */

namespace AnuDev\CurlHttpRequest;

class HttpRequest
{
    private string $url;
    private string $method;
    private array $data;
    private array $headers;
    private $ch;
    
    public ?string $response = null;
    public int $statusCode = 0;
    public ?string $error = null;

    public function __construct(string $url, string $method, array $data = [], array $headers = [])
    {
        $this->url = $url;
        $this->method = strtoupper($method);
        $this->data = $data;
        $this->headers = $headers ?: [
            'Content-Type: application/json',
            'Accept: application/json'
        ];

        $this->initCurl();
    }

    private function initCurl(): void
    {
        $this->ch = curl_init();
    }

    private function execute(array $options): string
    {
        if ($this->ch === null) {
            $this->initCurl();
        }

        curl_setopt_array($this->ch, $options);

        $this->response = curl_exec($this->ch);
        $this->statusCode = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
        $errorCode = curl_errno($this->ch);

        if ($errorCode) {
            $this->error = curl_error($this->ch);
        }

        return $this->response;
    }

    public function get(): string
    {
        $queryUrl = $this->url . '?' . http_build_query($this->data);

        return $this->execute([
            CURLOPT_URL => $queryUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $this->headers
        ]);
    }

    public function post(): string
    {
        return $this->execute([
            CURLOPT_URL => $this->url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($this->data),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $this->headers
        ]);
    }

    public function put(): string
    {
        return $this->execute([
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => json_encode($this->data),
            CURLOPT_HTTPHEADER => $this->headers
        ]);
    }

    public function patch(): string
    {
        $fields = [];

        foreach ($this->data as $key => $value) {
            if (is_array($value) && isset($value['tmp_name']) && is_file($value['tmp_name'])) {
                $fields[$key] = new \CURLFile($value['tmp_name']);
            } else {
                $fields[$key] = $value;
            }
        }

        return $this->execute([
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'PATCH',
            CURLOPT_POSTFIELDS => $fields,
            CURLOPT_HTTPHEADER => $this->headers
        ]);
    }

    public function delete(): string
    {
        return $this->execute([
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_POSTFIELDS => json_encode($this->data),
            CURLOPT_HTTPHEADER => $this->headers
        ]);
    }

    public function close(): void
    {
        if ($this->ch !== null) {
            curl_close($this->ch);
            $this->ch = null;
        }
    }
}
