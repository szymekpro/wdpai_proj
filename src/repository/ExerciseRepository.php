<?php

require_once __DIR__ . '/Repository.php';
require_once __DIR__ . '/../models/Exercise.php';

class ExerciseRepository extends Repository
{
     public function getExercise(string $name): ?Exercise {
         $stmt = $this->db->connect()->prepare(
             "SELECT e.id id,e.name name ,e.photo_path photo_path,e.description description,c.name category,e.difficulty difficulty FROM public.exercises as e join public.categories c on e.category_id = c.id WHERE e.name = :name"
         );
         $stmt->bindParam(':name', $name, PDO::PARAM_STR);
         $stmt->execute();

         $exercise = $stmt->fetch(PDO::FETCH_ASSOC);

         if (!$exercise) {
             return null;
         }

         return new Exercise(
             $exercise['id'],
             $exercise['name'],
             $exercise['photo_path'],
             $exercise['description'],
             $exercise['category'],
             $exercise['difficulty']
         );
     }

     public function getExerciseById(int $id): ?Exercise {
         $stmt = $this->db->connect()->prepare(
             "SELECT e.id id,e.name name ,e.photo_path photo_path,e.description description,c.name category,e.difficulty difficulty 
                    FROM public.exercises as e 
                    join public.categories c on e.category_id = c.id 
                    WHERE e.id = :id"
         );
         $stmt->bindParam(':id', $id, PDO::PARAM_INT);
         $stmt->execute();

         $exercise = $stmt->fetch(PDO::FETCH_ASSOC);
         if (!$exercise) {
             return null;
         }
         return new Exercise($exercise['id'],
             $exercise['name'],
             $exercise['photo_path'],
             $exercise['description'],
             $exercise['category'],
             $exercise['difficulty']);
     }

     public function getAllExercises(): array {
         $stmt = $this->db->connect()->prepare(
             "SELECT e.id id,e.name name ,e.photo_path photo_path,e.description description,c.name category,e.difficulty difficulty FROM public.exercises as e join public.categories c on e.category_id = c.id"
         );

         $stmt->execute();
         $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

         $exerciseObj = [];

         foreach ($results as $row) {
             $exerciseObj[] = new Exercise(
                 $row['id'],
                 $row['name'],
                 $row['photo_path'],
                 $row['description'],
                 $row['category'],
                 $row['difficulty']
             );
         }
         return $exerciseObj;
     }

    public function getExercisesByName(string $name): array {
        $stmt = $this->db->connect()->prepare(
            "SELECT e.id id, e.name name, e.photo_path photo_path, e.description description, c.name category, e.difficulty difficulty
         FROM public.exercises AS e
         JOIN public.categories c ON e.category_id = c.id
         WHERE e.name ILIKE :name"
        );
        $likeQuery = '%' . $name . '%';
        $stmt->bindParam(':name', $likeQuery, PDO::PARAM_STR);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $exerciseObj = [];

        foreach ($results as $row) {
            $exerciseObj[] = new Exercise(
                $row['id'],
                $row['name'],
                $row['photo_path'],
                $row['description'],
                $row['category'],
                $row['difficulty']
            );
        }
        return $exerciseObj;
    }

}