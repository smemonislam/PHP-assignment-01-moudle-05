<?php

$id = $_GET['id'];
$filePath = "C:/laragon/www/PHP/File Operations/CRUD_OPERATION/database/db.txt";

if (file_exists($filePath)) {
    $data = json_decode(file_get_contents($filePath), true) ?? [];

    // echo "<pre>";
    // print_r($data);
    // echo "</pre>";
    foreach ($data as $key => $item) {
        if ($item['id'] == $id) {
            unset($data[$key]);
        }
    }



    // array_push($data, );
    file_put_contents($filePath, json_encode($data));
    header("location:http://localhost:3000/public");
}
