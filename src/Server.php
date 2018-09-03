<?php

namespace VyalovAlexander\PHPServer;

class Server
{
    protected $host = null;
    protected $port = null;
    protected $socket = null;

    /**
     * Server constructor.
     * @param string $host
     * @param string $port
     */
    public function __construct($host, $port)
    {
        $this->host = $host;
        $this->port = $port;

        $this->createSocket();
        $this->bind();
    }

    protected function createSocket()
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, 0);
    }

    protected function bind()
    {
        socket_bind($this->socket, $this->host, $this->port);
    }

    public function listen($callback)
    {
        while(true)
        {
            socket_listen($this->socket);
            $client = socket_accept($this->socket);
            if(!$client)
            {
                socket_close($client);
                continue;
            }
            $text = "";
            while($line =socket_read($client, 1024))
            {
                $text .= $line;
            }
            $request = Request::createRequest($text);

            $response = call_user_func($callback, $request);
            $responseText = (string) $response;

            socket_write($client, $responseText, strlen($responseText));
            socket_close($client);

        }
    }

}