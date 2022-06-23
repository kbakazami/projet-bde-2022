<?php

namespace App\Controller;

use App\Routing\Attribute\Route;
use App\Repository\UserRepository;
use App\Session\Session;
use App\Session\SessionInterface;

class LoginController extends AbstractController
{
    // Affichage du formulaire de connexion
    #[Route(path: "/form-login", name: "form-login")]
    public function formLogin()
    {
        echo $this->twig->render('login/login.html.twig');
    }

    // Verification des données dans le formulaire de connexion
    #[Route(path: "/login", name: "login", httpMethod: "POST")]
    public function login(UserRepository $userRepository)
    {

        if (isset($_POST['mail']) && isset($_POST['password'])) {
            $check = $userRepository->verifUser($_POST['mail']);

            if ($check) {
                if (password_verify($_POST['password'], $check->password)) {

                    $session = new Session();
                    $session->set('userId', $check->id);
                    $session->set('userRole', $check->title);
                    header("location: /");
                }else{
                    $message = 'Email ou Mot de passe incorrecte';
                    echo $this->twig->render('login/login.html.twig', [
                        'message' => $message
                    ]);
                }
            }else{
                $message = 'Email ou Mot de passe incorrecte';
                echo $this->twig->render('login/login.html.twig', [
                    'message' => $message
                ]);
            }
        }
    }

    // Deconnexion
    #[Route(path: "/logout", name: "logout")]
    public function logout(SessionInterface $session)
    {
        if (isset($_SESSION)) {
            $session->destroy();
        }
        header('location: /');
    }
}
