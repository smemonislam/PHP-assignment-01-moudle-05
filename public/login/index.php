<?php
require_once("../header/header.php");
require_once("../config.php");

// Check if the user is already logged in, redirect if necessary
if (isset($_SESSION['email'])) {
    header('Location:' . BASE_URL);
    exit();
}

// Main code
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["login"])) {
    try {
        $email      = validatedInput($_POST["email"]);
        $password   = validatedInput($_POST["password"]);

        if (empty($email) || empty($password)) {
            throw new Exception("Both email and password are required fields.");
        }

        // Verify the email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email format.');
        }

        // Read the user data from the database file
        $data = readDatabaseFile(DB_FILE_PATH);

        // Check if the provided credentials match any user in the database
        foreach ($data as $item) {
            if ($email == $item['email'] && password_verify($password, $item['password'])) {
                $_SESSION['loggedin']   = true;
                $_SESSION['email']      = $email;
                $_SESSION['username']   = $item['username'];
                $_SESSION['user_id']    = $item['id'];
                $_SESSION['role']       = $item['role'];


                if ($_SESSION['role'] == 'admin') {
                    header("Location:" . BASE_URL . "/dashboard/index.php");
                } else if ($_SESSION['role'] == 'editor') {
                    header("Location:" . BASE_URL);
                } else {
                    header("Location:" . BASE_URL);
                }
                exit();
            }
        }

        // If no match was found, display an error message
        throw new Exception("Email or password is incorrect.");
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
    }
}

?>


<section class="h-100 gradient-form" style="background-color: #eee;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
                <div class="card rounded-3 text-black">
                    <div class="row g-0">
                        <div class="col-lg-6">
                            <div class="card-body p-md-5 mx-md-4">

                                <div class="text-center">
                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/lotus.webp" style="width: 185px;" alt="logo">
                                    <h4 class="mt-1 mb-5 pb-1">We are the Laravel Team</h4>
                                </div>
                                <?php if (isset($_SESSION['success'])) :  ?>
                                    <div class="alert alert-success">
                                        <?php echo $_SESSION['success']; ?>
                                    </div>
                                <?php endif; ?>
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                    <p>Please login to your account</p>
                                    <?php if (isset($errorMessage)) :  ?>
                                        <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
                                    <?php endif; ?>
                                    <div class="form-outline mb-4">
                                        <input type="email" id="form2Example11" name="email" class="form-control" placeholder="Email address" />
                                        <label class="form-label" for="form2Example11">Username</label>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <input type="password" name="password" id="form2Example22" class="form-control" />
                                        <label class="form-label" for="form2Example22">Password</label>
                                    </div>

                                    <div class="text-center pt-1 mb-5 pb-1">
                                        <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit" name="login">Log
                                            in</button>
                                        <a class="text-muted" href="#!">Forgot password?</a>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-center pb-4">
                                        <p class="mb-0 me-2">Don't have an account?</p>
                                        <a href="<?php echo BASE_URL; ?>/registration/create.php" class="btn btn-outline-danger">Create new</a>
                                    </div>

                                </form>

                            </div>
                        </div>
                        <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                            <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                <h4 class="mb-4">We are more than just a company</h4>
                                <p class="medium mb-0 text-justify">The Laravel Team is the driving force behind Laravel, a renowned PHP framework. Committed to development, security, and community engagement, they ensure Laravel's excellence and ongoing evolution.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<?php require_once("../header/footer.php"); ?>