<?php

namespace App\Controller;

use App\Entity\News;
use App\Repository\NewsRepository;
use App\Routing\Attribute\Route;
use App\Utils\Validator;
use DateTime;

class NewsAdminController extends AbstractController
{
    // Affichage du formulaire de création d'actualité
    #[Route(path: "/admin/form-create-news", name: "create-form-news")]
    public function createFormNews()
    {
        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin' && $_SESSION['userRole'] !== 'BDE') {
            echo $this->twig->render('/access.html.twig');
        } else {
            echo $this->twig->render('admin/news/form-news.html.twig');
        }
    }

    // Validation du formulaire de création d'actualité
    #[Route(path: "/admin/create-news", httpMethod: "POST", name: "create-news")]
    public function createNews(NewsRepository $newsRepository)
    {
        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin' && $_SESSION['userRole'] !== 'BDE') {
            echo $this->twig->render('/access.html.twig');
        } else {

            $validator = new Validator($_POST);

            $validator->required("name", "description", "link")
                ->dateTime("date")
                ->length("name", 2, 250)
                ->length("link", 2)
                ->length("description", 2, 250);

            if ($validator->isValid()) {
                $news = new News();
                $news->setNameNews($_POST['name'])
                    ->setDescriptionNews($_POST['description'])
                    ->setLinkNews($_POST['link'])
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

    // Affichage de la liste des actualités
    #[Route(path: "/admin/list-news", name: "admin-list-news")]
    public function listNews(NewsRepository $newsRepository)
    {

        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin' && $_SESSION['userRole'] !== 'BDE') {
            echo $this->twig->render('/access.html.twig');
        } else {

            $news = $newsRepository->findAllNews();

            echo $this->twig->render('admin/news/list-news.html.twig', [
                'news' => $news
            ]);
        }
    }

    // Affichage du formulaire d'edition d'actualité
    #[Route(path: "/admin/form-edit-news/{id}", name: "form-edit-news")]
    public function editFormNews(NewsRepository $newsRepository, int $id)
    {

        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin' && $_SESSION['userRole'] !== 'BDE') {
            echo $this->twig->render('/access.html.twig');
        } else {

            $news = $newsRepository->findNewsById($id);

            echo $this->twig->render('admin/news/edit-news.html.twig', [
                'news' => $news
            ]);
        }
    }

    // Edition de l'actualité
    #[Route(path: "/admin/update-news/{id}", httpMethod: "POST", name: "update-news")]
    public function updateNews(NewsRepository $newsRepository, int $id)
    {

        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin' && $_SESSION['userRole'] !== 'BDE') {
            echo $this->twig->render('/access.html.twig');
        } else {

            $news = $newsRepository->findNewsById($id);
            $validator = new Validator($_POST);

            $validator->required("name", "description","link")
                ->length("name", 2, 250)
                ->length("link",2)
                ->length("description", 2, 250);

            if ($validator->isValid()) {
                $newsUpdate = new News();
                $newsUpdate->setNameNews($_POST['name'])
                    ->setDescriptionNews($_POST['description'])
                    ->setLinkNews($_POST['link'])
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

    // Suppression d'actualité
    #[Route(path: "/admin/delete-news/{id}" , name: "delete-news")]
    public function deleteNews(NewsRepository $newsRepository, int $id)
    {
        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin' && $_SESSION['userRole'] !== 'BDE') {
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

    // Recherche 
    #[Route(path: "/admin/recherche-crud-news", name: "recherhce-crud-news", httpMethod: "POST")]
    public function rechercheCrudnews(NewsRepository $newsRepository)
    {
        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin' && $_SESSION['userRole'] !== 'BDE') {
            echo $this->twig->render('/access.html.twig');
        } else {

            if($_POST["search"] != ""){
                $news = $newsRepository->findAllRecherche($_POST["search"]);
            }else{
                $news = $newsRepository->findAllNews();
            }
           
            echo $this->twig->render('admin/news/list-news.html.twig', [
                'news' => $news
            ]);
        }
    }
}