<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/public/functions.php';

if (!isset($_SESSION['email']) || !isset($_SESSION['loggedin'])) {
    header('Location:' . BASE_URL . "/login/index.php");
    exit();
}

// Check if the user is an admin
if (!isAdmin()) {
    header('Location: ' . BASE_URL . "/index.php");
    exit;
}

$id = $_GET['id'];

try {
    $data = readDatabaseFile(DB_FILE_PATH);
    $item = findDataById($data, $id);
    if (!$item) {
        header("Location:" . BASE_URL . "/dashboard/index.php");
        exit();
    }

    foreach ($data as $key => $item) {
        if ($item['id'] == $id) {
            unset($data[$key]);
        }
    }

    writeDatabaseFile(DB_FILE_PATH, $data);

    // Redirect to a success page with a message
    $successMessage = 'Delete Successfully.';
    header("Location: " . BASE_URL . "/dashboard/user/index.php?success=" . urlencode($successMessage));
    exit();
} catch (Exception $e) {
    $errorMessage = $e->getMessage();
}
