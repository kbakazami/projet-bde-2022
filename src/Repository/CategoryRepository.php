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
        $stmt = $this->pdo->prepare("SELECT id, title FROM category");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
