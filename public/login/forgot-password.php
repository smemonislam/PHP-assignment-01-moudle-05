<?php

require_once("../header/header.php");
require_once("../functions.php");

// Check if the user is already logged in, redirect if necessary
if (isset($_SESSION['loggedin'])) {
    header('Location:' . BASE_URL);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["reset"])) {
    try {

        $email = validatedInput($_POST["email"]);

        if (empty($email)) {
            throw new Exception("All fields are required.");
        }

        validateEmail($email);

        $data = readDatabaseFile(DB_FILE_PATH);
        $data = findDataByEmail($data, $email);
        if ($data) {
            $_SESSION['email'] = $data['email'];
            header("location:" . BASE_URL . "/login/change-password.php?id=" . $data["id"]);
        } else {
            throw new Exception("Email not found!.");
        }
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
    }
}


?>
<section class="reset mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card text-center" style="width: 300px;">
                    <div class="card-header h5 text-white bg-primary">Password Reset</div>
                    <div class="card-body px-5">
                        <p class="card-text py-2">
                            Enter your email address and we'll send you an email with instructions to reset your password.
                        </p>
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                            <?php if (isset($errorMessage)) :  ?>
                                <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
                            <?php endif; ?>
                            <div class="form-outline">
                                <input type="email" name="email" id="typeEmail" class="form-control my-3" />
                                <label class="form-label" for="typeEmail">Email input</label>
                            </div>
                            <button type="submit" name="reset" class="btn btn-primary w-100">Reset password</button>
                        </form>
                        <div class="d-flex justify-content-between mt-4">
                            <a class="" href="<?php echo BASE_URL; ?>/login/index.php">Login</a>
                            <a class="" href="<?php echo BASE_URL; ?>/registration/create.php">Register</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once("../header/footer.php"); ?>