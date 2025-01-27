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
                explode(',', trim($row['reps'], '{}')),
                (float) $row['weight'],
                $row['notes']
            );
        }

        return $workoutInfoObjects;
    }

    public function getExerciseByWorkoutInfo($id) : ?Exercise
    {
        $stmt = $this->db->connect()->prepare("
            SELECT we.exercise_id id, e.name name, e.photo_path photo_path, e.description description, c.name category, e.difficulty difficulty from public.workout_exercises we
            join exercises e on we.exercise_id = e.id
            join public.categories c on c.id = e.category_id
            where e.id = :id limit 1");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $exercise = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$exercise) {
            return null;
        }

        return new Exercise($exercise['id'], $exercise['name'],$exercise['photo_path'],$exercise['description'],$exercise['category'],$exercise['difficulty']);
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

    public function getWorkoutInfoId($workoutId, $exerciseId, $sets, $weight, $notes)
    {
        $stmt = $this->db->connect()->prepare('
        SELECT id FROM public.workout_exercises we
        WHERE we.exercise_id = :exercise_id AND we.workout_id = :workout_id AND we.sets = :sets  AND we.weight = :weight AND we.notes = :notes');
        $stmt->bindParam(':exercise_id', $exerciseId);
        $stmt->bindParam(':workout_id', $workoutId);
        $stmt->bindParam(':sets', $sets);
        $stmt->bindParam(':weight', $weight);
        $stmt->bindParam(':notes', $notes);
        $stmt->execute();

        $workoutInfoId = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$workoutInfoId) {
            return null;
        }
        $id = $workoutInfoId['id'];
        return $id;
    }

    public function updateWorkoutExercise($workoutId, $exerciseId, $sets, $reps, $weight, $notes)
    {
        $formattedReps = '{' . implode(',', explode(',', trim($reps, '{}'))) . '}';
        $workoutInfoId = $this->getWorkoutInfoId($workoutId, $exerciseId, $sets, $weight, $notes);


        $stmt = $this->db->connect()->prepare(
            'UPDATE public.workout_exercises 
            SET sets = ?, reps = ?, weight = ?, notes = ? 
            WHERE workout_id = ? AND exercise_id = ? AND id = ?'
        );
        $stmt->execute([$sets, $formattedReps, (float)$weight, $notes, $workoutId, $exerciseId,$workoutInfoId ]);
        //echo 'new exercise ' . $notes . '<br>';
    }

    public function exerciseExists($workoutId, $exerciseId, $sets, $weight, $notes)
    {
        $stmt = $this->db->connect()->prepare(
            'SELECT COUNT(*) FROM public.workout_exercises WHERE workout_id = ? AND exercise_id = ? And sets = ? And weight = ? And notes = ?'
        );
        $stmt->execute([$workoutId, $exerciseId, $sets, $weight, $notes]);
        //echo 'exercise: ' . $notes  . ' exists: ' . $stmt->fetchColumn() . '<br>';
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

    public function deleteExerciseFromWorkout($workoutId, $exerciseId)
    {
        $stmt = $this->db->connect()->prepare("
        DELETE FROM public.workout_exercises
        WHERE workout_id = :workout_id AND exercise_id = :exercise_id
    ");

        $stmt->bindParam(':workout_id', $workoutId, PDO::PARAM_INT);
        $stmt->bindParam(':exercise_id', $exerciseId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function deleteAllUserExercises(int $userId)
    {
        $stmt = $this->db->connect()->prepare("
            DELETE FROM public.workout_exercises
            USING public.workouts
            WHERE workout_exercises.workout_id = workouts.id
            AND workouts.user_id = :user_id;
            ");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
    }

}