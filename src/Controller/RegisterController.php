<?php

namespace App\Controller;

use App\Entity\User;
use App\Routing\Attribute\Route;
use App\Repository\UserRepository;
use App\Utils\Validator;
use DateTime;


class RegisterController extends AbstractController
{
<<<<<<< HEAD
    #[Route(path: "/register", name: "register")]
    public function register()
    {
        $errors = [];

        $form = new Form($errors);

        $formulaire = [
            $form->input("nom", "Nom", "text", "nom"),
            $form->input("prenom", "Prénom", "text", "prénom"),
            $form->input("mail", "Email", "email","adresse email"),
            $form->input("date", "Date de naissance", "date","date de naissance"),
            $form->input("password", "Mot de passe", "password","mot de passe"),
            $form->input("confirmPassword", "Confirmation du mot de passe", "password","confirmation du mot de passe"),
        ];


=======
>>>>>>> crud-users

    #[Route(path: "/form-register", name: "form-register")]
    public function formRegister()
    {
        echo $this->twig->render('register/register.html.twig');
    }

    #[Route(path: "/register", name: "register", httpMethod: "POST")]
    public function register(UserRepository $userRepository,)
    {

        $validator = new Validator($_POST);

        $validator->required("nom", "prenom", "mail", "date", "password", "confirmPassword")
            ->length("nom", 2, 250)
            ->length("prenom", 2, 50)
            ->mailPattern("mail")
            ->dateTime("date")
            ->confirmPasword("password", "confirmPassword");

        if ($validator->isValid()) {
            $user = new User();
            $user->setFirstName($_POST['prenom'])
                ->setLastName($_POST['nom'])
                ->setEmail($_POST['mail'])
                ->setPassword($_POST['password'])
                ->setBirthDate(new DateTime($_POST['date']))
                ->setImage("");

            $userRepository->save($user);
            header("location: /login");
        }
        $errors = $validator->getErrors();

        echo $this->twig->render('register/register.html.twig', [
            "errors" => $errors
        ]);
    }
}
