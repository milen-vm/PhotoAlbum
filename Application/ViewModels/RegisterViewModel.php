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

    public function getEmail()
    {
        return $this->email;
    }

    private function setEmail($email)
    {
        $this->email = trim($email);
    }

    public function getName()
    {
        return $this->name;
    }

    private function setName($name)
    {
        $this->name = trim($name);
    }

    public function getPassword()
    {
        return $this->password;
    }

    private function setPassword($password)
    {
        $this->password = trim($password);
    }

    private function setConfPassword($confPassowrd)
    {

        $this->confPassword = trim($confPassowrd);
    }

    public function validate()
    {
        $this->validation->setRule($this->email, 'required', '', 'Email is required.');
        $this->validation->setRule($this->email, 'email', '', 'Invalid email.');
        $this->validation->setRule($this->name, 'required', '', 'Full name is required.');
        $this->validation->setRule($this->password, 'required', '', 'Password is required.');
        $this->validation->setRule($this->password, 'notContains', ' ',
            'Password can not conatains white spaces.');
        $this->validation->setRule($this->confPassword, 'matched', $this->password,
            'Password confirmation do not match.');

        return $this->validation->validate();
    }

    public function getErrorMessage()
    {
        $errors = $this->validation->getErrors();

        return implode(' ', $errors);
    }
}