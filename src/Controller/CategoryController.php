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

class CategoryController extends AbstractController
{
    // Affichage des evenements lié a une catégorie
    #[Route(path: "/detail-category/{id}", name: "detail-category")]
    public function detaileCategory(EventRepository $eventRepository, CategoryRepository $categoryRepository, int $id)
    {
        $events = $eventRepository->findAllEventwithCategoryByID($id);
        $category = $categoryRepository->findCategoryById($id);

        $lesEvent = [];
        
        foreach($events as $events){
            $nb = $eventRepository->CountUserByEvent($events->id_event); 
            $lesEvent[]=["event" => $events, "nb" => $nb];

        }


        echo $this->twig->render('category/detail_category.html.twig',[
            'events' => $lesEvent,
            'category' => $category
        ]);
    }
}
