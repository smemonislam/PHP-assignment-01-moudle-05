<?php
require_once("./header/header.php");
require_once("./functions.php");

// Check if the user is not authenticated
if (!isset($_SESSION['loggedin'])) {
    header('Location: ' . BASE_URL . "/login/index.php");
    exit;
}

// Check if the user is an admin
if (isAdmin()) {
    header('Location: ' . BASE_URL . "/dashboard/index.php");
    exit;
}

// At this point, the user is not an admin and not authenticated

?>
<section class="vh-100" style="background-color: #eee;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mt-5">
                <?php
                if (isset($_SESSION['username'])) {
                    echo "Welcome, " . htmlspecialchars($_SESSION['username']) . "! You are now logged in.";
                }
                ?>
            </div>
        </div>
    </div>
</section>
<?php require_once("./header/footer.php"); ?>