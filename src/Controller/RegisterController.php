<?php

namespace App\Controller;

use App\Entity\User;
use App\Utils\Form;
use App\Form\LoginType;
use App\Routing\Attribute\Route;
use App\Repository\UserRepository;
use DateTime;


class RegisterController extends AbstractController
{
    #[Route(path: "/register", name: "register")]
    public function register()
    {
        $errors = [];

        $form = new Form($errors);

        $formulaire = [
            $form->input("nom", "Nom", "text"),
            $form->input("prenom", "Prénom", "text"),
            $form->input("mail", "Email", "email"),
            $form->input("date", "Date de naissance", "date"),
            $form->input("password", "Mot de passe", "password"),
            $form->input("confirmPassword", "Confirmation du mot de passe", "password"),
        ];

        echo $this->twig->render('register/register.html.twig', [
            "formulaire" => $formulaire
        ]);
    }


    #[Route(path: "/register-add", name: "register-add", httpMethod: "POST")]
    public function registerAdd(UserRepository $userRepository)
    {
        $mailExist = $userRepository->findByMail($_POST['mail']);

       if($mailExist === true){
           echo "<p>Cet email existe déjà !</p>";

        }else{
           $user = new User();
           $user->setFirstName($_POST['prenom'])
               ->setLastName($_POST['nom'])
               ->setEmail($_POST['mail'])
               ->setPassword($_POST['password'])
               ->setBirthDate(new DateTime($_POST['date']))
               ->setImage("");


           $userRepository->save($user);

           echo $this->twig->render('register/register.html.twig');
       }



    }

}
