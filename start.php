#! /usr/bin/env php
<?php

require 'vendor/autoload.php';

use VyalovAlexander\PHPServer\Response;
use VyalovAlexander\PHPServer\Request;
use VyalovAlexander\PHPServer\Server;

$server = new Server('127.0.0.1', '8000');
$server->listen(function (Request $request) {
    return new Response("Hello" . $request->para('name'));
});

