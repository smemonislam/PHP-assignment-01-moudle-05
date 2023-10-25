<?php require_once("./header/header.php"); ?>
<?php


if (!isset($_SESSION['email'])) {
    header('Location:' . BASE_URL . "/login/index.php");
}

$filePath = "C:/laragon/www/PHP/File Operations/CRUD_OPERATION/database/db.txt";
if (file_exists($filePath) && is_readable($filePath)) {
    $allRegistrations = json_decode(file_get_contents($filePath), true);

    usort($allRegistrations, function ($a, $b) {
        return $a['id'] - $b['id'];
    });
}





?>

<section class="vh-100" style="background-color: #eee;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mt-5">
                Welcome to login
            </div>
        </div>
    </div>
</section>
<?php require_once("./header/footer.php"); ?>