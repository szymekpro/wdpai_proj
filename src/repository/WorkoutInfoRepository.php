<?php

require_once __DIR__ . '/Repository.php';
require_once __DIR__ . '/WorkoutRepository.php';
require_once __DIR__ . '/ExerciseRepository.php';
require_once __DIR__ . "/../models/WorkoutInfo.php";

class WorkoutInfoRepository extends Repository
{
    public function getWorkoutInfoByWorkout(int $workoutId) {

        $stmt = $this->db->connect()->prepare("SELECT we.workout_id wid, we.exercise_id eid, we.sets sets, we.reps reps, we.weight weight, we.notes notes FROM public.workout_exercises we
        join public.exercises e on we.exercise_id = e.id
        where we.workout_id= :workout_id");
        $stmt->bindParam(':workout_id', $workoutId);
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

}