<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\CategoryRepository;
use App\Repository\ImageRepository;
use App\Repository\EventRepository;
use App\Routing\Attribute\Route;
use App\Utils\UploadFiles;
use App\Utils\Validator;
use DateTime;

class EventAdmincontroller extends AbstractController
{

    #[Route(path: "/admin/form-create-event", name: "create-form-event")]
    public function createFormEvent(CategoryRepository $categoryRepository)
    {
        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin') {
            echo $this->twig->render('/access.html.twig');
        } else {

            $category = $categoryRepository->findAllCategory();

            echo $this->twig->render('admin/event/form-event.html.twig', [
                'category' => $category
            ]);
        }
    }

    #[Route(path: "/admin/create-event", name: "create-event", httpMethod: "POST")]
    public function createEvent(EventRepository $eventRepository, CategoryRepository $categoryRepository)
    {
        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin') {
            echo $this->twig->render('/access.html.twig');
        } else {

            $category = $categoryRepository->findAllCategory();
            $validator = new Validator($_POST);

            $image = new UploadFiles($_FILES['file']);

            $validator->required("title", "description", "price")
                ->dateTime("date")
                ->length("title", 2, 250)
                ->length("description", 2, 2500)
                ->length("price", 2, 250)
                ->select('category')
                ->imagePattern($image->getTypeFile());

            if ($validator->isValid()) {
                $event = new Event();
                $event->setTitleEvent($_POST['title'])
                    ->setDescriptionEvent($_POST['description'])
                    ->setPriceEvent($_POST['price'])
                    ->setDateEvent(new DateTime($_POST['date']))
                    ->setImageEvent($image->upload())
                    ->setIdCategory(intVal($_POST['category']))
                    ->setIdCreator($_SESSION['userId']);

                $eventRepository->save($event);
            }

            $errors = $validator->getErrors();

            if (!empty($errors)) {
                echo $this->twig->render('admin/event/form-event.html.twig', [
                    'errors' => $errors,
                    'category' => $category
                ]);
            } else {
                header('Location: /admin/list-event');
            }

        }
    }

    #[Route(path: "/admin/list-event", name: "admin-list-event")]
    public function listEvent(EventRepository $eventRepository)
    {
        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin') {
            echo $this->twig->render('/access.html.twig');
        } else {
            $events = $eventRepository->findAllEventwithCategory();

            $lesEvent = [];
            
            foreach($events as $events){
                $nb = $eventRepository->CountUserByEvent($events->id_event); 
                $lesEvent[]=["event" => $events, "nb" => $nb];
            }

            echo $this->twig->render('admin/event/list-event.html.twig',[
                'events' => $lesEvent
            ]);
        }
    }

    #[Route(path: "/admin/voir-participant/{id}" , name: "voir-participant")]
    public function voirParticipant(EventRepository $eventRepository, CategoryRepository $categoryRepository, int $id)
    {
        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin') {
            echo $this->twig->render('/access.html.twig');
        } else {

            $participant = $eventRepository->findParticipantByEvent($id);


            echo $this->twig->render('admin/event/list-participant.html.twig', [
                'participant' => $participant,
                'id_event' => $id
            ]);
        }
    }

    #[Route(path: "/admin/delete-user-event/{id}/{id_event}" , name: "delete-user-event")]
    public function deletUserEvent(EventRepository $eventRepository, CategoryRepository $categoryRepository, int $id, int $id_event)
    {
        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin') {
            echo $this->twig->render('/access.html.twig');
        } else {

            $eventRepository->desinscrire($id_event,$id);
            $participant = $eventRepository->findParticipantByEvent($id);

            echo $this->twig->render('admin/event/list-participant.html.twig', [
                'participant' => $participant
            ]);
        }
    }

    #[Route(path: "/admin/form-edit-event/{id}" , name: "form-edit-event")]
    public function editFormEvent(EventRepository $eventRepository, CategoryRepository $categoryRepository, int $id)
    {

        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin') {
            echo $this->twig->render('/access.html.twig');
        } else {


            $event = $eventRepository->findEventById($id);

            $date = str_replace(' ', 'T', $event->date);
            $category = $categoryRepository->findAllCategory();

            echo $this->twig->render('admin/event/edit-event.html.twig', [
                'event' => $event,
                'category' => $category,
                'date' => $date
            ]);
        }
    }

    #[Route(path: "/admin/update-event/{id}", name: "update-event", httpMethod: "POST")]
    public function updateEvent(EventRepository $eventRepository, CategoryRepository $categoryRepository, int $id)
    {

        $date = str_replace('T', ' ', $_POST["date"]);

        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin') {
            echo $this->twig->render('/access.html.twig');
        } else {

            $category = $categoryRepository->findAllCategory();
            $event = $eventRepository->findEventById($id);
            $validator = new Validator($_POST);

//        if($_FILES)
//        {
            $image = new UploadFiles($_FILES['file']);
//        }

            $validator->required("title", "description", "price")
                ->length("title", 2, 250)
                ->length("description", 2, 2500)
                ->length("price", 2, 250);

            if ($_FILES) {
                $validator->imagePattern($image->getTypeFile());
            }

            if ($validator->isValid()) {

                $eventUpdate = new Event();
                $eventUpdate->setTitleEvent($_POST['title'])
                    ->setDescriptionEvent($_POST['description'])
                    ->setPriceEvent($_POST['price'])
                    ->setDateEvent(new DateTime($date))
                    ->setIdCategory(intVal($_POST['category']))
                    ->setIdCreator($_SESSION['userId']);

                if ($_FILES) {
                    $eventUpdate->setImageEvent($image->upload());
                }
                $eventRepository->updateEvent($eventUpdate, $id);
            }
            var_dump($date);
            $errors = $validator->getErrors();

            if (!empty($errors)) {
                echo $this->twig->render('admin/event/edit-event.html.twig', [
                    'errors' => $errors,
                    'category' => $category,
                    'event' => $event,
                    'date' => $date
                ]);
            } else {
                header('Location: /admin/list-event');
            }
        }
    }

    #[Route(path: "/admin/delete-event/{id}" , name: "delete-event")]
    public function deleteEvent(EventRepository $eventRepository, int $id)
    {
        if (!isset($_SESSION['userRole'])) {
            header('Location: /form-login');
        }
        if ($_SESSION['userRole'] !== 'Admin') {
            echo $this->twig->render('/access.html.twig');
        } else {

            $eventRepository->deleteEventParticiper($id);
            $eventRepository->deleteEvent($id);

            $message = "L'événement a bien été supprimé";
            header('Location: /admin/list-event');
            echo $this->twig->render('admin/event/list-event.html.twig', [
                'message' => $message
            ]);
        }
    }

}