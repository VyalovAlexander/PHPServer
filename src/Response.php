<?php

namespace VyalovAlexander\PHPServer;

class Response
{
    protected $body = '';
    protected $status = 200;
    protected $headers = [];
    protected $statusCodes = [
        200 => 'OK',
        404 => 'Not found'
    ];

    /**
     * Response constructor.
     * @param string $body
     */
    public function __construct(string $body, int $status = null)
    {
        if ($status !== null) {
            $this->status = $status;
        }
        $this->body = $body;
        $this->header('Date:', gmdate('D , d M Y H:i:s T'));
        $this->header('Content-Type:', 'text/html; charset=utf8');
        $this->header('Server', 'PHPServer');

    }

    public function header($key, $value)
    {
        $this->headers[ucfirst($key)] = $value;
    }

    public function buildHeader()
    {
        $lines = [];
        $lines[] = "HTTP/1.1 " . $this->status . " " . $this->statusCodes[$this->status];

        foreach ($this->headers as $key => $value) {
            $lines[] = $key . ": " . $value;
        }

        return implode("\r\n", $lines) . "\r\n\r\n";
    }


    public function __toString()
    {
        return $this->buildHeader() . $this->body;
    }


}