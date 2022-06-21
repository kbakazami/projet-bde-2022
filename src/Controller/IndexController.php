<?php

namespace App\Controller;

use App\Repository\EventRepository;
use App\Repository\NewsRepository;
use App\Routing\Attribute\Route;


class IndexController extends AbstractController
{
    #[Route(path: "/")]
    public function index(EventRepository $eventRepository, NewsRepository $newsRepository)
    {
        $events = $eventRepository->findAllEvent();

        $news = $newsRepository->findAllNews();

        echo $this->twig->render('index/home.html.twig', [
            'events' => $events,
            'news' => $news
        ]);
    }



}
