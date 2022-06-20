<?php

namespace App\Repository;

use App\Entity\Event;

final class EventRepository extends AbstractRepository
{
    protected const TABLE = 'event';

    public function eventByPrix($prixMax){
        $sql = $this->pdo->prepare("SELECT * FROM event WHERE price BETWEEN 0 AND :prix");
        $sql->bindParam(':prix',$prixMac);
        $sql->execute();
        return $sql->fetch();
    }
    
    public function rechercheByDescription($recherche){
        $sql = $this->pdo->prepare("SELECT * FROM event WHERE description LIKE :recherche");
        $sql->bindParam(':recherche',$recherche);
        $sql->execute();
        return $sql->fetch();
    }
    
    public function allEvent(){
        $sql = $this->pdo->prepare("SELECT * FROM event");
        $sql->execute();
        return $sql->fetch();
    }
    
    public function getEvent($id){
        $sql = $this->pdo->prepare("SELECT * FROM event WHERE id = :id");
        $sql->bindParam(':id',$id);
        $sql->execute();
        return $sql->fetch();
    }
    
    public function eventByCategory($id_cate){
        $sql = $this->pdo->prepare("SELECT * FROM event WHERE id_category = :id");
        $sql->bindParam(':id',$id_cate);
        $sql->execute();
        return $sql->fetch();
    }
    
    public function addEvent($title,$description,$price,$date,$category,$image){
        $sql =$this->pdo->prepare("INSERT INTO event(title, description, price, date, id_category, id_users) VALUES (:titre, :descripton, :prix, :date, :category, :user)");
        $sql->bindParam(':titre',$title);
        $sql->bindParam(':description',$description);
        $sql->bindParam(':prix',$price);
        $sql->bindParam(':date',$date);
        $sql->bindParam(':category',$category);
        $sql->bindParam(':user',$_SESSION["id"]);
        $sql->execute();
    
        $sqld =$this->pdo->prepare("SELECT * FROM event ORDER BY id DESC LIMIT 1");
        $sqld->execute();
        $sqld->fetch();
    
        $id_event = $sqld["id"];
    
        foreach($img as $image){
            $sql =$this->pdo->prepare("INSERT INTO image(link, id_event) VALUES (:link, :id)");
            $sql->bindParam(':link',$img["link"]);
            $sql->bindParam(':id',$id_event);
            $sql->execute();
        }
    }
}
