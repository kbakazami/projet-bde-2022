<?php

namespace App\Controller;

use App\Routing\Attribute\Route;
use App\Utils\Form;


class EventAdmincontroller extends AbstractController
{

    #[Route(path: "/form-event")]
    public function formEvent()
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

        echo $this->twig->render('admin/event/form-event.html.twig');

    }

    #[Route(path: "/list-event")]
    public function listEvent()
    {

        echo $this->twig->render('admin/event/list-event.html.twig');

    }

}