<?php
require_once("../../header/header.php");
require_once("../../functions.php");

if (!isset($_SESSION['email']) || !isset($_SESSION['loggedin'])) {
    header('Location:' . BASE_URL . "/login/index.php");
    exit();
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
    header("Location: " . BASE_URL . "/dashboard/index.php?success=" . urlencode($successMessage));
    exit();
} catch (Exception $e) {
    $errorMessage = $e->getMessage();
}
require_once("../../header/footer.php");
