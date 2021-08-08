<?php

namespace GoNetwork\Core;
class Route
{
    /** @var array */
    protected static $routes = [
        'GET'       => [],
        'POST'      => [],
        'PATCH'     => [],
        'PUT'       => [],
        'DELETE'    => [],
        'OPTIONS'   => [],
    ];

    /** @var string  */
    protected static $controllerAction;

    /** @var array */
    protected static $urlParameters = [];

    /**
     *
     * @param string $method.
     * @param string $url.
     * @param string $controller.
     */
    public static function add($method, $url, $controller)
    {
        $method = strtoupper($method);
        self::$routes[$method][$url] = $controller;
    }

    /**
     *
     * @param string $method
     * @param string $url
     * @return boolean
     */
    public static function exists($method, $url)
    {
        if(isset(self::$routes[$method][$url])) {
            return true;
        }

        else if(self::parameterizedRouteExists($method, $url)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     * @param string $method
     * @param string $url
     * @return bool
     */
    public static function parameterizedRouteExists($method, $url)
    {

        $urlParts = explode('/', $url);
        foreach (self::$routes[$method] as $route => $controllerAction) {

            $routeParts = explode('/', $route);
            $routeMatches = true;
            $urlData = [];


            if(count($routeParts) != count($urlParts)) {
                $routeMatches = false;
            } else {
                
                foreach ($routeParts as $key => $part) {
                    
                    if($routeParts[$key] != $urlParts[$key]) {

                        if(strpos($routeParts[$key], '{') === 0) {

                            $parameterName = substr($routeParts[$key], 1, -1);

                            $urlData[$parameterName] = $urlParts[$key];
                        } else {
                            $routeMatches = false;
                        }
                    }
                }
            }

            if($routeMatches) {

                self::$controllerAction = $controllerAction;
                self::$urlParameters = $urlData;

                return true;
            }
        }
        return false;
    }

    /**
     *
     * @param string $method
     * @param string $url
     * @return string
     */
    public static function getController($method, $url)
    {
        if(!is_null(self::$controllerAction)) {
            return self::$controllerAction;
        }

        return self::$routes[$method][$url];
    }

    /**
     * @return array
     */
    public static function getUrlParameters()
    {
        return self::$urlParameters;
    }
}