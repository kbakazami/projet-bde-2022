<?php

namespace App\Controller;

use App\Routing\Attribute\Route;


class AdminController extends AbstractController
{
    #[Route(path: "/admin")]
    public function index()
    {
        $title = 'admin';
        echo $this->twig->render('admin/base-admin.html.twig',[
            'title' => $title
        ]);

    }

}