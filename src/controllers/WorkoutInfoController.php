<?php

require_once __DIR__ . '/AppController.php';
require_once __DIR__ . '/../repository/WorkoutInfoRepository.php';
require_once __DIR__ . '/../repository/WorkoutRepository.php';

class WorkoutInfoController extends AppController
{
    private $messages = [];
    private $workoutRepository;
    private $workoutInfoRepository;

    public function __construct()
    {
        parent::__construct();
        $this->workoutInfoRepository = new WorkoutInfoRepository();
        $this->workoutRepository = new WorkoutRepository();
    }

    public function assign()
    {
        if ($this->isPost()) {
            $workoutName = $_POST['name'] ?? null;
            $workoutDate = $_POST['date'] ?? null;
            $exercises = $_POST['exercises'] ?? null;

            if (empty($workoutName) || empty($workoutDate) || empty($exercises)) {
                $this->messages[] = 'Wszystkie pola muszą być uzupełnione!';
                return $this->render('add_workout', ['messages' => $this->messages]);
            }

            try {
                // Dodaj trening
                $userEmail = $_SESSION['user_email'];
                $workout = new Workout($workoutName, $userEmail, $workoutDate);
                $this->workoutRepository->addWorkout($workout);

                // Pobierz ID treningu
                $workoutId = $this->workoutRepository->getWorkoutIdByName($workoutName);


                // Iteracja po ćwiczeniach i przypisywanie ich do treningu
                for ($i = 0; $i < count($exercises['exercise_id']); $i++) {
                    $exerciseId = $exercises['exercise_id'][$i];
                    $sets = (int)$exercises['sets'][$i];
                    $reps = '{' . implode(',', array_map('intval', explode(',', $exercises['reps'][$i]))) . '}';
                    error_log("Przekazany reps: " . $reps);
                    $weight = (float)$exercises['weight'][$i];
                    $notes = $exercises['notes'][$i];

                    $workoutInfo = new WorkoutInfo($workoutId, $exerciseId, $sets, $reps, $weight, $notes);
                    $this->workoutInfoRepository->assignExercise($workout, $workoutInfo);
                }

                $this->messages[] = 'Trening i ćwiczenia zostały dodane pomyślnie!';
            } catch (Exception $e) {
                $this->messages[] = 'Błąd podczas dodawania treningu i ćwiczeń: ' . $e->getMessage();
            }

            $this->render('add_workout', ['messages' => $this->messages]);
        }
    }


}