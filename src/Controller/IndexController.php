<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\EventRepository;
use App\Routing\Attribute\Route;
use DateTime;

class IndexController extends AbstractController
{
    #[Route(path: "/")]
    public function index(UserRepository $userRepository, EventRepository $eventRepository)
    {
        $user = new User();
        $event = new Event();
        $user->setFirstName("admin")
            ->setLastName("admin")
            ->setImage("BobbyEvent.png")
            ->setPassword("admin")
            ->setEmail("admin@admin.com")
            ->setBirthDate(new DateTime('1981-02-16'));

        $userRepository->save($user);

//        $event->setTitleEvent("Evenement 1")
//            ->setDescriptionEvent("Bonjour c'est la description de l'évenement hello")
//            ->setPriceEvent(35)
//            ->setDateEvent(new DateTime('2022-03-02'))
//            ->setIdCreator($userRepository->getIdUser($user))
//            ->setIdCategory($userRepository->getIdUser($user));
//
//        $eventRepository->save($event);
    }

    #[Route(path: "/contact", name: "contact", httpMethod: "POST")]
    public function contact()
    {
        echo $this->twig->render('index/contact.html.twig');
    }
}
