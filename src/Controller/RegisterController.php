<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\User;
use App\Utils\Form;
use App\Form\LoginType;
use App\Routing\Attribute\Route;
use App\Repository\UserRepository;
use App\Session\Session;
use DateTime;


class RegisterController extends AbstractController
{
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



        echo $this->twig->render('register/register.html.twig', [
            "formulaire" => $formulaire
        ]);
    }

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    #[Route(path: "/register-add", name: "register-add", httpMethod: "POST")]
    public function registerAdd(UserRepository $userRepository)
    {

        //var_dump($_POST);

        $user = $_POST;
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

    private function setImage(string $string)
    {
    }

}
