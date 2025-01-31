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

     public function getExerciseCategoryID(string $category): int
     {
         $stmt = $this->db->connect()->prepare(
             "SELECT categories.id category
                    FROM public.categories
                    WHERE categories.name = :category"
         );
         $stmt->bindParam(':category', $category, PDO::PARAM_STR);
         $stmt->execute();

         $exerciseCategory = $stmt->fetch(PDO::FETCH_ASSOC);

         if (!$exerciseCategory) {
             return 0;
         }
         return $exerciseCategory['category'];
     }

     public function getAllCategories(): array {
         $stmt = $this->db->connect()->prepare("SELECT categories.name category FROM public.categories");
         $stmt->execute();
         $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
         if (!$categories) {
             return [];
         }
         return array_column($categories, 'category');
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

    public function addExercise(Exercise $exercise) : void {

        $stmt = $this->db->connect()->prepare('
        INSERT INTO public.exercises(name, photo_path, description, category_id, difficulty) 
        VALUES (?,?,?,?,?)
        ');

        if (!isset($_SESSION['user_id'])) {
            die("User not logged in!");
        }
        $userid = $_SESSION['user_id'];

        $userRepository = new UserRepository();
        //$user = $userRepository->getUserByID($userid);
        echo json_encode($exercise->getCategory());
        $category = $exercise->getCategory();
        $exerciseCategoryID = $this->getExerciseCategoryID($category);

        if ($userRepository->isAdmin($userid)) {
            $stmt->execute([
                $exercise->getName(),
                $exercise->getPhotoPath(),
                $exercise->getDescription(),
                $exerciseCategoryID,
                $exercise->getDifficulty()
            ]);
        }
        else {
            die("User has insufficient permissions!");
        }

    }

    public function deleteExercise($exerciseId) {

        $stmt = $this->db->connect()->prepare("DELETE FROM exercises WHERE id = :id");
        $stmt->bindParam(':id', $exerciseId, PDO::PARAM_INT);
        $stmt->execute();
    }


}