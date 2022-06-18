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
        echo $this->twig->render('admin/role/form-role.html.twig');
    }

    #[Route(path: "/admin/create-role", name: "create-role", httpMethod: "POST")]
    public function createRole(RoleRepository $roleRepository)
    {
        $validator = new Validator($_POST);

        $validator->required("name")
            ->length("name", 2, 250);


        if ($validator->isValid()) {
            $role = new Role();
            $role->setName($_POST['name']);


            $roleRepository->save($role);
        }
        $errors = $validator->getErrors();

        if(!empty($errors)) {
            echo $this->twig->render('admin/role/form-role.html.twig', [
                'errors' => $errors,
            ]);
        } else {
            header('Location: /admin/list-role');
        }
    }

    #[Route(path: "/admin/list-role", name: "list-role")]
    public function listRole(RoleRepository $roleRepository)
    {
        $roles = $roleRepository->findAllRole();

        echo $this->twig->render('admin/role/list-role.html.twig', [
            'roles' => $roles
        ]);
    }

    #[Route(path: "/admin/form-update-role/{id}", name: "form-update-role")]
    public function formUpdateRole(RoleRepository $roleRepository,int $id)
    {
        $role = $roleRepository->findRoleById($id);

        echo $this->twig->render('admin/role/edit-role.html.twig', [
            'role' => $role
        ]);
    }

    #[Route(path: "/admin/update-role/{id}", name: "update-role", httpMethod: "POST")]
    public function updateRole(RoleRepository $roleRepository,int $id)
    {
        $role = $roleRepository->findRoleById($id);
        $validator = new Validator($_POST);

        $validator->required("name")
            ->length("name", 2, 250);

        if ($validator->isValid()) {
            $roleUpdate = new Role();
            $roleUpdate->setName($_POST['name']);

            $roleRepository->updateRole($roleUpdate, $id);
        }
        $errors = $validator->getErrors();

        if(!empty($errors)) {
            echo $this->twig->render('admin/role/edit-role.html.twig', [
                'errors' => $errors,
                'role' => $role
            ]);
        } else {
            header('Location: /admin/list-role');
        }
    }

    #[Route(path: "/admin/delete-role/{id}", name: "delete-role")]
    public function deleteRole(RoleRepository $roleRepository,int $id)
    {
        $roleRepository->deleteRole($id);
        header('Location: /admin/list-role');
    }
}