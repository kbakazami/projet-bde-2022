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
        $events = $eventRepository->findAllEventwithCategory();
        

        echo $this->twig->render('event/list_event.html.twig',[
            'events' => $events
        ]);
    }

    #[Route(path: "/detail-event/{id}", name: "detail-event")]
    public function detaileEvent(EventRepository $eventRepository,int $id)
    {
        $event = $eventRepository->findEventByIdWithCatAndCrea($id);
        $nbParticipant = $eventRepository->CountUserByEvent($id);
        $message ="";

        $estDeja = false;
        if(isset($_SESSION["userId"]))
        {
            $participate = $eventRepository->isParticipate($id, $_SESSION["userId"]);
            if($participate>0){
                $estDeja=true;
            }
        }      

        echo $this->twig->render('event/detail_event.html.twig',[
            'event' => $event,
            'nbParticipant' => $nbParticipant,
            'message' => $message,
            'participate' => $estDeja
        ]);

        
    }

    #[Route(path: "/participer/{id}", name: "participer")]
    public function participer(EventRepository $eventRepository,int $id)
    {
        $estDeja = false;
        if(!isset($_SESSION["userId"]))
        {
            $message="Vous devez vous inscire ou vous connecter.";
        } 
        else {       
            $participate = $eventRepository->isParticipate($id, $_SESSION["userId"]);
            if($participate>0){
                $estDeja=true;
            }
            else{
                $event = $eventRepository->addParticipant($id, $_SESSION["userId"]);
                $message="Vous êtes inscrit à l'événement";
            }
            
            
        }
        
        $event = $eventRepository->findEventByIdWithCatAndCrea($id);
        $nbParticipant = $eventRepository->CountUserByEvent($id);

        
        echo $this->twig->render('event/detail_event.html.twig',[
            'event' => $event,
            'nbParticipant' => $nbParticipant,
            'message' => $message,
            'participate' => $estDeja
        ]);
    }
    
}
