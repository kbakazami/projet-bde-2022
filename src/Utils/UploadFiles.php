<?php

namespace App\Utils;

class UploadFiles
{
    private string $nameFile;
    private string $typeFile;
    private string $tmpNameFile;
    private int $errors;

    public function __construct($uploadedFile)
    {
        $this->nameFile = $uploadedFile['name'];
        $this->typeFile = $uploadedFile['type'];
        $this->tmpNameFile = $uploadedFile['tmp_name'];
        $this->errors = $uploadedFile['error'];
    }

    /**
     * @return string
     */
    public function getNameFile(): string
    {
        return $this->nameFile;
    }

    /**
     * @param string $nameFile
     */
    public function setNameFile(string $nameFile): self
    {
        $this->nameFile = $nameFile;

        return $this;
    }

    /**
     * @return string
     */
    public function getTypeFile(): string
    {
        return $this->typeFile;
    }

    /**
     * @param string $typeFile
     */
    public function setTypeFile(string $typeFile): self
    {
        $this->typeFile = $typeFile;

        return $this;
    }

    /**
     * @return string
     */
    public function getTmpNameFile(): string
    {
        return $this->tmpNameFile;
    }

    /**
     * @param string $tmpNameFile
     */
    public function setTmpNameFile(string $tmpNameFile): self
    {
        $this->tmpNameFile = $tmpNameFile;

        return $this;
    }

    /**
     * @return int
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param int $errors
     */
    public function setErrors(int $errors): self
    {
        $this->errors = $errors;

        return $this;
    }

    public function upload(): string
    {
        $filename = uniqid() . "-" . time();
        $extension = $this->getTypeFile();
        if($extension === "image/png")
        {
            $extension = "png";
        }
        elseif ($extension === "image/jpeg")
        {
            $extension = "jpeg";
        }
        elseif($extension === "image/jpg")
        {
            $extension = "jpg";
        }
        $basename = $filename  .  "." . $extension;

        $source = $this->getTmpNameFile();
        $destination = "./public/img/{$basename}";

        move_uploaded_file($source, $destination);

        return $basename;
    }

}