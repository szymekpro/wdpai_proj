<?php

namespace src\models;

class Exercise
{
    private $name;
    private $photo_path;
    private $description;
    private $muscle_group;
    private $difficulty;

    public function __construct(string $name, string $photo_path, string $description, string $muscle_group,string $difficulty) {
        $this->name = $name;
        $this->photo_path = $photo_path;
        $this->description = $description;
        $this->muscle_group = $muscle_group;
        $this->difficulty = $difficulty;
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
    public function getMuscleGroup(): string {
        return $this->muscle_group;
    }
    public function getDifficulty(): string {
        return $this->difficulty;
    }
}