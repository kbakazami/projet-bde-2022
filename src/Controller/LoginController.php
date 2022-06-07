<?php

namespace App\Controller;

use App\Utils\Form;
use App\Form\LoginType;
use App\Routing\Attribute\Route;
use App\Repository\UserRepository;
use App\Session\Session;

class LoginController extends AbstractController
{
  #[Route(path: "/login", name: "login")]
  public function login()
  {
    $errors = [];

    $form = new Form($errors);

    $formulaire = [
      $form->input("mail", "Email", "email", "adresse email"),
      $form->input("password", "password", "password", "mot de passe"),
    ];

    echo $this->twig->render('login/login.html.twig', [
      "formulaire" => $formulaire
    ]);
  }

  #[Route(path: "/connect", name: "connect",  httpMethod: "POST")]
  public function connect(UserRepository $repository)
  {
    // var_dump($_POST['mail']);
    if (!empty($_POST)) {
      if (!empty($_POST["mail"]) || !empty($_POST["password"])) {
        $errors['password'] = 'identifiant ou mot de passe incorrect';
      }

      $user = $repository->findByMail($_POST["mail"]);
      $user->getPassword();
      $_POST['password'];
      if (password_verify($_POST['password'], $user->getPassword()) === true) {
        if (!isset($_SESSION)) {
          $session = new Session();
          $session->set('auth', $user->getId());
        }
        // var_dump($_SESSION["auth"]);
        echo $this->twig->render('login/connect.html.twig');
      }else {
        echo '<p>Connexion à échoué</p>';
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

    // var_dump($_SESSION);
    echo $this->twig->render('index/home.html.twig');
  }
}
