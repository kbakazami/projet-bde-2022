<?php

namespace App\Controller;

use App\Routing\Attribute\Route;


class AdminController extends AbstractController
{
    // Test si le personne a les droits admin
    #[Route(path: "/admin")]
    public function index()
    {
        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if(($_SESSION['userRole'] !== 'Admin') && ($_SESSION['userRole'] !== 'BDE')) {
            echo $this->twig->render('/access.html.twig');
        }else{
            echo $this->twig->render('admin/base-admin.html.twig');
        }
    }

}