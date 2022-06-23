<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\RoleRepository;
use App\Routing\Attribute\Route;
use App\Repository\UserRepository;
use App\Utils\Validator;
use DateTime;


class UserAdminController extends AbstractController
{

    // Affichage de la liste des utilisateur par ordre alphabétique
    #[Route(path: "/admin/list-user", name: "list-user")]
    public function listUser(UserRepository $userRepository)
    {
        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin') {
            echo $this->twig->render('/access.html.twig');
        } else {

            $users = $userRepository->findAllUser();

            echo $this->twig->render('/admin/user/list-user.html.twig', [
                'users' => $users
            ]);
        }
    }

    // Formulaire de créationn d'utilisateur
    #[Route(path: "/admin/form-create-user", name: "create-form-user")]
    public function createFormUser(RoleRepository $roleRepository,)
    {
        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if($_SESSION['userRole'] !== 'Admin') {
            echo $this->twig->render('/access.html.twig');
        }else {

            $role = $roleRepository->findAllRole();
            echo $this->twig->render('/admin/user/form-user.html.twig', [
                'role' => $role
            ]);
        }
    }

    // Validation du formulaire de création d'user
    #[Route(path: "/admin/create-user", name: "create-user", httpMethod: "POST")]
    public function createUser(UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $role = $roleRepository->findAllRole();

        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin') {
            echo $this->twig->render('/access.html.twig');
        } else {

            $validator = new Validator($_POST);

            $validator->required("nom", "prenom", "mail", "password", "confirmPassword")
                ->length("nom", 2, 250)
                ->length("prenom", 2, 50)
                ->length("password", 2, 50)
                ->mailPattern("mail")
                ->dateTime("date")
                ->confirmPasword("password", "confirmPassword")
                ->select('role');

            if ($validator->isValid()) {
                $user = new User();
                $user->setFirstName($_POST['prenom'])
                    ->setLastName($_POST['nom'])
                    ->setEmail($_POST['mail'])
                    ->setPassword($_POST['password'])
                    ->setBirthDate(new DateTime($_POST['date']))
                    ->setIdRole(intVal($_POST['role']))
                    ->setImage("");

                $userRepository->save($user);

            }
            $errors = $validator->getErrors();

            if (!empty($errors)) {
                echo $this->twig->render('admin/user/form-user.html.twig', [
                    'errors' => $errors,
                    'role' => $role
                ]);
            } else {
                header('Location: /admin/list-user');
            }
        }
    }

    // Formulaire d'edition d'utilisateur
    #[Route(path: "/admin/form-edit-user/{id}", name: "edit-form-user")]
    public function editFormUser(UserRepository $userRepository, RoleRepository $roleRepository, int $id)
    {
        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin') {
            echo $this->twig->render('/access.html.twig');
        } else {
            $user = $userRepository->findUserById($id);

            $role = $roleRepository->findAllRole();
            echo $this->twig->render('admin/user/edit-user.html.twig', [
                'user' => $user,
                'role' => $role
            ]);
        }
    }

    // Formulaire de modification d'utilisateur
    #[Route(path: "/admin/update-user/{id}", name: "update-user", httpMethod: "POST")]
    public function updateUser(UserRepository $userRepository,int $id)
    {

        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin') {
            echo $this->twig->render('/access.html.twig');
        } else {

            $user = $userRepository->findUserById($id);
            $validator = new Validator($_POST);

            $validator->required("nom", "prenom", "mail")
                ->length("nom", 2, 250)
                ->length("prenom", 2, 50)
                ->mailPattern("mail")
                ->dateTime("date")
                ->select('role');

            if ($validator->isValid()) {
                $userUpdate = new User();
                $userUpdate->setFirstName($_POST['prenom'])
                    ->setLastName($_POST['nom'])
                    ->setEmail($_POST['mail'])
                    ->setBirthDate(new DateTime($_POST['date']))
                    ->setIdRole(intVal($_POST['role']))
                    ->setImage("");

                $userRepository->updateUser($userUpdate, $id);
            }

            $errors = $validator->getErrors();

            if (!empty($errors)) {
                echo $this->twig->render('admin/user/edit-user.html.twig', [
                    'errors' => $errors,
                    'user' => $user
                ]);
            } else {
                header('Location: /admin/list-user');
            }
        }
    }

    // Suppression d'un utilisateur avec le lien entre lui et les evenements
    #[Route(path: "/admin/delete-user/{id}", name: "delete-user")]
    public function deleteUser(UserRepository $userRepository,int $id)
    {
        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if($_SESSION['userRole'] !== 'Admin') {
            echo $this->twig->render('/access.html.twig');
        }else {
            $userRepository->deleteUserParticiper($id);
            $userRepository->deleteUser($id);
            header('Location: /admin/list-user');
        }
    }

     // Recherche 
     #[Route(path: "/admin/recherche-crud-user", name: "recherhce-crud-user", httpMethod: "POST")]
     public function rechercheCrudUser(UserRepository $userRepository)
     {
         if (!isset($_SESSION['userRole'])) {
             header('Location: /form-login');
         }
         if ($_SESSION['userRole'] !== 'Admin') {
             echo $this->twig->render('/access.html.twig');
         } else {
 
            if($_POST["search"] != ""){
                $users = $userRepository->findAllSearch($_POST["search"]); 
            }else{
                $users = $userRepository->findAllUser();
            }
            
            echo $this->twig->render('/admin/user/list-user.html.twig', [
                'users' => $users
            ]);
         }
     }
}
