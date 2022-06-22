<?php

namespace App\Entity;

use DateTime;

class News
{
    private int $id;
    private string $nameNews;
    private string $descriptionNews;
    private DateTime $dateNews;
    private string $linkNews;

    public function getId(): int
    {
        return $this->id;
    }

    public function getNameNews(): string
    {
        return $this->nameNews;
    }

    public function setNameNews(string $nameNews): self
    {
        $this->nameNews = $nameNews;

        return $this;
    }

    public function getDescriptionNews(): string
    {
        return $this->descriptionNews;
    }

    public function setDescriptionNews(string $descriptionNews): self
    {
        $this->descriptionNews = $descriptionNews;

        return $this;
    }

    public function getDateNews(): DateTime
    {
        return $this->dateNews;
    }

    public function setDateNews(DateTime $dateNews): void
    {
        $this->dateNews = $dateNews;
    }

    public function getLinkNews(): string
    {
        return $this->linkNews;
    }

    public function setLinkNews(string $linkNews): self
    {
        $this->linkNews = $linkNews;

        return $this;
    }
}