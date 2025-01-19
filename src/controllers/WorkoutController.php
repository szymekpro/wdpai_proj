<?php

require_once __DIR__ . '/AppController.php';
require_once __DIR__ . '/../repository/WorkoutRepository.php';

class WorkoutController extends AppController
{
    private $messages = [];
    private $workoutRepository;

    public function __construct()
    {
        parent::__construct();
        $this->workoutRepository = new WorkoutRepository();
    }

    public function add()
    {

        if ($this->isPost()) {
            $name = $_POST['name'] ?? null;
            $date = $_POST['date'] ?? null;

            if (empty($name) || empty($date)) {
                $this->messages[] = 'Wszystkie pola muszą być uzupełnione!';
                return $this->render('add_workout', ['messages' => $this->messages]);
            }

            if (!isset($_SESSION['user_email'])) {
                $this->messages[] = 'Musisz być zalogowany, aby dodać trening!';
                return $this->render('add_workout', ['messages' => $this->messages]);
            }

            try {
                $userEmail = $_SESSION['user_email'];
                $workout = new Workout($name, $userEmail, $date);
                echo "kontroler dziala";
                $this->workoutRepository->addWorkout($workout);

                $this->messages[] = 'Trening został dodany pomyślnie!';
            } catch (Exception $e) {
                $this->messages[] = 'Błąd podczas dodawania treningu: ' . $e->getMessage();
            }
        }
        $this->render('add_workout', ['messages' => $this->messages]);
    }

}