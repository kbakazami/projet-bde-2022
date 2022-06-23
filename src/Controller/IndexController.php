<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use App\Repository\NewsRepository;
use App\Routing\Attribute\Route;
use App\Repository\CategoryRepository;


class IndexController extends AbstractController
{
    // Affichage des 3 derniers évenement (date passé ou non)
    // Affichage des 3 dernières actualités
    #[Route(path: "/")]
    public function index(EventRepository $eventRepository, NewsRepository $newsRepository,CategoryRepository $categoryRepository)
    {
        // Affichage 3 events
        $events = $eventRepository->findThirdLastEvent();
        $lesEvent = [];
        foreach($events as $events){
            $date = false;
            if($events->date >= date("Y-m-d H:i:s"))
            {
                $date = true;
            }

            $nb = $eventRepository->CountUserByEvent($events->id_event);
            $lesEvent[]=["event" => $events, "nb" => $nb, 'date' => $date];
        }

        // 3 dernière actualité
        $news = $newsRepository->findThirdLastNews();
      
        // Recherche 
        $category = $categoryRepository->findAllCategory();
        $cat=[];
        foreach($category as $category){
            if($category->id!=0)
            {
                $cat[]=$category;
            }
        }

        echo $this->twig->render('index/home.html.twig', [
            'events' => $lesEvent,
            'news' => $news,
            'category' => $cat
        ]);
    }

    // Afficaheg de la page de recherche en fonction de la recherche de l'accueil
    #[Route(path: "/recherche_home", name: "recherche_home", httpMethod: "POST")]
    public function recherche_home(EventRepository $eventRepository){
        

        if($_POST["prix_max"] == ""){
            $prix = -1;
        }else{
            $prix = floatval($_POST["prix_max"]);
        }
        
        $events = $eventRepository->rechercheHome($_POST["recherche"],intval($_POST["category"]),$prix);
        echo $this->twig->render('index/recherche_home.html.twig', [
            'events'=>$events
        ]);
    }
}
