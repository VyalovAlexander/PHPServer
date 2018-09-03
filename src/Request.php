<?php

namespace VyalovAlexander\PHPServer;

class Request
{

    protected $method = '';
    protected $uri = '';
    protected $params = [];
    protected $headers = [];

    /**
     * Request constructor.
     * @param string $method
     * @param string $uri
     * @param array $params
     * @param array $headers
     */
    public function __construct($method, $uri, array $headers)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->headers = $headers;

        list($this->uri, $params) = explode('?', $uri);
        parse_str($params, $this->params);
    }


    public static function createRequest($header)
    {
        $lines = explode("\r", $header);
        list($method, $uri) = explode(' ', array_shift($lines));
        $headers = [];
        foreach ($lines as $line)
        {
            $line = trim($line);
            if(strpos($line, ':') !== false)
            {
                list($key, $value) = explode(': ', $line);
                $headers[$key] = $value;
            }
        }

        return new static($method, $uri, $headers);
    }

    public function para($key)
    {
        return $this->params[$key];
    }


}