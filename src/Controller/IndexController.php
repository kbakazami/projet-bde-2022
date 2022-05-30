<?php

namespace App\Controller;

use App\Routing\Attribute\Route;


class IndexController extends AbstractController
{
    #[Route(path: "/")]
    public function index()
    {

        echo $this->twig->render('index/home.html.twig');

    }

}
