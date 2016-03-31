<?php
namespace MyMVC\Application\Controllers;

use MyMVC\Library\MVC\Controller;
use MyMVC\Library\MVC\View;
use MyMVC\Application\Models\UserModel;
use MyMVC\Library\Utility\Storage;
use MyMVC\Library\Utility\Session;
use MyMVC\Application\ViewModels\RegisterViewModel;
use MyMVC\Library\App;
use MyMVC\Application\ViewModels\LoginViewModel;
use MyMVC\Application\Exceptions\UserException;
use MyMVC\Library\Utility\Validation;

class UserController extends Controller
{

//     public function __construct()
//     {
//         parent::__construct();
//     }

    public function index()
    {
        return new View();
    }

    /**
     *
     * @loggedin default/home/index
     * redirect if user is already loggedin
     *
     * @throws UserException
     * @return \MyMVC\Library\MVC\View
     */
    public function register()
    {
        $csrfToken = App::csrfToken();
        $registerForm = new RegisterViewModel($csrfToken);

        if (!$this->isMethodPost()) {
            Session::set('csrfToken', $csrfToken);
        }

        if ($this->isMethodPost()) {
            $registerForm->setParams($_POST);

            try {
                if (!$registerForm->isCsrfTokensMatch(Session::get('csrfToken'))) {
                    throw new UserException('Something went wrong. Try again to register.');
                }

                if(!$registerForm->validate()) {
                    throw new UserException($registerForm->getErrorMessage());
                }

                Session::delete('csrfToken');
                $userModel = new UserModel();
                $userModel->register(
                    $registerForm->getName(),
                    $registerForm->getPassword(),
                    $registerForm->getEmail()
                );

                $role = $this->executeLogin($registerForm->getEmail(), $registerForm->getPassword());
                Session::delete('csrfToken');
                App::redirect($role, 'home');
            } catch (UserException $e) {
                Session::set('csrfToken', $csrfToken);
                $registerForm->setAlert('danger', $e->getMessage());
            }
        }

        return new View($registerForm);
    }

    /**
     * @loggedin /
     * redirect if user already loggedin
     *
     * @throws UserException
     * @return \MyMVC\Library\MVC\View
     */
    public function login()
    {
        $csrfToken = App::csrfToken();
        $loginForm = new LoginViewModel($csrfToken);

        if (!$this->isMethodPost()) {
            Session::set('csrfToken', $csrfToken);
        }

        if ($this->isMethodPost()) {
            $loginForm->setParams($_POST);

            try {
                if (!$loginForm->isCsrfTokensMatch(Session::get('csrfToken'))) {
                    throw new UserException('Something went wrong. Try again to login.');
                }

                $role = $this->executeLogin($loginForm->getEmail(), $loginForm->getPassword());
                Session::delete('csrfToken');
                App::redirect($role, 'home');
            } catch (UserException $e) {
                Session::set('csrfToken', $csrfToken);
                $loginForm->setAlert('danger', $e->getMessage());
            }
        }

        return new View($loginForm);
    }

    /**
     *
     * @param string $email
     * @param string $password
     * @return string user role
     */
    private function executeLogin($email, $password)
    {
        $userModel = new UserModel();
        $user = $userModel->login($email, $password);

        Storage::set('name', $user['name']);
        Session::start();
        Session::set('id', $user['id']);
        Session::set('role', $user['role']);

        return $user['role'];
    }

    public function logout()
    {
//         var_dump(session_name());
//         var_dump(session_get_cookie_params());
        Session::destroy();

        App::redirect('user', 'login');
    }
}