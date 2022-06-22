<?php

namespace App\Repository;

use App\Entity\News;
use PDO;

final class NewsRepository extends AbstractRepository
{
    protected const TABLE = 'news';

    public function save(News $news): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO news (name, description,date, link) VALUES (:name , :description, :date, :link)");

        return $stmt->execute([
            'name' => $news->getNameNews(),
            'description' => $news->getDescriptionNews(),
            'date' => $news->getDateNews()->format('Y-m-d'),
            'link' => $news->getLinkNews()
        ]);
    }

    public function findAllNews()
    {
        $stmt = $this->pdo->prepare("SELECT id, name, description, date, link FROM news");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function findNewsById(int $id)
    {
        $stmt = $this->pdo->prepare("SELECT id, name, description, date, link FROM news WHERE id = :id");

        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function updateNews(News $news, $id)
    {
        $stmt = $this->pdo->prepare("UPDATE news SET name = :name, description = :description, date = :date, link = :link WHERE id = :id");

        return $stmt->execute([
            'name' => $news->getNameNews(),
            'description' => $news->getDescriptionNews(),
            'date' => $news->getDateNews()->format('Y-m-d'),
            'link' => $news->getLinkNews(),
            'id' => $id
        ]);
    }

    public function deleteNews(int $id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM news WHERE id = :id");

        return $stmt->execute([
            'id' => $id
        ]);
    }
}