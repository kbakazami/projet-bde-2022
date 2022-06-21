<?php

namespace App\Controller;

use App\Entity\User;
use App\Routing\Attribute\Route;
use App\Repository\UserRepository;
use App\Utils\Validator;
use DateTime;


class RegisterController extends AbstractController
{

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
            ->mailExist("mail", $userRepository)
            ->dateTime("date")
            ->confirmPasword("password", "confirmPassword");

        if ($validator->isValid()) {
            $user = new User();
            $user->setFirstName($_POST['prenom'])
                ->setLastName($_POST['nom'])
                ->setEmail($_POST['mail'])
                ->setPassword($_POST['password'])
                ->setBirthDate(new DateTime($_POST['date']))
                ->setIdRole("10")
                ->setImage("");

            $userRepository->save($user);
            header("location: /form-login");
        }
        $errors = $validator->getErrors();

        echo $this->twig->render('register/register.html.twig', [
            "errors" => $errors
        ]);
    }
}
