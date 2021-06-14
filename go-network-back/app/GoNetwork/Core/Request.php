<?php

namespace GoNetwork\Core;

/**
 */
class Request
{
    /** @var string */
    protected $requestedUrl;

    /** @var string */
    protected $method;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];

        $rutaAbsoluta = $_SERVER['DOCUMENT_ROOT'] . $_SERVER['REQUEST_URI'];

        $this->requestedUrl = str_replace(App::getPublicPath(), '', $rutaAbsoluta);
    }

    /**
     * @return string
     */
    public function getRequestedUrl()
    {
        return $this->requestedUrl;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }
}