<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\RoleRepository;
use App\Routing\Attribute\Route;
use App\Repository\UserRepository;
use App\Utils\UploadFiles;
use App\Utils\Validator;
use DateTime;

class UserController extends AbstractController
{
    #[Route(path: "/my-account", name: "my-account")]
    public function myAccount(UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $userId = $_SESSION["userId"];
        $user = $userRepository->findUserById($userId);
        $role = $roleRepository->findAllRole();

        echo $this->twig->render('/user/account.html.twig',[
            'user' => $user,
            'role' => $role
        ]);
    }

    #[Route(path: "/update-user/{id}", httpMethod: "POST", name: "update-user")]
    public function updateUser(UserRepository $userRepository, int $id)
    {
        $user = $userRepository->findUserById($id);
        $validator = new Validator($_POST);
        $image = new UploadFiles($_FILES['file']);

        $validator->confirmPasword("password", "confirmPassword")
            ->imagePattern($image->getTypeFile());

        if($validator->isValid())
        {
            $userUpdate = new User();
            $userUpdate->setPassword($_POST['password'])
                ->setImage($image->upload());

            $userRepository->updateUser($userUpdate, $id);
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