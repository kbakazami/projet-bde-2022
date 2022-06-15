<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Routing\Attribute\Route;
use App\Utils\Validator;


class CategoryAdminController extends AbstractController
{
    #[Route(path: "/admin/form-category", name: "form-category")]
    public function formCategory()
    {
        echo $this->twig->render('admin/category/form-category.html.twig');
    }

    #[Route(path: "/admin/create-category", name: "create-category", httpMethod: "POST")]
    public function createCategory(CategoryRepository $categoryRepository)
    {

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

        echo $this->twig->render('admin/category/form-category.html.twig', [
            'errors' => $errors
        ]);
    }


}