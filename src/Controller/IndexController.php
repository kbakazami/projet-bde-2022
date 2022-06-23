<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use App\Repository\NewsRepository;
use App\Routing\Attribute\Route;
use App\Repository\CategoryRepository;


class IndexController extends AbstractController
{
    #[Route(path: "/")]
    public function index(EventRepository $eventRepository, NewsRepository $newsRepository,CategoryRepository $categoryRepository)
    {
        $events = $eventRepository->findThirdLastEvent();

        $lesEvent = [];

        foreach($events as $events){
            $nb = $eventRepository->CountUserByEvent($events->id_event);
            $lesEvent[]=["event" => $events, "nb" => $nb];

        }
        $news = $newsRepository->findThirdLastNews();

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

    #[Route(path: "/recherche_home", name: "recherche_home", httpMethod: "POST")]
    public function recherche_home(EventRepository $eventRepository){
        

        if($_POST["prix_max"] == ""){
            $prix = -1;
        }else{
            $prix = floatval($_POST["prix_max"]);
        }
        
        // var_dump($_POST);

        $events = $eventRepository->rechercheHome($_POST["recherche"],intval($_POST["category"]),$prix);
        // var_dump($events);
        echo $this->twig->render('index/recherche_home.html.twig', [
            'events'=>$events
        ]);
    }
    

}
