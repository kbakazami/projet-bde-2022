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
    // Affichage des évenements dont la date n'est pas encore passé
    #[Route(path: "/list-event", name: "list-event")]
    public function listeEvent(EventRepository $eventRepository, CategoryRepository $categoryRepository)
    {
        $events = $eventRepository->findAllEventWithDate();

        $lesEvent = [];
        $category = $categoryRepository->findAllCategory();
        $cat=[];
        foreach($category as $category){
            if($category->id!=0)
            {
                $cat[]=$category;
            }
        }
        
        foreach($events as $events){
            $nb = $eventRepository->CountUserByEvent($events->id_event); 
            $lesEvent[]=["event" => $events, "nb" => $nb];
        }

        $date = 1;
        echo $this->twig->render('event/list_event.html.twig',[
            'events' => $lesEvent,
            'date' => $date,
            'category' => $cat
        ]);
    }

    // Affichage d'un événement
    #[Route(path: "/detail-event/{id}", name: "detail-event")]
    public function detaileEvent(EventRepository $eventRepository,int $id)
    {
        $event = $eventRepository->findEventByIdWithCatAndCrea($id);
        $nbParticipant = $eventRepository->CountUserByEvent($id);
        $message ="";
        $participate="";
        $estDeja = false;
        if(isset($_SESSION["userId"]))
        {
            // On test si la persone participe déjà à l'évenement
            $participate = $eventRepository->isParticipate($id, $_SESSION["userId"]);
            if($participate->nombre!=="0"){
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

    // Inscription d'un utilisateur à un évenement
    #[Route(path: "/participer/{id}", name: "participer")]
    public function participer(EventRepository $eventRepository,int $id)
    {
        $message="";
        $estDeja = false;
        if(!isset($_SESSION["userId"]))
        {
            $message="Vous devez vous inscire ou vous connecter.";
            header("location: /form-login");
        } else {
            $event = $eventRepository->addParticipant($id, $_SESSION["userId"]);
            $message="Vous êtes inscrit à l'événement";
            $estDeja=true;
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

    // Désinscription d'un participant à un événement
    #[Route(path: "/desinscrire/{id}", name: "desinscrire")]
    public function desinscrire(EventRepository $eventRepository,int $id)
    {
        $estDeja = false;
        
        $event = $eventRepository->desinscrire($id, $_SESSION["userId"]);
        $message="Vous êtes désinscrit de l'événement";    
        
        $event = $eventRepository->findEventByIdWithCatAndCrea($id);
        $nbParticipant = $eventRepository->CountUserByEvent($id);

        
        echo $this->twig->render('event/detail_event.html.twig',[
            'event' => $event,
            'nbParticipant' => $nbParticipant,
            'message' => $message,
            'participate' => $estDeja
        ]);
    }

     // Affichage des évenements par date 
     #[Route(path: "/event-date/{date}", name: "event-date")]
     public function eventDate(EventRepository $eventRepository, int $date)
     {
        $events = $eventRepository->findAllEventByDate($date);
 
        $lesEvent = [];
         
        foreach($events as $events){
            $nb = $eventRepository->CountUserByEvent($events->id_event); 
            $lesEvent[]=["event" => $events, "nb" => $nb];
        }
        
        if($date == 0){
            $date = 1;
        }else{
            $date = 0;
        }
        
         echo $this->twig->render('event/list_event.html.twig',[
             'events' => $lesEvent,
             'date' => $date
         ]);
     }
}
