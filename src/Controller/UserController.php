<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\RoleRepository;
use App\Routing\Attribute\Route;
use App\Repository\UserRepository;
use App\Utils\UploadFiles;
use App\Utils\Validator;
use DateTime;
use App\Repository\EventRepository;

class UserController extends AbstractController
{
    // Affichage des informations de l'utilisateur et de ses events
    #[Route(path: "/my-account", name: "my-account")]
    public function myAccount(UserRepository $userRepository, EventRepository $eventRepository)
    {
        $message ="";
        $userId = $_SESSION["userId"];
        $user = $userRepository->findUserById($userId);

        $events = $eventRepository->findAllEventByUser($userId);
        $lesEvent = [];
        
        foreach($events as $events){
            $nb = $eventRepository->CountUserByEvent($events->id_event); 
            $lesEvent[]=["event" => $events, "nb" => $nb];
        }

        echo $this->twig->render('/user/account.html.twig',[
            'user' => $user,
            'events' => $lesEvent,
            'message' => $message
        ]);
    }

    // Suppression d'un evenement (bouton suppression sur les evenements de l'utilisateur)
    #[Route(path: "/my-account/delet-event/{id}", name: "my-account/delet-event")]
    public function deletEventUser(UserRepository $userRepository, EventRepository $eventRepository, int $id)
    {
        $userId = $_SESSION["userId"];
        $user = $userRepository->findUserById($userId);

        $desincrire = $eventRepository->desinscrire($id, $_SESSION["userId"]);
        $message="Vous êtes désinscrit de l'événement";  

        $events = $eventRepository->findAllEventByUser($userId);
        $lesEvent = [];
        
        foreach($events as $events){
            $nb = $eventRepository->CountUserByEvent($events->id_event); 
            $lesEvent[]=["event" => $events, "nb" => $nb];
        }

        echo $this->twig->render('/user/account.html.twig',[
            'user' => $user,
            'events' => $lesEvent,
            'message' => $message
        ]);
    }

    // Validation des modifications de l'utilisateur
    #[Route(path: "/update-user/{id}", httpMethod: "POST", name: "update-user")]
    public function updateUser(UserRepository $userRepository, int $id)
    {
        $user = $userRepository->findUserById($id);
        $validator = new Validator($_POST);
        $image = new UploadFiles($_FILES['file']);

        if (password_verify($_POST['oldPassword'], $user->password))
        {
            $validator->confirmPasword("password", "confirmPassword")
                ->imagePattern($image->getTypeFile());

            if($validator->isValid())
            {
                $userUpdate = new User();
                $userUpdate->setFirstName($_POST['prenom'])
                    ->setLastName($_POST['nom'])
                    ->setEmail($_POST['mail'])
                    ->setBirthDate(new DateTime($_POST['date']))
                    ->setPassword($_POST['password'])
                    ->setIdRole("10")
                    ->setImage($image->upload());

                $userRepository->updateUser($userUpdate, $id);
            }
        }

        $errors = $validator->getErrors();

        if(!empty($errors))
        {
            echo $this->twig->render('/user/account.html.twig',[
                'errors'=>$errors,
                'user'=>$user
            ]);
        }
        else
        {
            header('Location: /my-account');
        }
    }
}