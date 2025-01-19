<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


require_once __DIR__ . '/../../src/repository/ExerciseRepository.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $search = $_POST['search'];
    $exerciseRepository = new ExerciseRepository();
    $exercises = $exerciseRepository->getExercisesByName($search);

    header('Content-Type: application/json');
    $response = [];

    foreach ($exercises as $exercise) {
        $response[] = [
            'id' => $exercise->getId(),
            'name' => $exercise->getName(),
        ];
    }

    echo json_encode($response);
    exit;

}
