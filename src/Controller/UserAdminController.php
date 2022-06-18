<?php

namespace App\Controller;

use App\Entity\User;
use App\Routing\Attribute\Route;
use App\Repository\UserRepository;
use App\Utils\Validator;
use DateTime;


class UserAdminController extends AbstractController
{

    #[Route(path: "/admin/list-user", name: "list-user")]
    public function listUser(UserRepository $userRepository)
    {
       $users = $userRepository->findAllUser();
        echo $this->twig->render('/admin/user/list-user.html.twig',[
            'users' => $users
        ]);
    }

    #[Route(path: "/admin/form-create-user", name: "create-form-user")]
    public function createFormUser(UserRepository $userRepository,)
    {
        echo $this->twig->render('/admin/user/form-user.html.twig');
    }

    #[Route(path: "/admin/create-user", name: "create-user", httpMethod: "POST")]
    public function createUser(UserRepository $userRepository,)
    {
        $validator = new Validator($_POST);

        $validator->required("nom", "prenom", "mail", "password", "confirmPassword")
            ->length("nom", 2, 250)
            ->length("prenom", 2, 50)
            ->length("password", 2, 50)
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

        }
        $errors = $validator->getErrors();

        if(!empty($errors)) {
            echo $this->twig->render('admin/event/form-event.html.twig', [
                'errors' => $errors,
            ]);
        } else {
            header('Location: /admin/list-user');
        }
    }

    #[Route(path: "/admin/form-edit-user/{id}", name: "edit-form-user")]
    public function editFormUser(UserRepository $userRepository,int $id)
    {
        $user = $userRepository->findUserById($id);
        echo $this->twig->render('admin/user/edit-user.html.twig', [
            'user' => $user
        ]);
    }

    #[Route(path: "/admin/update-user/{id}", name: "update-user", httpMethod: "POST")]
    public function updateUser(UserRepository $userRepository,int $id)
    {
        $user = $userRepository->findUserById($id);
        $validator = new Validator($_POST);

        $validator->required("nom", "prenom", "mail")
            ->length("nom", 2, 250)
            ->length("prenom", 2, 50)
            ->mailPattern("mail")
            ->dateTime("date");

        if ($validator->isValid()) {
            $userUpdate = new User();
            $userUpdate->setFirstName($_POST['prenom'])
                ->setLastName($_POST['nom'])
                ->setEmail($_POST['mail'])
                ->setBirthDate(new DateTime($_POST['date']))
                ->setImage("");

            $userRepository->updateUser($userUpdate, $id);
        }
        $errors = $validator->getErrors();

        if(!empty($errors)) {
            echo $this->twig->render('admin/user/edit-user.html.twig', [
                'errors' => $errors,
                'user' => $user
            ]);
        } else {
            header('Location: /admin/list-user');
        }
    }

    #[Route(path: "/admin/delete-user/{id}", name: "delete-user")]
    public function deleteUser(UserRepository $userRepository,int $id)
    {
        $userRepository->deleteUser($id);
        header('Location: /admin/list-user');
    }
}