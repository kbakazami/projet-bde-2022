<?php

namespace App\Controller;

use App\Entity\Event;
use App\Routing\Attribute\Route;
use App\Repository\UserRepository;
use App\Session\Session;


class EventController extends AbstractController
{
    #[Route(path: "/list_event", name: "list_event")]
    public function list_event()
    {
        $event = new Event();
        $list = [];
        $list = $event -> getAll();

        echo $this->twig->render('event/event.html.twig', [
            "event" => $list
        ]);
    }
}
