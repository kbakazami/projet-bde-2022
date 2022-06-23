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

    public function findAllEventWithDate(){
        $stmt = $this->pdo->prepare("SELECT event.id AS id_event , event.title AS titre_event, description, price, date, event.image, category.title AS titre_category, id_users, event.id_category as id_cat, users.lastname as prenom, users.firstname as nom, category.color as color FROM event INNER JOIN category ON category.id = event.id_category INNER JOIN users ON users.id = event.id_users WHERE date >= CURRENT_DATE ORDER BY event.id DESC");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function findAllEventwithCategory(){
        $stmt = $this->pdo->prepare("SELECT event.id AS id_event , event.title AS titre_event, description, price, date, event.image, category.title AS titre_category, id_users, event.id_category as id_cat, users.lastname as prenom, users.firstname as nom, category.color as color FROM event INNER JOIN category ON category.id = event.id_category INNER JOIN users ON users.id = event.id_users ORDER BY event.id DESC");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function findAllEventwithCategoryByID(int $id){
        $stmt = $this->pdo->prepare("SELECT event.id AS id_event , event.title AS titre_event, description, price, date, event.image, category.title AS titre_category, id_users, event.id_category as id_cat, users.lastname as prenom, users.firstname as nom, category.color as color FROM event INNER JOIN category ON category.id = event.id_category INNER JOIN users ON users.id = event.id_users WHERE event.id_category = :id AND date >= CURRENT_DATE ORDER BY event.id DESC");

        $stmt->execute([
            'id' => $id
        ]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function findThirdLastEvent()
    {
        $stmt = $this->pdo->prepare("SELECT event.id AS id_event , event.title AS titre_event, description, price, date, event.image, category.title AS titre_category,category.color as color_category, event.id_category as id_cat FROM event INNER JOIN category ON category.id = event.id_category ORDER BY event.date DESC LIMIT 3");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function findParticipantByEvent($id){
        $stmt = $this->pdo->prepare("SELECT users.id AS id, users.firstname AS prenom, users.lastname AS nom, users.mail AS mail FROM users INNER JOIN participer ON users.id = participer.id_users INNER JOIN event ON event.id = participer.id WHERE participer.id = :id ORDER BY users.lastname ASC");

        $stmt->execute([
            'id' => $id
        ]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function findAllEventByUser($id_user){
        $stmt = $this->pdo->prepare("SELECT event.id AS id_event , event.title AS titre_event, description, price, date, image, category.title AS titre_category, event.id_users, event.id_category as id_cat FROM event INNER JOIN category ON category.id = event.id_category INNER JOIN participer ON event.id = participer.id WHERE participer.id_users = :id ORDER BY event.id DESC");

        $stmt->execute([
            'id' => $id_user
        ]);

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
        $stmt = $this->pdo->prepare("SELECT event.id AS id_event , event.title AS titre_event, description, price, date, event.image, category.title AS titre_category, category.color AS color, id_users, event.id_category as id_cat, users.lastname AS nom, users.firstname AS prenom FROM event INNER JOIN category ON category.id = event.id_category INNER JOIN users ON users.id = event.id_users WHERE event.id = :id");

        $stmt->execute([
            'id' => $id
        ]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function findEventByCate($id){
        $stmt = $this->pdo->prepare("SELECT event.id AS id_event , event.title AS titre_event, description, price, date, image, category.title AS titre_category, event.id_users, event.id_category as id_cat FROM event INNER JOIN category ON category.id = event.id_category WHERE event.id_category = :id ORDER BY event.id DESC");

        $stmt->execute([
            'id' => $id
        ]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
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
        $stmt = $this->pdo->prepare("UPDATE event SET title = :title, description = :description, price = :price, date = :date, image = :image, id_category = :id_category, id_users = :id_users WHERE id = :id");

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

    public function deleteEventParticiper(int $id){
        $stmt = $this->pdo->prepare("DELETE FROM participer WHERE id = :id");
        return $stmt->execute([
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

    public function rechercheHome(string $recherche, int $id_cat, float $prix){
        $pdo = "SELECT event.id AS id_event , event.title AS titre_event, description, price, date, event.image, category.title AS titre_category, category.color AS color, id_users, event.id_category as id_cat, users.lastname as prenom, users.firstname as nom FROM event INNER JOIN category ON category.id = event.id_category INNER JOIN users ON users.id = event.id_users";
        $i = 0;
        $table = [];      
        if($recherche != "" || $id_cat != 0 || $prix > -1){
            $pdo.= " WHERE";
            if($recherche != ""){
                $i = 1;
                $pdo.= " event.title LIKE :recherche OR description LIKE :recherche";
                $table['recherche']= '%'.$recherche.'%';
            }
            if($id_cat != 0){
                if($i == 1){
                    $pdo.= " AND";
                }
                $pdo.= " id_category = :cat";
                // var_dump($i);
                $i = 1;
                $table['cat']= $id_cat;
            }
            if($prix > -1)
            {
                if($i == 1){
                    $pdo.= " AND";
                }
                $pdo.= " price <= :price";
                $table['price']=$prix;
            }                  
        }

        $stmt = $this->pdo->prepare($pdo);
        $stmt->execute($table);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function findAllEventSearch(string $recherche){
        $stmt = $this->pdo->prepare("SELECT event.id AS id_event , event.title AS titre_event, description, price, date, event.image, category.title AS titre_category, id_users, event.id_category as id_cat, users.lastname as prenom, users.firstname as nom, category.color as color FROM event INNER JOIN category ON category.id = event.id_category INNER JOIN users ON users.id = event.id_users WHERE event.title LIKE :recherche OR event.description LIKE :recherche ORDER BY event.id DESC");

        $stmt->execute([
            'recherche' => "%".$recherche."%"
        ]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
};
