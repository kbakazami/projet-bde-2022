<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\CategoryRepository;
use App\Repository\EventRepository;
use App\Routing\Attribute\Route;
use App\Utils\Validator;
use DateTime;


class EventAdmincontroller extends AbstractController
{

    #[Route(path: "/admin/form-create-event", name: "create-form-event")]
    public function createFormEvent(CategoryRepository $categoryRepository)
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
            ->dateTime("date")
            ->length("title", 2, 250)
            ->length("description", 2, 250)
            ->length("price", 2, 250)
            ->select('category');

        if ($validator->isValid()) {
            $event = new Event();
            $event->setTitleEvent($_POST['title'])
                ->setDescriptionEvent($_POST['description'])
                ->setPriceEvent($_POST['price'])
                ->setDateEvent(new DateTime($_POST['date']))
                ->setIdCategory(intVal($_POST['category']))
                ->setIdCreator($_SESSION['userId']);

            $eventRepository->save($event);
        }

        $errors = $validator->getErrors();

        if(!empty($errors)) {
            echo $this->twig->render('admin/event/form-event.html.twig', [
                'errors' => $errors,
                'category' => $category
            ]);
        } else {
            header('Location: /admin/list-event');
        }

    }

    #[Route(path: "/admin/list-event", name: "admin-list-event")]
    public function listEvent(EventRepository $eventRepository)
    {
        $events = $eventRepository->findAllEvent();

        echo $this->twig->render('admin/event/list-event.html.twig',[
                'events' => $events
            ]);
    }

    #[Route(path: "/admin/form-edit-event/{id}" , name: "form-edit-event")]
    public function editFormEvent(EventRepository $eventRepository, CategoryRepository $categoryRepository, int $id)
    {
        $event = $eventRepository->findEventById($id);

        $category = $categoryRepository->findAllCategory();

        echo $this->twig->render('admin/event/edit-event.html.twig',[
            'event' => $event,
            'category' => $category,
        ]);
    }

    #[Route(path: "/admin/update-event/{id}", name: "update-event", httpMethod: "POST")]
    public function updateEvent(EventRepository $eventRepository, CategoryRepository $categoryRepository, int $id)
    {
        $category = $categoryRepository->findAllCategory();
        $event = $eventRepository->findEventById($id);
        $validator = new Validator($_POST);

        $validator->required("title", "description", "price")
            ->length("title", 2, 250)
            ->length("description", 2, 250)
            ->length("price", 2, 250);

        if ($validator->isValid()) {
            $eventUpdate = new Event();
            $eventUpdate->setTitleEvent($_POST['title'])
                ->setDescriptionEvent($_POST['description'])
                ->setPriceEvent($_POST['price'])
                ->setDateEvent(new DateTime())
                ->setIdCategory(intVal($_POST['category']))
                ->setIdCreator($_SESSION['userId']);

            $eventRepository->updateEvent($eventUpdate, $id);
        }

        $errors = $validator->getErrors();

        if(!empty($errors)) {
            echo $this->twig->render('admin/event/form-event.html.twig', [
                'errors' => $errors,
                'category' => $category,
                'event' => $event
            ]);
        } else {
            header('Location: /admin/list-event');
        }
    }

    #[Route(path: "/admin/delete-event/{id}" , name: "delete-event")]
    public function deleteEvent(EventRepository $eventRepository, int $id)
    {
        $eventRepository->deleteEvent($id);

        $message = "L'événement a bien été supprimé";

        echo $this->twig->render('admin/event/list-event.html.twig', [
            'message' => $message
        ]);
    }

}