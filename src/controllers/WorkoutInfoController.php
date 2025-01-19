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

                $userEmail = $_SESSION['user_email'];
                $workout = new Workout($workoutName, $userEmail, $workoutDate);
                $this->workoutRepository->addWorkout($workout);
                $workoutId = $this->workoutRepository->getWorkoutIdByName($workoutName);

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

    public function delete()
    {


        if ($this->isPost()) {
           // $workoutId = $_POST['workout_id'] ?? null;
            //echo $_POST['workout_id'];

            //request workout ID: {"workout_id":"1"}
            $workoutId = json_decode(file_get_contents('php://input'), true)['workout_id'] ?? null;

            if (!$workoutId) {
                echo json_encode(['success' => false, 'message' => 'Brak ID treningu - Controller']);
                exit;
            }

            try {
                $this->workoutInfoRepository->deleteWorkoutExercises($workoutId);
                $this->workoutRepository->deleteWorkout($workoutId);
                echo json_encode(['success' => true]);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
            exit;
        }

        //$this->render('delete_workout', ['messages' => $this->messages]);
        //$url = '/new';
        //header("Location: $url");
        //exit;
    }

    public function edit()
    {
        if ($this->isGet()) {
            $id = $_GET['id'] ?? null;
            error_log("GET: " . print_r($_GET, true));

            $userEmail = $_SESSION['user_email'];

            if (isset($userEmail)) {
                $workout = $this->workoutRepository->getWorkout($userEmail, $id);
            } else {
                echo 'Email not set';
            }

            if (!$id) {
                header("Location: /new");
                exit;
            }

            if (!$this->isPost()) {
                return $this->render('edit_workout', ['workout' => $workout, 'workoutId' => $id]);
            }
        }

        if ($this->isPost()) {
            $id = $_GET['id'] ?? null;

            if (!$id) {
                echo json_encode(['success' => false, 'message' => 'Brakuje ID treningu']);
                return;
            }

            // Pobierz dane z formularza
            $name = $_POST['name'] ?? null;
            $date = $_POST['date'] ?? null;
            $exercises = $_POST['exercises'] ?? null;

            if (!$name || !$date || !$exercises) {
                echo json_encode(['success' => false, 'message' => 'Brakuje wymaganych pól']);
                return;
            }


            try {
                $this->workoutRepository->updateWorkout($id, $name, $date);

                foreach ($exercises['exercise_id'] as $index => $exerciseId) {
                    $sets = $exercises['sets'][$index] ?? null;
                    $reps = $exercises['reps'][$index] ?? null;
                    $weight = $exercises['weight'][$index] ?? null;
                    $notes = $exercises['notes'][$index] ?? null;

                    //echo 'sets: ' . $sets . '<br>';
                    //echo 'reps: ' . $reps . var_dump($reps). '<br>';
                    //echo 'weight: ' . $weight . '<br>';
                    //echo 'notes: ' . $notes . '<br>';

                    if (!$sets || !$reps ) {
                        throw new Exception('Niepoprawne dane dla ćwiczenia');
                    }

                    if ($this->workoutInfoRepository->exerciseExists($id, $exerciseId)) {
                        $this->workoutInfoRepository->updateWorkoutExercise($id, $exerciseId, $sets, $reps, $weight, $notes);
                    } else {
                        $this->workoutInfoRepository->addWorkoutExercise($id, $exerciseId, $sets, $reps, $weight, $notes);
                    }
                }

                header("Location: /new");
                exit;

            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        }
    }
}