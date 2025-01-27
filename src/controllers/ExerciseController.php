<?php

require_once __DIR__ . '/AppController.php';
require_once __DIR__ . '/../repository/ExerciseRepository.php';

class ExerciseController extends AppController
{
    private $messages = [];
    private $exerciseRepository;

    public function __construct()
    {
        parent::__construct();
        $this->exerciseRepository = new ExerciseRepository();
    }

    /*public function addExercise()
    {
        if ($this->isPost()) {
            $exercises = $_POST['exercises'] ?? null;

            if (empty($exercises)) {
                $this->messages[] = 'Wszystkie pola muszą być uzupełnione!';
                return $this->render('add_exercise', ['messages' => $this->messages]);
            }

            try {

                for ($i = 0; $i < count($exercises['name']); $i++) {
                    $name = $exercises['name'][$i];
                    $photoPath = $exercises['photo_path'][$i];
                    $description = $exercises['description'][$i];
                    $category = $exercises['category'][$i];
                    $difficulty = $exercises['difficulty'][$i];

                    $exercise = new Exercise(
                        null,
                        $name,
                        $photoPath,
                        $description,
                        $category,
                        $difficulty
                    );

                    $this->exerciseRepository->addExercise($exercise);
                }

                $this->messages[] = '';
                header("Location: exercises");
                exit;

            } catch (Exception $e) {
                $this->messages[] = 'Błąd: ' . $e->getMessage();
            }

        }

        $this->render('add_exercise', ['messages' => $this->messages]);
    }*/

    public function addExercise()
    {

        if ($this->isPost()) {

            $name = $_POST['name'] ?? null;
            $photoPath = $_POST['photo_path'] ?? null;
            $description = $_POST['description'] ?? null;
            $category = $_POST['category'] ?? null;
            $difficulty = $_POST['difficulty'] ?? null;

            if (!$name || !$photoPath || !$description || !$category || !$difficulty) {
                http_response_code(400);
                echo 'All fields must be filled!';
                return;
            }


            try {
                $exercise = new Exercise(
                    0,
                    $name,
                    $photoPath,
                    $description,
                    $category,
                    $difficulty
                );

                $this->exerciseRepository->addExercise($exercise);

                header('Location: addExercise');
            } catch (Exception $e) {
                http_response_code(500);
                echo 'Error: ' . $e->getMessage();
            }
        }
        if ($this->isGet()) {
            return $this->render('add_exercise', ['messages' => $this->messages]);
        }
    }

    public function deleteExercise()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $exerciseId = $data['exercise_id'] ?? null;

        if (!$exerciseId) {
            echo json_encode(['success' => false, 'message' => 'Invalid exercise ID']);
            exit;
        }

        try {
            $this->exerciseRepository->deleteExercise($exerciseId); // Wywołanie metody usuwającej ćwiczenie
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }



}