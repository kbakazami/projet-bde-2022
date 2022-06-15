<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Routing\Attribute\Route;



class EventAdmincontroller extends AbstractController
{

    #[Route(path: "/admin/form-event", name: "form-event")]
    public function formEvent(CategoryRepository $categoryRepository)
    {
        $category = $categoryRepository->findAllCategory();

        echo $this->twig->render('admin/event/form-event.html.twig', [
                'category' => $category
            ]);
    }

    #[Route(path: "/admin/create-event", name: "create-event", httpMethod: "POST")]
    public function createEvent()
    {



//        $validator = new Validator($_POST);
//
//        $validator->required("nom", "prenom", "mail", "date", "password", "confirmPassword")
//            ->length("nom", 2, 250)
//            ->length("prenom", 2, 50)
//            ->mailPattern("mail")
//            ->dateTime("date")
//            ->confirmPasword("password", "confirmPassword");
//
//        if ($validator->isValid()) {
//            $user = new Event();
//            $user->setFirstName($_POST['prenom'])
//                ->setLastName($_POST['nom'])
//                ->setEmail($_POST['mail'])
//                ->setPassword($_POST['password'])
//                ->setBirthDate(new DateTime($_POST['date']))
//                ->setImage("");
//
//            $userRepository->save($user);
//            header("location: /login");
//        }
//        $errors = $validator->getErrors();

        echo $this->twig->render('admin/event/form-event.html.twig');
    }



    #[Route(path: "/list-event")]
    public function listEvent()
    {

        echo $this->twig->render('admin/event/list-event.html.twig');

    }

}