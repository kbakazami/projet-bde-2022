<?php

namespace App\Repository;

use App\Entity\Event;
use PDO;

final class EventRepository extends AbstractRepository
{
    protected const TABLE = 'event';

    public function save(Event $event): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO event (title, description, price, date, image, id_category, id_users) VALUES (:title, :description, :price, :date, :image, :id_category, :id_users)");

        return $stmt->execute([
            'title' => $event->getTitleEvent(),
            'description' => $event->getDescriptionEvent(),
            'price' => $event->getPriceEvent(),
            'date' => $event->getDateEvent()->format('Y-m-d H:i'),
            'image' => $event->getImageEvent(),
            'id_category' => $event->getIdCategory(),
            'id_users' => $event->getIdCreator()
        ]);
    }

    public function findAllEvent(){
        $stmt = $this->pdo->prepare("SELECT event.*, category.title as 'category_title' FROM event INNER JOIN category ON category.id = event.id_category");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function findAllEventwithCategory(){
        $stmt = $this->pdo->prepare("SELECT event.id AS id_event , event.title AS titre_event, description, price, date, image, category.title AS titre_category, id_users, event.id_category as id_cat FROM event INNER JOIN category ON category.id = event.id_category");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function findEventById(int $id){
        $stmt = $this->pdo->prepare("SELECT id, title, description, price, date, image, id_category, id_users FROM event WHERE id = :id");

        $stmt->execute([
            'id' => $id
        ]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function findEventByIdWithCatAndCrea(int $id){
        $stmt = $this->pdo->prepare("SELECT event.id AS id_event , event.title AS titre_event, description, price, date, event.image, category.title AS titre_category, id_users, event.id_category as id_cat, users.lastname AS nom, users.firstname AS prenom FROM event INNER JOIN category ON category.id = event.id_category INNER JOIN users ON users.id = event.id_users WHERE event.id = :id");

        $stmt->execute([
            'id' => $id
        ]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function addParticipant(int $id_event, int $id_user){
        $stmt = $this->pdo->prepare("INSERT INTO participer (id, id_users) VALUES (:id, :id_user)");

        $stmt->execute([
            'id' => $id_event,
            'id_user' =>$id_user
        ]);
    }

    public function isParticipate(int $id_event, int $id_user){
        $stmt = $this->pdo->prepare("SELECT COUNT(*) AS nombre FROM participer WHERE id=:id AND id_users=:id_user");

        $stmt->execute([
            'id' => $id_event,
            'id_user' =>$id_user
        ]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function desinscrire(int $id_event, int $id_user){
        $stmt = $this->pdo->prepare("DELETE FROM participer WHERE id=:id AND id_users=:id_user");

        $stmt->execute([
            'id' => $id_event,
            'id_user' =>$id_user
        ]);
    }

    public function CountUserByEvent(int $id){
        $stmt = $this->pdo->prepare("SELECT COUNT(*) AS nombre FROM participer WHERE id= :id");

        $stmt->execute([
            'id' => $id
        ]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    
    public function updateEvent(Event $event, $id){
        $stmt = $this->pdo->prepare("UPDATE event SET title = :title, description = :description, price = :price, date = :date, image = :image id_category = :id_category, id_users = :id_users WHERE id = :id");

        return $stmt->execute([
            'title' => $event->getTitleEvent(),
            'description' => $event->getDescriptionEvent(),
            'price' => $event->getPriceEvent(),
            'date' => $event->getDateEvent()->format('Y-m-d H:i'),
            'image' => $event->getImageEvent(),
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
    
    public function eventByPrix($prixMax){
        $sql = $this->pdo->prepare("SELECT * FROM event WHERE price BETWEEN 0 AND :prix");
        $sql->bindParam(':prix',$prixMac);
        $sql->execute();
        return $sql->fetch();
    }

    public function rechercheByDescription($recherche){
        $sql = $this->pdo->prepare("SELECT * FROM event WHERE description LIKE :recherche");
        $sql->execute();
        $sql->bindParam(':recherche',$recherche);
        return $sql->fetch();
    }
    
    public function eventByCategory($id_cate){
        $sql = $this->pdo->prepare("SELECT * FROM event WHERE id_category = :id");
        $sql->bindParam(':id',$id_cate);
        $sql->execute();
        return $sql->fetch();
    }
};
