<?php
namespace MyMVC\Library;

use MyMVC\Library\Routing\IRouter;
use MyMVC\Library\MVC\View;
use MyMVC\Library\Config;
use MyMVC\Library\Core\Database;
use MyMVC\Library\Utility\Storage;
use MyMVC\Library\Utility\Session;

class App
{

    const CONTROLLERS_NAMESPACE = '\\MyMVC\\Application\\Controllers\\';

    const CONTROLLERS_SUFFIX = 'Controller';

    private static $instance = null;

    private $controler;

    private $method;

    /**
     * @todo replace DefaultRouter with IRouter
     * @var \MyMVC\Library\Routing\DefaultRouter
     */
    private static $router;

    private function __construct()
    {}

    /**
     *
     * @return \MyMVC\Library\App
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function start(IRouter $router)
    {
        self::$router = $router;//var_dump(self::$router->getController());exit;

        $this->setController(self::$router->getController());
        $this->setMethod(self::$router->getAction());

        $auth = new Authorisation($this->controler, $this->method);
        if (!$auth->process()) {
            $this->redirectPath($auth->getPath());
        }

        call_user_func_array([
            $this->controler,
            $this->method],
            self::$router->getParams()
        );
    }

    private function setController($controller)
    {
        $controllerClass = self::CONTROLLERS_NAMESPACE
            . ucfirst($controller)
            . self::CONTROLLERS_SUFFIX;

        if (!class_exists($controllerClass)) {
            throw new \Exception('Controller ' . $controllerClass . 'does not exist');
        }

        $this->controler = new $controllerClass();
    }

    private function setMethod($method)
    {
        if (!method_exists($this->controler, $method)) {
            throw new \Exception('Method ' . $method .' in class '
                . get_class($this->controler) . ' does not exist');
        }

        $this->method = $method;
    }

    /**
     * @todo replace DefaultRouter with IRouter
     * @return \MyMVC\Library\Routing\DefaultRouter
     */
    public static function getRouter()
    {
        return self::$router;
    }

    private function checkAuthorisation($controller, $method)
    {

    }

    /**
     *
     * @param string $path url in format
     * [route]/[controller]/[action]/[param]/[param]/...
     */
    public static function redirectPath($path)
    {
        $path = str_replace('\\', '/', $path);
        $path = trim($path, '/');

        $components = explode('/', $path);
        $route = array_shift($components);
        $controller = array_shift($components);
        $action = array_shift($components);

        self::redirect($route, $controller, $action, $components);
    }

    public static function redirect($route = null, $controler = null, $action = null,
        $params = [])
    {
        $url = App::buildUrl(null, $route,
            $controler, $action, $params);

        header("Location: {$url}");
        exit();
    }

    public static function buildUrl($lang = null, $route = null,
        $controler = null, $action = null, $params = [])
    {
        $url = LINK_PREFIX;

        if ($lang == null) {
            $storedLang = Storage::get('lang');
            if ($storedLang != null && $storedLang != Config::get('defaultLanguage')) {
                $url .= "/{$storedLang}";
            }
        } else {
            $url .= "/{$lang}";
        }

        if ($route !== null && $route !== Config::get('defaultRoute')) {
            $url .= "/{$route}";
        }

        if ($controler !== null) {
            $url .= "/{$controler}";
        }

        if ($action !== null) {
            $url .= "/{$action}";

            foreach ($params as $param) {
                $url .= "/{$param}";
            }
        }

        return $url;
    }

    public static function csrfToken()
    {
        return hash('sha256', uniqid());
    }
}