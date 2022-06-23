<?php

namespace App\Controller;

use App\Entity\Role;
use App\Repository\RoleRepository;
use App\Routing\Attribute\Route;
use App\Utils\Validator;


class RoleAdminController extends AbstractController
{
    // Formulaire de création de rôle
    #[Route(path: "/admin/form-create-role", name: "create-form-role")]
    public function createFormRole()
    {

        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin') {
            echo $this->twig->render('/access.html.twig');
        } else {
            echo $this->twig->render('admin/role/form-role.html.twig');
        }

    }

    // Validation de la création de rôle
    #[Route(path: "/admin/create-role", name: "create-role", httpMethod: "POST")]
    public function createRole(RoleRepository $roleRepository)
    {

        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin') {
            echo $this->twig->render('/access.html.twig');
        } else {


            $validator = new Validator($_POST);

            $validator->required("title")
                ->length("title", 2, 250);


            if ($validator->isValid()) {
                $role = new Role();
                $role->setTitle($_POST['title']);


                $roleRepository->save($role);
            }
            $errors = $validator->getErrors();

            if (!empty($errors)) {
                echo $this->twig->render('admin/role/form-role.html.twig', [
                    'errors' => $errors,
                ]);
            } else {
                header('Location: /admin/list-role');
            }
        }
    }

    // Affichage de la liste des rôles
    #[Route(path: "/admin/list-role", name: "list-role")]
    public function listRole(RoleRepository $roleRepository)
    {
        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin' && $_SESSION['userRole'] !== 'BDE') {
            echo $this->twig->render('/access.html.twig');
        } else {

            $roles = $roleRepository->findAllRole();
            $admin = $_SESSION['userRole'];

            echo $this->twig->render('admin/role/list-role.html.twig', [
                'roles' => $roles,
                'admin' => $admin
            ]);
        }
    }

    // Formulaire de modification des rôles
    #[Route(path: "/admin/form-update-role/{id}", name: "form-update-role")]
    public function formUpdateRole(RoleRepository $roleRepository,int $id)
    {
        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin') {
            echo $this->twig->render('/access.html.twig');
        } else {

            $role = $roleRepository->findRoleById($id);

            echo $this->twig->render('admin/role/edit-role.html.twig', [
                'role' => $role
            ]);
        }
    }

    // Validation de l'edition du rôle
    #[Route(path: "/admin/update-role/{id}", name: "update-role", httpMethod: "POST")]
    public function updateRole(RoleRepository $roleRepository, int $id)
    {
        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin') {
            echo $this->twig->render('/access.html.twig');
        } else {

            $role = $roleRepository->findRoleById($id);
            $validator = new Validator($_POST);

            $validator->required("title")
                ->length("title", 2, 250);

            if ($validator->isValid()) {
                $roleUpdate = new Role();
                $roleUpdate->setTitle($_POST['title']);

                $roleRepository->updateRole($roleUpdate, $id);
            }
            $errors = $validator->getErrors();

            if (!empty($errors)) {
                echo $this->twig->render('admin/role/edit-role.html.twig', [
                    'errors' => $errors,
                    'role' => $role
                ]);
            } else {
                header('Location: /admin/list-role');
            }
        }
    }

    // Suppression d'un rôle avec mise au rôle "user" pour les utilsiateur qui avait le rôle
    #[Route(path: "/admin/delete-role/{id}", name: "delete-role")]
    public function deleteRole(RoleRepository $roleRepository,int $id)
    {
        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin') {
            echo $this->twig->render('/access.html.twig');
        } else {
            $roleRepository->setDefaultRole($id);
            $roleRepository->deleteRole($id);
            header('Location: /admin/list-role');
        }
    }
}