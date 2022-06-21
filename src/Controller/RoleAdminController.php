<?php

namespace App\Controller;

use App\Entity\Role;
use App\Repository\RoleRepository;
use App\Routing\Attribute\Route;
use App\Utils\Validator;


class RoleAdminController extends AbstractController
{
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

    #[Route(path: "/admin/list-role", name: "list-role")]
    public function listRole(RoleRepository $roleRepository)
    {
        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin') {
            echo $this->twig->render('/access.html.twig');
        } else {

            $roles = $roleRepository->findAllRole();

            echo $this->twig->render('admin/role/list-role.html.twig', [
                'roles' => $roles
            ]);
        }
    }

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

    #[Route(path: "/admin/delete-role/{id}", name: "delete-role")]
    public function deleteRole(RoleRepository $roleRepository,int $id)
    {
        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin') {
            echo $this->twig->render('/access.html.twig');
        } else {
            $roleRepository->deleteRole($id);
            header('Location: /admin/list-role');
        }
    }
}