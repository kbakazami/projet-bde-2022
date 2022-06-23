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
        if($_SESSION['userRole'] !== 'Admin') {

            echo "<p>Vous n'avez pas les droits pour accéder à cette page</p>";
        }else{
            echo $this->twig->render('admin/base-admin.html.twig');
        }
    }

}