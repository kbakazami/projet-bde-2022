<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\CategoryRepository;
use App\Repository\EventRepository;
use App\Routing\Attribute\Route;
use App\Routing\Router;
use App\Utils\Validator;
use DateTime;


class EventAdmincontroller extends AbstractController
{

    #[Route(path: "/admin/form-event", name: "form-event")]
    public function formEvent(CategoryRepository $categoryRepository)
    {
        $category = $categoryRepository->findAllCategory();

        echo $this->twig->render('admin/event/form-event.html.twig', [
                'category' => $category
            ]);
    }

    #[Route(path: "/admin/create-event", name: "create-event", httpMethod: "POST")]
    public function createEvent(EventRepository $eventRepository, CategoryRepository $categoryRepository)
    {
        $category = $categoryRepository->findAllCategory();
        $validator = new Validator($_POST);

        $validator->required("title", "description", "price")
            ->length("title", 2, 250)
            ->length("description", 2, 250)
            ->length("price", 2, 250);

        if ($validator->isValid()) {
            $event = new Event();
            $event->setTitleEvent($_POST['title'])
                ->setDescriptionEvent($_POST['description'])
                ->setPriceEvent($_POST['price'])
                ->setDateEvent(new DateTime())
                ->setIdCategory(intVal($_POST['category']))
                ->setIdCreator($_SESSION['userId']);

            $eventRepository->save($event);
        }

        $errors = $validator->getErrors();

        echo $this->twig->render('admin/event/form-event.html.twig', [
                'errors' => $errors,
                'category' => $category
            ]);
    }



    #[Route(path: "/admin/list-event", name: "admin-list-event")]
    public function listEvent(EventRepository $eventRepository)
    {
        $events = $eventRepository->findAllEvent();

        echo $this->twig->render('admin/event/list-event.html.twig',[
                'events' => $events
            ]);
    }

    #[Route(path: "/admin/event/{id}" , name: "admin-one-event")]
    public function oneEvent(EventRepository $eventRepository, CategoryRepository $categoryRepository, int $id)
    {
        $event = $eventRepository->findEventById($id);

        $category = $categoryRepository->findAllCategory();

        echo $this->twig->render('admin/event/edit-event.html.twig',[
            'event' => $event,
            'category' => $category,
        ]);
    }

}