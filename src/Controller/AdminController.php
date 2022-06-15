<?php

namespace App\Controller;

use App\Routing\Attribute\Route;


class AdminController extends AbstractController
{
    #[Route(path: "/admin")]
    public function index()
    {

        echo $this->twig->render('admin/admin.html.twig');

    }

}