<?php
namespace MyMVC\Library\MVC;

abstract class ViewModel
{

    protected $csrfToken = '';

    protected $csrfTokenFromPost = '';

    private $alerts = [];

    public function getCsrfToken()
    {
        return $this->csrfToken;
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