<?php

namespace App\Controller;

use App\Utils\Form;
use App\Form\LoginType;
use App\Routing\Attribute\Route;
use App\Repository\UserRepository;
use App\Session\Session;

class RegisterController extends AbstractController
{
    #[Route(path: "/register", name: "register")]
    public function login()
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

}
