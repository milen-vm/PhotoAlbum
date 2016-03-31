<?php
namespace MyMVC\Library\Routing;

use MyMVC\Library\Config;
use MyMVC\Library\Utility\Storage;

class DefaultRouter implements IRouter
{

    private $uri;

    private $requestMethod;

    private $controller;

    private $action;

    private $params = [];

    private $route;

    private $area;

    private $language;

    public function __construct()
    {
        $this->setUri();
        $this->setRequestMethod();

        // Set defaults from config file
        $this->setController(Config::get('defaultController'));
        $this->setAction(Config::get('defaultAction'));
        $this->setRoute(Config::get('defaultRoute'));
        $routes = Config::get('routes');
        $this->setArea($routes);
        $this->setLanguage(Config::get('defaultLanguage'));

        $this->parseUri($routes);
    }

    private function parseUri($routes)
    {
        $pathParts = explode('/', $this->uri);

        if (current($pathParts)) {
            $pathParts = array_filter($pathParts, function ($val)
            {
                return $val != '';
            });

            // Get language at first element
            if (in_array(strtolower(current($pathParts)), Config::get('languages'))) {
                $this->setLanguage(array_shift($pathParts));
            }

            // Get route at next element
            if (in_array(strtolower(current($pathParts)), array_keys($routes))) {
                $this->setRoute(array_shift($pathParts));
                $this->setArea($routes);
            }

            // Get controller and action - next element of array
            if (count($pathParts)) {
                $this->setController(array_shift($pathParts));

                if (count($pathParts)) {
                    $this->setAction(array_shift($pathParts));
                }
            }

            // Get params - all the rest
            $this->params = $pathParts;
        }
    }

    public function getUri()
    {
        return $this->uri;
    }

    private function setUri()
    {
        $request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $baseDir = dirname(dirname($_SERVER['PHP_SELF']));

        $uri = str_replace($baseDir, '', $request);
        $this->uri = trim($uri, '/');
    }

    public function getRequestMethod()
    {
        return $this->requestMethod;
    }

    private function setRequestMethod()
    {
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
    }

    public function getController()
    {
        return $this->controller;
    }

    private function setController($controller)
    {
        $this->controller = strtolower($controller);
    }

    public function getAction()
    {
        return $this->action;
    }

    private function setAction($action)
    {
        $this->action = strtolower($action);
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getRoute()
    {
        return $this->route;
    }

    private function setRoute($route)
    {
        $this->route = strtolower($route);
    }

    public function getArea()
    {
        return $this->area;
    }

    private function setArea($routes)
    {
        $this->area = isset($routes[$this->route]) ? strtolower($routes[$this->route]) : '';
    }

    public function getLanguage()
    {
        return $this->language;
    }

    private function setLanguage($lang)
    {
        $this->language = strtolower($lang);
    }
}