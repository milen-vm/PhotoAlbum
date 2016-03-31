<?php
namespace MyMVC\Application\ViewModels;

use MyMVC\Library\MVC\ViewModel;
use MyMVC\Library\Utility\Validation;
use MyMVC\Library\ValidationParser;

class RegisterViewModel extends ViewModel
{

    /**
     *
     * @var string
     * @email Invalid email.
     */
    private $email = '';

    private $name = '';

    private $password = '';

    private $confPassword = '';

    /**
     *
     * @var \MyMVC\Library\Utility\Validation
     */
    private $validation;

    /**
     * @todo add ne validation through Reflection
     *
     * @var \MyMVC\Library\ValidationParser
     */
//     private $validationParser;

    public function __construct($csrfToken)
    {
    	$this->csrfToken = $csrfToken;
    	$this->validation = new Validation();
//     	$this->validationParser = new ValidationParser($this);
    }

    public function setParams($params = [])
    {
        if (isset($params['email'])) {
            $this->setEmail($params['email']);
        } else {
            $this->setEmail('');
        }

        if (isset($params['name'])) {
            $this->setName($params['name']);
        } else {
            $this->setName('');
        }

        if (isset($params['password'])) {
            $this->setPassword($params['password']);
        } else {
            $this->setPassword('');
        }

        if (isset($params['confPassword'])) {
            $this->setConfPassword($params['confPassword']);
        } else {
            $this->setConfPassword('');
        }

        if (isset($params['csrfToken'])) {
            $this->csrfTokenFromPost = $params['csrfToken'];
        }

    }

    public function getEmail()
    {
        return $this->email;
    }

    private function setEmail($email)
    {
        $email = trim($email);
        $this->validation->setRule($email, 'required', '', 'Email is required.');
        $this->validation->setRule($email, 'email', '', 'Invalid email.');
        $this->email = $email;
    }

    public function getName()
    {
        return $this->name;
    }

    private function setName($name)
    {
        $name = trim($name);
        $this->validation->setRule($name, 'required', '', 'Full name is required.');
        $this->name = $name;
    }

    public function getPassword()
    {
        return $this->password;
    }
    private function setPassword($password)
    {
        $password = trim($password);
        $this->validation->setRule($password, 'required', '', 'Password is required.');
        $this->validation->setRule($password, 'notContains', ' ',
            'Password can not conatains white spaces.');
        $this->password = $password;
    }

    private function setConfPassword($confPassowrd)
    {
        $this->validation->setRule(
            $confPassowrd,
            'matched',
            $this->password,
            'Password confirmation do not match.'
        );

        $this->confPassword = $confPassowrd;
    }

    public function validate()
    {
        return $this->validation->validate();
    }

    public function getErrorMessage()
    {
        $errors = $this->validation->getErrors();

        return implode(' ', $errors);
    }
}