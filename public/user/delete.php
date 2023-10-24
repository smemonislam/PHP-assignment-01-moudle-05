<?php
if (!isset($_SESSION['email']) && !isset($_SESSION['loggedin'])) {
    header('Location:' . BASE_URL);
}


$id = $_GET['id'];
$filePath = "C:/laragon/www/PHP/File Operations/CRUD_OPERATION/database/db.txt";
if (file_exists($filePath)) {
    $data = json_decode(file_get_contents($filePath), true) ?? [];

    foreach ($data as $key => $item) {
        if ($item['id'] == $id) {
            unset($data[$key]);
        }
    }

    file_put_contents($filePath, json_encode($data), LOCK_EX);
    header("location:http://localhost:3000/public/index.php?success=Delete Successfully.");
}
