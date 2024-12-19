<?php

namespace repository;
use models\Exercise;
use PDO;

require_once __DIR__ . '/Repository.php';
require_once __DIR__ . '/../models/Exercise.php';

class ExerciseRepository extends Repository
{
     public function getExercise(string $name): Exercise {
         $stmt = $this->db->connect()->prepare(
             "SELECT * FROM public.exercises WHERE name = :name"
         );
         $stmt->bindParam(':name', $name, PDO::PARAM_STR);
         $stmt->execute();

         $exercise = $stmt->fetch(PDO::FETCH_ASSOC);

         if (!$exercise) {
             echo "no exercise";
         }

         return new Exercise(
             $exercise['name'],
             $exercise['photo_path'],
             $exercise['description'],
             $exercise['muscle_group'],
             $exercise['difficulty']
         );
     }

     public function getAllExercises(): array {
         $stmt = $this->db->connect()->prepare(
             "SELECT * FROM public.exercises"
         );
         $stmt->bindParam(':name', $name, PDO::PARAM_STR);
         $stmt->execute();
         $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

         $exerciseObj = [];

         foreach ($results as $row) {
             $exerciseObj[] = new Exercise(
                 $row['name'],
                 $row['photo_path'],
                 $row['description'],
                 $row['muscle_group'],
                 $row['difficulty']
             );
         }
         return $exerciseObj;
     }
}