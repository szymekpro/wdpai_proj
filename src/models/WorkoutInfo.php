<?php

class WorkoutInfo
{
    private $workoutId;
    private $exerciseId;
    private $sets;
    private $reps = [];
    private $weight;
    private $notes;

    public function __construct(int $workoutId, int $exerciseId,int $sets, $reps, float $weight, string $notes) {
        $this->workoutId = $workoutId;
        $this->exerciseId = $exerciseId;
        $this->sets = $sets;
        $this->reps = $reps;
        $this->weight = $weight;
        $this->notes = $notes;
    }
    public function getExerciseId(): int {
        return $this->exerciseId;
    }
    public function setExerciseId(int $exerciseId): void {
        $this->exerciseId = $exerciseId;
    }
    public function getWorkoutId() : int {
        return $this->workoutId;
    }
    public function setWorkoutId(int $workoutId) {
        $this->workoutId = $workoutId;
    }
    public function getSets() {
        return $this->sets;
    }
    public function setSets($sets) {
        $this->sets = $sets;
    }
    public function getReps() {
        return $this->reps;
    }
    public function setReps($reps) {
        $this->reps = $reps;
    }
    public function getWeight() {
        return $this->weight;
    }
    public function setWeight($weight) {
        $this->weight = $weight;
    }
    public function getNotes() {
        return $this->notes;
    }
    public function setNotes($notes) {
        $this->notes = $notes;
    }

}