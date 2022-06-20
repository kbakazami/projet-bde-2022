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

class EventController extends AbstractController
{
    #[Route(path: "/list-event", name: "list-event")]
    public function listeEvent(EventRepository $eventRepository)
    {
        $events = $eventRepository->findAllEvent();

        echo $this->twig->render('event/list_event.html.twig',[
            'events' => $events
        ]);
    }

    #[Route(path: "/detail-event/{id}", name: "detail-event")]
    public function detailEvent(EventRepository $eventRepository, $id)
    {
        $event = $eventRepository->findEventById($id);

        echo $this->twig->render('event/detail_event.html.twig',[
            'event' => $event
        ]);
    }
}
