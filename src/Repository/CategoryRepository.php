<?php

namespace App\Repository;

use App\Entity\Category;
use PDO;

final class CategoryRepository extends AbstractRepository
{
    protected const TABLE = 'category';

    public function save(Category $category): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO category (title, color) VALUES (:title, :color)");

        return $stmt->execute([
            'title' => $category->getTitle(),
            'color' => $category->getColor(),
        ]);
    }

    public function findAllCategory(){
        $stmt = $this->pdo->prepare("SELECT id, title, color FROM category");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function findAllCategoryCountEvent()
    {
        $stmt = $this->pdo->prepare(" SELECT category.id AS id ,category.title AS title,color,COUNT(event.id) AS nombre FROM category LEFT JOIN event ON category.id = event.id_category GROUP BY 1,2,3");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function findAllCategoryCountEventByPage($page, $limit)
    {
        $stmt = $this->pdo->prepare(" SELECT category.id AS id ,category.title AS title,color,COUNT(event.id) AS nombre FROM category LEFT JOIN event ON category.id = event.id_category GROUP BY 1,2,3 LIMIT :limit OFFSET :offset");

        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $page, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function countRow(){
        $pdo = "SELECT COUNT(*) FROM category";
        $stmt = $this->pdo->prepare($pdo);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function findCategoryById(int $id){
        $stmt = $this->pdo->prepare("SELECT id, title, color FROM category WHERE id = :id");

        $stmt->execute([
            'id' => $id
        ]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function findCategoryEventById(int $id)
    {
        $stmt = $this->pdo->prepare("SELECT title, color FROM category, event WHERE category.id = :id");

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function updateCategory(Category $category, $id){
        $stmt = $this->pdo->prepare("UPDATE category SET title = :title, color = :color WHERE id = :id");

        return $stmt->execute([
            'title' => $category->getTitle(),
            'color' => $category->getColor(),
            'id' => $id
        ]);
    }

    public function deleteCategory(int $id){
        $stmt = $this->pdo->prepare("DELETE FROM category WHERE id = :id");

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function setParDefaut(int $id){
        $stmt = $this->pdo->prepare("UPDATE event SET id_category = 0 WHERE id_category = :id ");

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function findCatByRecherche(string $recherche){
        $stmt = $this->pdo->prepare(" SELECT category.id AS id ,category.title AS title,color,COUNT(event.id) AS nombre FROM category LEFT JOIN event ON category.id = event.id_category WHERE category.title LIKE :recherche GROUP BY 1,2,3");

        $stmt->execute([
            'recherche' => "%".$recherche."%"
        ]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
