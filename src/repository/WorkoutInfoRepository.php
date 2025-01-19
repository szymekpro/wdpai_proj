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

    public function deleteWorkoutExercises($workoutId)
    {
        $stmt = $this->db->connect()->prepare("DELETE FROM public.workout_exercises WHERE workout_id = :id");
        $stmt->bindParam(':id', $workoutId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function updateWorkoutExercise($workoutId, $exerciseId, $sets, $reps, $weight, $notes)
    {
        $formattedReps = '{' . implode(',', explode(',', trim($reps, '{}'))) . '}';
        //echo 'new reps: ' . $formattedReps . '<br>';

        $stmt = $this->db->connect()->prepare(
            'UPDATE public.workout_exercises 
            SET sets = ?, reps = ?, weight = ?, notes = ? 
            WHERE workout_id = ? AND exercise_id = ?'
        );
        $stmt->execute([$sets, $formattedReps, (float)$weight, $notes, $workoutId, $exerciseId]);
    }

    public function exerciseExists($workoutId, $exerciseId)
    {
        $stmt = $this->db->connect()->prepare(
            'SELECT COUNT(*) FROM public.workout_exercises WHERE workout_id = ? AND exercise_id = ?'
        );
        $stmt->execute([$workoutId, $exerciseId]);
        return $stmt->fetchColumn() > 0;
    }

    public function addWorkoutExercise($workoutId, $exerciseId, $sets, $reps, $weight, $notes)
    {
        $formattedReps = '{' . implode(',', array_map('intval', explode(',', trim($reps)))) . '}';
        $stmt = $this->db->connect()->prepare(
            'INSERT INTO public.workout_exercises (workout_id, exercise_id, sets, reps, weight, notes) 
         VALUES (?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([$workoutId, $exerciseId, $sets, $formattedReps, (float)$weight, $notes]);
    }

}