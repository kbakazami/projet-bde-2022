<?php

namespace App\Repository;

use App\Entity\Category;

final class CategoryRepository extends AbstractRepository
{
    protected const TABLE = 'category';

    public function save(Category $cateegory): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO category (title, color) VALUES (:title, :color)");

        return $stmt->execute([
            'title' => $cateegory->getTitle(),
            'color' => $cateegory->getColor(),
        ]);
    }

    public function findAllCategory(){
        $stmt = $this->pdo->prepare("SELECT title FROM category");

        $stmt->execute();
        return $stmt->fetch();
    }
}
