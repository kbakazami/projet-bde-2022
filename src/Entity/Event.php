<?php

namespace App\Entity;

use DateTime;

class Event
{
    private int $id;
    private string $titleEvent;
    private string $descriptionEvent;
    private float $priceEvent;
    private DateTime $dateEvent;
    private string $imageEvent;
    private int $idCategory;
    private int $idCreator;

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitleEvent(): string
    {
        return $this->titleEvent;
    }

    public function setTitleEvent(string $titleEvent): self
    {
        $this->titleEvent = $titleEvent;

        return $this;
    }

    public function getDescriptionEvent(): string
    {
        return $this->descriptionEvent;
    }

    public function setDescriptionEvent(string $descriptionEvent): self
    {
        $this->descriptionEvent = $descriptionEvent;

        return $this;
    }

    public function getPriceEvent(): float
    {
        return $this->priceEvent;
    }

    public function setPriceEvent(string $priceEvent): self
    {
        $this->priceEvent = $priceEvent;

        return $this;
    }

    public function getDateEvent(): DateTime
    {
        return $this->dateEvent;
    }

    public function setDateEvent(DateTime $dateEvent): self
    {
        $this->dateEvent = $dateEvent;

        return $this;
    }

    public function getImageEvent(): string
    {
        return $this->imageEvent;
    }

    public function setImageEvent(string $imageEvent): self
    {
        $this->imageEvent = $imageEvent;

        return $this;
    }

    public function getIdCreator(): int
    {
        return $this->idCreator;
    }

    public function setIdCreator(int $idCreator): self
    {
        $this->idCreator = $idCreator;

        return $this;
    }

    public function getIdCategory(): int
    {
        return $this->idCategory;
    }

    public function setIdCategory(int $idCategory): self
    {
        $this->idCategory = $idCategory;

        return $this;
    }
}
