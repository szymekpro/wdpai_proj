<?php

require_once __DIR__ . '/Repository.php';
require_once __DIR__ . '/WorkoutRepository.php';
require_once __DIR__ . '/ExerciseRepository.php';
require_once __DIR__ . "/../models/WorkoutInfo.php";

class WorkoutInfoRepository extends Repository
{
    public function getWorkoutInfoByWorkout(Workout $workout) {

        $workoutName = $workout->getName();

        $stmt = $this->db->connect()->prepare("SELECT we.workout_id wid, we.exercise_id eid, we.sets sets, we.reps reps, we.weight weight, we.notes notes 
        FROM public.workout_exercises we
        join public.workouts w on w.id = we.workout_id
        join public.exercises e on we.exercise_id = e.id
        where w.name = :name");
        $stmt->bindParam(':name', $workoutName);
        $stmt->execute();

        $workoutInfoList = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$workoutInfoList) {
            return null;
        }

        $workoutInfoObjects = [];

        foreach ($workoutInfoList as $row) {
            $workoutInfoObjects[] = new WorkoutInfo(
                $row['wid'],
                $row['eid'],
                $row['sets'],
                //explode(',', $row['reps']),
                explode(',', trim($row['reps'], '{}')),
                (float) $row['weight'],
                $row['notes']
            );
        }

        return $workoutInfoObjects;
    }
    public function assignExercise(Workout $workout, WorkoutInfo $workoutInfo)
    {


        $stmt = $this->db->connect()->prepare("
            INSERT INTO public.workout_exercises (workout_id, exercise_id, sets,reps,weight,notes) 
            VALUES (?,?,?,?,?,?);
        ");
        $result = $stmt->execute([
            $workoutInfo->getWorkoutId(),
            $workoutInfo->getExerciseId(),
            $workoutInfo->getSets(),
            $workoutInfo->getReps(),
            $workoutInfo->getWeight(),
            $workoutInfo->getNotes()
        ]);
        if (!$result) {
            $errorInfo = $stmt->errorInfo();
            echo "Błąd podczas wykonywania zapytania: " . $errorInfo[2];
        }
    }

}