<?php

namespace App\Repository;

use App\Entity\Event;

final class EventRepository extends AbstractRepository
{
//    protected const TABLE = 'event';
//
//    public function save(Event $event): bool
//    {
//        $stmt = $this->pdo->prepare("INSERT INTO event (title, description, price, date, id_category, id_creator) VALUES (:title, :description, :price, :date, :id_category, :id_creator)");
//
//        return $stmt->execute([
//            'title' => $event->getTitleEvent(),
//            'description' => $event->getDescriptionEvent(),
//            'price' => $event->getPriceEvent(),
//            'date' => $event->getDateEvent()->format('Y-m-d'),
//            'id_category' => $event->getIdCategory(),
//            'id_creator' => $event->getIdCreator()
//        ]);
//    }
}
