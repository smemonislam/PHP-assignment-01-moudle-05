<?php

$roll = $_GET['roll'];
$filePath = "C:/laragon/www/PHP/File Operations/CRUD/database/db.txt";

if (file_exists($filePath)) {
    $data = file_get_contents($filePath);
    $allStudents = json_decode($data, true);

    foreach ($allStudents as $key => $item) {
        if ($item["roll"] == $roll) {
            unset($allStudents[$key]);
        }
    }

    $studentData = json_encode($allStudents);
    file_put_contents($filePath, $studentData, LOCK_EX);

    header("Location: index.php");
}
