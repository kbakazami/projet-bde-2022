<?php

namespace App\Controller;

use App\Utils\Form;
use App\Routing\Attribute\Route;
use App\Repository\UserRepository;
use App\Session\Session;

class LoginController extends AbstractController
{
    #[Route(path: "/form-login", name: "form-login")]
    public function formLogin()
    {
        echo $this->twig->render('login/login.html.twig');
    }


    #[Route(path: "/login", name: "login", httpMethod: "POST")]
    public function login(UserRepository $userRepository)
    {

        if (isset($_POST['mail']) && isset($_POST['password'])) {
            $check = $userRepository->verifUser($_POST['mail']);

            if ($check) {
                if (password_verify($_POST['password'], $check->password)) {

                    $session = new Session();
                    $session->set('userId', $check->id);
                    header("location: /");
                }
            }
        }
    }

    #[Route(path: "/logout", name: "logout")]
    public function logout()
    {
        if (!isset($_SESSION)) {
            $session = new Session();
            $session->destroy();
        }

        echo $this->twig->render('index/home.html.twig');
    }
}
