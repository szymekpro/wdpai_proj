<?php

//session_start();

require_once __DIR__ . '/Repository.php';
require_once __DIR__ . '/../models/Workout.php';

class WorkoutRepository extends Repository
{


    public function getWorkout(string $email,string $name) : ?Workout {

        $stmt = $this->db->connect()->prepare(
            "SELECT w.id id, w.name name, u.email email, w.date date 
                    FROM public.workouts w
                    join users u on w.user_id = u.id
                    where w.name = :name and u.email = :email");
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();

        $results = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$results) {
            return null;
        }

        return new Workout($results['name'], $results['email'], $results['date']);

    }


    public function getAllWorkouts(string $email) : array {
        if (!isset($_SESSION['user_email'])) {
            die("User not logged in!");
        }
        $userEmail = $_SESSION['user_email'];

        $stmt = $this->db->connect()->prepare("SELECT w.name name, u.email email, w.date date FROM public.workouts w
                    join users u on w.user_id = u.id where u.email = :email");
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$results) {
            return [];
        }
        $workouts = [];
        foreach ($results as $row) {
            $workouts[] = new Workout(
                $row['name'],
                $row['email'],
                $row['date']);
        }
        return $workouts;
    }

    public function setWorkoutExercises(Workout $workout) {
        $stmt = $this->db->connect()->prepare(
            "SELECT e.id id,e.name name, e.photo_path photo_path, e.description description, c.name category, e.difficulty difficulty
                    FROM public.workouts w
                    join workout_exercises we on w.id = we.workout_id
                    join exercises e on we.exercise_id = e.id
                    join users u on w.user_id = u.id
                    join categories c on e.category_id = c.id
                    where w.name = :name and u.email = :email");
        $name = $workout->getName();
        $email = $workout->getUserEmail();
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$results) {
            return null;
        }

        foreach ($results as $row) {
            $workout->addExercise(new Exercise($row['id'],$row['name'], $row['photo_path'], $row['description'], $row['category'],$row['difficulty']));
        }


    }

    public function setWorkoutExercisesWithData(Workout $workout) {
        $stmt = $this->db->connect()->prepare(
            "SELECT e.id id,e.name name, e.photo_path photo_path, e.description description, c.name category, e.difficulty difficulty
                    FROM public.workouts w
                    join workout_exercises we on w.id = we.workout_id
                    join exercises e on we.exercise_id = e.id
                    join users u on w.user_id = u.id
                    join categories c on e.category_id = c.id
                    where w.name = :name and u.email = :email");
        $name = $workout->getName();
        $email = $workout->getUserEmail();
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$results) {
            return null;
        }

        foreach ($results as $row) {
            $workout->addExercise(new Exercise($row['id'],$row['name'], $row['photo_path'], $row['description'], $row['category'],$row['difficulty']));
        }


    }

    public function addWorkout(Workout $workout) : void {

        $stmt = $this->db->connect()->prepare('
        INSERT INTO public.workouts(user_id, name, date, created_at) 
        VALUES (?,?,?,?)
        ');

        if (!isset($_SESSION['user_id'])) {
            die("User not logged in!");
        }
        $userid = $_SESSION['user_id'];

        $dateCreatedAt = new DateTime();
        $workoutDate = $workout->getDate();
        echo $workoutDate;

        $dateCreatedAt = $dateCreatedAt->format('Y-m-d H:i:s');
        //$workoutDate = $workoutDate->format('Y-m-d');

        $result = $stmt->execute([
            $userid,
            $workout->getName(),
            $workoutDate,
            $dateCreatedAt,
        ]);

        if (!$result) {
            $errorInfo = $stmt->errorInfo();
            echo "Błąd podczas wykonywania zapytania: " . $errorInfo[2];
        }
    }

    public function getWorkoutIdByName(string $name): int
    {
        $stmt = $this->db->connect()->prepare("SELECT id FROM public.workouts WHERE name = :name");
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            throw new Exception('Nie znaleziono treningu o podanej nazwie!');
        }

        return (int) $result['id'];
    }

}