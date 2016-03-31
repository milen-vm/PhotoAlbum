<?php
namespace MyMVC\Application\Controllers;

use MyMVC\Library\MVC\View;
use MyMVC\Application\ViewModels\FormAlbumViewModel;
use MyMVC\Library\App;
use MyMVC\Library\MVC\Controller;

class AlbumController extends Controller
{

//     public function __construct()
//     {
//         parent::__construct();
//     }

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