<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Routing\Attribute\Route;
use App\Utils\Validator;
use App\Repository\EventRepository;


class CategoryAdminController extends AbstractController
{
    #[Route(path: "/admin/form-create-category", name: "create-form-category")]
    public function createFormCategory()
    {
        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin') {
            echo $this->twig->render('/access.html.twig');
        } else {

            echo $this->twig->render('admin/category/form-category.html.twig');
        }
    }

    #[Route(path: "/admin/create-category", name: "create-category", httpMethod: "POST")]
    public function createCategory(CategoryRepository $categoryRepository)
    {

        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin') {
            echo $this->twig->render('/access.html.twig');
        } else {

            $validator = new Validator($_POST);

            $validator->required("title", "color")
                ->length("title", 2, 250)
                ->length("color", 2, 50);


            if ($validator->isValid()) {
                $category = new Category();
                $category->setTitle($_POST['title'])
                    ->setColor($_POST['color']);

                $categoryRepository->save($category);
            }
            $errors = $validator->getErrors();

            if (!empty($errors)) {
                echo $this->twig->render('admin/category/form-category.html.twig', [
                    'errors' => $errors
                ]);
            } else {
                header('Location: /admin/list-category');
            }
        }
    }

    #[Route(path: "/admin/list-category", name: "admin-list-category")]
    public function listCategory(CategoryRepository $categoryRepository)
    {
        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin') {
            echo $this->twig->render('/access.html.twig');
        } else {

            $category = $categoryRepository->findAllCategoryCountEvent();

            echo $this->twig->render('admin/category/list-category.html.twig', [
                'category' => $category
            ]);
        }
    }

    #[Route(path: "/admin/liste-event-by-cat/{id}", name: "admin-list-event-by-cat")]
    public function listEventByCat(EventRepository $eventRepository, int $id, CategoryRepository $categoryRepository)
    {
        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin') {
            echo $this->twig->render('/access.html.twig');
        } else {
            $events = $eventRepository->findEventByCate($id);
            $category = $categoryRepository->findCategoryById($id);
            $lesEvent = [];
            
            foreach($events as $events){
                $nb = $eventRepository->CountUserByEvent($events->id_event); 
                $lesEvent[]=["event" => $events, "nb" => $nb];
            }

            echo $this->twig->render('admin/category/list-event-by-category.html.twig',[
                'events' => $lesEvent,
                'category' => $category
            ]);
        }
    }

    #[Route(path: "/admin/form-edit-category/{id}", name: "form-edit-category")]
    public function editFormCategory(CategoryRepository $categoryRepository, int $id)
    {
        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin') {
            echo $this->twig->render('/access.html.twig');
        } else {
            $category = $categoryRepository->findCategoryById($id);

            echo $this->twig->render('admin/category/edit-category.html.twig', [
                'category' => $category
            ]);
        }
    }

    #[Route(path: "/admin/update-category/{id}", httpMethod: "POST", name: "update-category")]
    public function updateCategory(CategoryRepository $categoryRepository, int $id)
    {
        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin') {
            echo $this->twig->render('/access.html.twig');
        } else {

            $category = $categoryRepository->findCategoryById($id);
            $validator = new Validator($_POST);

            $validator->required("title", "color")
                ->length("title", 2, 250)
                ->length("color", 2, 50);

            if ($validator->isValid()) {
                $categoryUpdate = new Category();
                $categoryUpdate->setTitle($_POST['title'])
                    ->setColor($_POST['color']);

                $categoryRepository->updateCategory($categoryUpdate, $id);
            }

            $errors = $validator->getErrors();

            if (!empty($errors)) {
                echo $this->twig->render('admin/category/form-category.html.twig', [
                    'errors' => $errors,
                    'category' => $category
                ]);
            } else {
                header('Location: /admin/list-category');
            }
        }
    }

    #[Route(path: "/admin/delete-category/{id}", name: "delete-category")]
    public function deleteCategory(CategoryRepository $categoryRepository, int $id)
    {
        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin') {
            echo $this->twig->render('/access.html.twig');
        } else {

            $categoryRepository->setParDefaut($id);
            $categoryRepository->deleteCategory($id);

            $message = "La catégorie a bien été supprimée";

            header('Location: /admin/list-category');

            echo $this->twig->render('admin/category/list-category.html.twig', [
                'message' => $message
            ]);
        }
    }
}