<?php

namespace App\Repository;

use App\Entity\Event;
use PDO;

final class EventRepository extends AbstractRepository
{
    protected const TABLE = 'event';

    public function save(Event $event): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO event (title, description, price, date, id_category, id_users) VALUES (:title, :description, :price, :date, :id_category, :id_users)");

        return $stmt->execute([
            'title' => $event->getTitleEvent(),
            'description' => $event->getDescriptionEvent(),
            'price' => $event->getPriceEvent(),
            'date' => $event->getDateEvent()->format('Y-m-d'),
            'id_category' => $event->getIdCategory(),
            'id_users' => $event->getIdCreator()
        ]);
    }

    public function findAllEvent(){
        $stmt = $this->pdo->prepare("SELECT id, title, description, price, date, id_category, id_users FROM event");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function findEventById(int $id){
        $stmt = $this->pdo->prepare("SELECT id, title, description, price, date, id_category, id_users FROM event WHERE id = :id");

        $stmt->execute([
            'id' => $id
        ]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function updateEvent(Event $event, $id){
        $stmt = $this->pdo->prepare("UPDATE event SET title = :title, description = :description, price = :price, date = :date, id_category = :id_category, id_users = :id_users WHERE id = :id");

        return $stmt->execute([
            'title' => $event->getTitleEvent(),
            'description' => $event->getDescriptionEvent(),
            'price' => $event->getPriceEvent(),
            'date' => $event->getDateEvent()->format('Y-m-d'),
            'id_category' => $event->getIdCategory(),
            'id_users' => $event->getIdCreator(),
            'id' => $id
        ]);
    }

    public function deleteEvent(int $id){
        $stmt = $this->pdo->prepare("DELETE FROM event WHERE id = :id");

        return $stmt->execute([
            'id' => $id
        ]);
    }
}
