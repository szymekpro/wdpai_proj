<?php

class Workout
{
    private $id;
    private $name;
    private $userEmail;
    private $exercisesList = [];
    private $exercisesDataList = [];
    private $date;

    public function __construct(int $id, string $name, string $userEmail, string $date) {
        $this->id = $id;
        $this->name = $name;
        $this->userEmail = $userEmail;
        $this->date = $date;
    }
    public function addExercise(Exercise $exercise) {
        $this->exercisesList[] = $exercise;
    }
    public function getExercisesList(): array {
        return $this->exercisesList;
    }
    public function getId(): int {
        return $this->id;
    }

    public function getName() : string {
        return $this->name;
    }
    public function getDate() : string {
        return $this->date;
    }
    public function getUserEmail() : string {
        return $this->userEmail;
    }
    public function setName(string $name) {
        $this->name = $name;
    }
    public function setDate(string $date) {
        $this->date = $date;
    }
    public function setExercisesList(array $exercisesList): void
    {
        $this->exercisesList = $exercisesList;
    }
    public function setUserEmail(string $userEmail) {
        $this->userEmail = $userEmail;
    }
}