<?php
require_once("./header/header.php");
require_once("./config.php");



if (!isset($_SESSION['email'])) {
    header('Location:' . BASE_URL . "/login/index.php");
}

if (isAdmin()) {
    header('Location:' . BASE_URL . "/dashboard/index.php");
}


?>

<section class="vh-100" style="background-color: #eee;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mt-5">
                <?php echo "Welcome, " . $_SESSION['username'] . "! You are now logged in."; ?>
            </div>
        </div>
    </div>
</section>
<?php require_once("./header/footer.php"); ?>