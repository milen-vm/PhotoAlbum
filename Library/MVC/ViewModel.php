<?php
namespace MyMVC\Library\MVC;

abstract class ViewModel
{

    protected $csrfToken = '';

    protected $csrfTokenFromPost = '';

    private $alerts = [];

    /**
     *
     * In the html form fields must be with the same names like seters and fields in *ViewModel class
     *
     * @param array $params
     */
    public function setParams($params = [])
    {
        $reflector = new \ReflectionClass($this);
        $properties = $reflector->getProperties();
        //$prop = $reflector->getDefaultProperties(); var_dump($prop);
        if (isset($properties['csrfToken'])) {
            unset($properties['csrfToken']);
        }

        foreach ($properties as $reflProp) {
            $methodName = 'set' . ucfirst($reflProp->name);
            if (!method_exists($this, $methodName)) {
                continue;
            }

            $reflMethod = $reflector->getMethod($methodName);
            $reflMethod->setAccessible(true);

            if (isset($params[$reflProp->name])) {
                $reflMethod->invoke($this, $params[$reflProp->name]);
            } else {
                $reflMethod->invoke($this, '');
            }
        }
//         $properties = $reflector->getProperties(); var_dump($properties);
//         $prop->setAccessible(true);
//         $prop->setValue($this, $value);
    }

    public function getCsrfToken()
    {
        return $this->csrfToken;
    }

    protected function setCsrfTokenFromPost($token)
    {
        $this->csrfTokenFromPost = $token;
    }

    public function isCsrfTokensMatch($csrfToken)
    {
        return $this->csrfTokenFromPost == $csrfToken;
    }

    public function getAlerts()
    {
        return $this->alerts;
    }

    public function setAlert($type, $text)
    {
        $this->alerts[] = [
        'type' => $type,
        'text' => $text
        ];
    }
}