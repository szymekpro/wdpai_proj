<?php


use src\repository\ExerciseRepository;

class ExerciseProvider
{
    public function getExercises() {
        $exerciseRepository = new ExerciseRepository();
        $exercise = $exerciseRepository->getExercise();

        if (!$exercise) {
            //return $this->render('getExercise',['messages' => ['exercise not found']]);
            echo 'exercise not found';
        }
    }
}