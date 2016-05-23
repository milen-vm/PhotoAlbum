<?php
namespace MyMVC\Application\Controllers;

use MyMVC\Library\MVC\View;
use MyMVC\Application\ViewModels\FormAlbumViewModel;
use MyMVC\Library\App;
use MyMVC\Library\MVC\Controller;

class AlbumController extends Controller
{

    /**
     *
     * @AUTH default\user\login
     * redirect if user is not authenticated, is not loggedin
     *
     * @return \MyMVC\Library\MVC\View
     */
    public function create()
    {
        $csrfToken = App::csrfToken();
        $createForm = new FormAlbumViewModel($csrfToken);

        if ($this->isMethodPost()) {
            $createForm->setParams($_POST);
        }

        return new View($createForm);
    }
}