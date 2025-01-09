<?php

class Exercise
{
    private $id;
    private $name;
    private $photo_path;
    private $description;
    private $category;
    private $difficulty;

    public function __construct(int $id, string $name, string $photo_path, string $description, string $category,string $difficulty) {
        $this->id = $id;
        $this->name = $name;
        $this->photo_path = $photo_path;
        $this->description = $description;
        $this->category = $category;
        $this->difficulty = $difficulty;
    }
    public function getId(): int {
        return $this->id;
    }
    public function getName(): string {
        return $this->name;
    }
    public function getPhotoPath(): string {
        return $this->photo_path;
    }
    public function getDescription(): string {
        return $this->description;
    }
    public function getCategory(): string {
        return $this->category;
    }
    public function getDifficulty(): string {
        return $this->difficulty;
    }
}