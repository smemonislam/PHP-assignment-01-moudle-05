<?php require_once("./header/header.php"); ?>
<?php


if (!isset($_SESSION['email'])) {
    header('Location:' . BASE_URL . "/login/index.php");
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