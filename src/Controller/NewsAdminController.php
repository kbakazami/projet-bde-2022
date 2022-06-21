<?php

namespace App\Controller;

use App\Entity\News;
use App\Repository\NewsRepository;
use App\Routing\Attribute\Route;
use App\Utils\Validator;
use DateTime;

class NewsAdminController extends AbstractController
{
    #[Route(path: "/admin/form-create-news", name: "create-form-news")]
    public function createFormNews()
    {
        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin') {
            echo $this->twig->render('/access.html.twig');
        } else {
            echo $this->twig->render('admin/news/form-news.html.twig');
        }
    }

    #[Route(path: "/admin/create-news", httpMethod: "POST", name: "create-news")]
    public function createNews(NewsRepository $newsRepository)
    {
        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin') {
            echo $this->twig->render('/access.html.twig');
        } else {

            $validator = new Validator($_POST);

            $validator->required("name", "description")
                ->dateTime("date")
                ->length("name", 2, 250)
                ->length("description", 2, 250);

            if ($validator->isValid()) {
                $news = new News();
                $news->setNameNews($_POST['name'])
                    ->setDescriptionNews($_POST['description'])
                    ->setDateNews(new DateTime($_POST['date']));

                $newsRepository->save($news);
            }
            $errors = $validator->getErrors();

            if (!empty($errors)) {
                echo $this->twig->render('admin/news/form-news.html.twig', [
                    'errors' => $errors
                ]);
            } else {
                header('Location: /admin/list-news');
            }
        }
    }

    #[Route(path: "/admin/list-news", name: "admin-list-news")]
    public function listNews(NewsRepository $newsRepository)
    {

        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin') {
            echo $this->twig->render('/access.html.twig');
        } else {

            $news = $newsRepository->findAllNews();

            echo $this->twig->render('admin/news/list-news.html.twig', [
                'news' => $news
            ]);
        }
    }

    #[Route(path: "/admin/form-edit-news/{id}", name: "form-edit-news")]
    public function editFormNews(NewsRepository $newsRepository, int $id)
    {

        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin') {
            echo $this->twig->render('/access.html.twig');
        } else {

            $news = $newsRepository->findNewsById($id);

            echo $this->twig->render('admin/news/edit-news.html.twig', [
                'news' => $news
            ]);
        }
    }

    #[Route(path: "/admin/update-news/{id}", httpMethod: "POST", name: "update-news")]
    public function updateNews(NewsRepository $newsRepository, int $id)
    {

        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin') {
            echo $this->twig->render('/access.html.twig');
        } else {

            $news = $newsRepository->findNewsById($id);
            $validator = new Validator($_POST);

            $validator->required("name", "description")
                ->length("name", 2, 250)
                ->length("description", 2, 250);

            if ($validator->isValid()) {
                $newsUpdate = new News();
                $newsUpdate->setNameNews($_POST['name'])
                    ->setDescriptionNews($_POST['description'])
                    ->setDateNews(new DateTime());

                $newsRepository->updateNews($newsUpdate, $id);
            }

            $errors = $validator->getErrors();

            if (!empty($errors)) {
                echo $this->twig->render('admin/news/form-news.html.twig', [
                    'errors' => $errors,
                    'news' => $news
                ]);
            } else {
                header('Location: /admin/list-news');
            }
        }
    }

    #[Route(path: "/admin/delete-news/{id}" , name: "delete-news")]
    public function deleteNews(NewsRepository $newsRepository, int $id)
    {
        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin') {
            echo $this->twig->render('/access.html.twig');
        } else {

            $newsRepository->deleteNews($id);

            $message = "L'actualité à bien été supprimée";

            header('Location: /admin/list-news');
            echo $this->twig->render('admin/news/list-news.html.twig', [
                'message' => $message
            ]);
        }
    }
}