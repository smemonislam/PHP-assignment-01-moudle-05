<?php
require_once("../header/header.php");
require_once("../../database/config.php");
?>

<?php

// Check if the user is logged in
if (!isset($_SESSION['email']) || !isset($_SESSION['loggedin'])) {
    header('Location: ' . BASE_URL);
    exit();
}

$id = $_GET["id"];

// Main code
try {
    $data = readDatabaseFile(DB_FILE_PATH);
    $item = findDataById($data, $id);

    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["update"])) {
        $username   = validatedInput($_POST['username']);
        $email      = validatedInput($_POST['email']);
        $password   = validatedInput($_POST['password']);

        if (empty($username) || empty($email) || empty($password)) {
            throw new Exception('All fields are required.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Email is invalid.');
        }

        // Update the data
        foreach ($data as $key => &$item) {
            if ($item["id"] == $id) {
                $item = [
                    'id' => $id,
                    'username' => $username,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                ];
                break;
            }
        }

        writeDatabaseFile(DB_FILE_PATH, $data);
        $successMessage = 'Update Successfully.';
        header("Location: " . BASE_URL . "/dashboard/index.php?success=" . urlencode($successMessage));
        exit();
    }
} catch (Exception $e) {
    $errorMessage = $e->getMessage();
}

?>




<!-- Section: Design Block -->
<section class="text-center">
    <div class="container">
        <!-- Background image -->
        <div class="p-5 bg-image" style="
        background-image: url('https://mdbootstrap.com/img/new/textures/full/171.jpg');
        height: 300px;
        "></div>
        <!-- Background image -->

        <div class="card mx-4 mx-md-5 shadow-5-strong" style="
        margin-top: -100px;
        background: hsla(0, 0%, 100%, 0.8);
        backdrop-filter: blur(30px);
        ">
            <div class="card-body py-5 px-md-5">

                <div class="row d-flex justify-content-center">
                    <div class="col-lg-6">
                        <h2 class="fw-bold mb-5">Sign up now</h2>
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>/?id=<?php echo $id; ?>" method="POST">
                            <?php if (isset($errorMessage)) :  ?>
                                <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
                            <?php endif; ?>
                            <div class="form-outline mb-4">
                                <input type="text" name="username" id="userName" class="form-control" value="<?php echo $item['username']; ?>" />
                                <label class="form-label" for="userName">Your Userame</label>
                            </div>
                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <input type="email" name="email" id="email3c" class="form-control" value="<?php echo $item['email']; ?>" />
                                <label class="form-label" for="email3c">Your Email</label>
                            </div>

                            <!-- Password input -->
                            <div class="form-outline mb-4">
                                <input type="password" name="password" id="form3Example4cd" class="form-control" />
                                <label class="form-label" for="form3Example4cd">Enter your password</label>
                            </div>

                            <!-- Checkbox -->
                            <div class="form-check d-flex justify-content-center mb-4">
                                <input class="form-check-input me-2" type="checkbox" value="" id="form2Example33" checked />
                                <label class="form-check-label" for="form2Example33">
                                    Subscribe to our newsletter
                                </label>
                            </div>

                            <!-- Submit button -->
                            <button type="submit" name="update" class="btn btn-primary btn-block mb-4">
                                Update
                            </button>

                            <!-- Register buttons -->
                            <div class="text-center">
                                <p>or sign up with:</p>
                                <button type="button" class="btn btn-link btn-floating mx-1">
                                    <i class="fab fa-facebook-f"></i>
                                </button>

                                <button type="button" class="btn btn-link btn-floating mx-1">
                                    <i class="fab fa-google"></i>
                                </button>

                                <button type="button" class="btn btn-link btn-floating mx-1">
                                    <i class="fab fa-twitter"></i>
                                </button>

                                <button type="button" class="btn btn-link btn-floating mx-1">
                                    <i class="fab fa-github"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Section: Design Block -->



<?php require_once("../header/footer.php"); ?>