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
      $form->input("mail", "Email", "email"),
      $form->input("password", "password", "password"),
    ];

    echo $this->twig->render('login/login.html.twig', [
      "formulaire" => $formulaire
    ]);
  }

  #[Route(path: "/connect", name: "connect",  httpMethod: "POST")]
  public function connect(UserRepository $userRepository)
  {

      if(isset($_POST['mail']) && isset($_POST['password'])) {
          $check = $userRepository->verifUser($_POST['mail']);

          if ($check) {

              if (password_verify($_POST['password'], $check->password)) {

                $session = new Session();
                $session->set('userId', $check->id);

              } else {
                  echo "<p>error</p>";
              }
          }
      }else{
          header('Location: /login');
      }

//    // var_dump($_POST['mail']);
//    if (!empty($_POST)) {
//      if (!empty($_POST["mail"]) || !empty($_POST["password"])) {
//        $errors['password'] = 'identifiant ou mot de passe incorrect';
//      }
//
//      $user = $repository->findByMail($_POST["mail"]);
//      $user->getPassword();
//      $_POST['password'];
//      if (password_verify($_POST['password'], $user->getPassword()) === true) {
//        if (!isset($_SESSION)) {
//          $session = new Session();
//          $session->set('auth', $user->getId());
//        }
//        // var_dump($_SESSION["auth"]);
//        echo $this->twig->render('login/connect.html.twig');
//      }else {
//        echo '<p>Connexion à échoué</p>';
//      }
//    }
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
