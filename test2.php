<?php

// Database connection settings
$host = '172.17.0.1';
$port = '5432';
$dbname = 'wdpai';
$user = 'root';
$password = 'root';

try {
    // Create a PostgreSQL database connection using PDO
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
    $pdo = new PDO($dsn, $user, $password);

    // Set error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT * from public.exercises";
    $stmt = $pdo->query($query);

    // Fetch all records as an associative array
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Display the results in a table
    foreach ($results as $row) {
        echo $row['name'] . "<br>";
        echo $row['photo_path'] . "<br>";
        echo $row['description'] . "<br>";
        echo $row['muscle_group'] . "<br>";
        echo $row['difficulty'] . "<br><br>";
    }

} catch (PDOException $e) {
    // Handle any errors
    echo "Error: " . $e->getMessage();
}
?>
