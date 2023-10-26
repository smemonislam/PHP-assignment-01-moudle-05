<?php
require_once("../header/header.php");
require_once("../config.php");

// Check if the user is already logged in, redirect if necessary
if (isset($_SESSION['email'])) {
    header('Location:' . BASE_URL);
    exit();
}

// Main code
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["register"])) {
    try {
        $username   = validatedInput($_POST['username']);
        $email      = validatedInput($_POST['email']);
        $password   = validatedInput($_POST['password']);

        if (empty($username) || empty($email) || empty($password)) {
            throw new Exception('All fields are required.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Email is invalid.');
        }

        // Read the existing data from the database file
        $data = readDatabaseFile(DB_FILE_PATH);

        // Check if the email already exists
        foreach ($data as $item) {
            if ($item['email'] === $email) {
                throw new Exception('Email Already Exists!');
            }
        }

        // Generate a unique ID by finding the maximum ID in the existing data
        $id = 1;
        foreach ($data as $item) {
            if ($item['id'] >= $id) {
                $id = $item['id'] + 1;
            }
        }

        // Create a new user and add it to the data array
        $newUser = [
            'id'        => $id,
            'username'  => $username,
            'email'     => $email,
            'role'      => 'user',
            'password'  => password_hash($password, PASSWORD_DEFAULT),
        ];

        $data[] = $newUser;

        // Write the updated data back to the database file
        writeDatabaseFile(DB_FILE_PATH, $data);

        // Set a success message in the session and redirect to the login page
        $_SESSION['success'] = 'Successfully registered.';
        header("location:" . BASE_URL . "/login/index.php");
        exit();
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
    }
}
?>
<!-- Section: Design Block -->
<section class="text-center text-lg-start">
    <!-- Jumbotron -->
    <div class="container py-4">
        <div class="row g-0 align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="card cascading-right" style="
            background: hsla(0, 0%, 100%, 0.55);
            backdrop-filter: blur(30px);
            ">
                    <div class="card-body p-5 shadow-5 text-center">
                        <h2 class="fw-bold mb-5">Sign up now</h2>
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                            <?php if (isset($errorMessage)) :  ?>
                                <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
                            <?php endif; ?>
                            <div class="form-outline mb-4">
                                <input type="text" name="username" id="form3Example1c" class="form-control" />
                                <label class="form-label" for="form3Example1c">Username</label>
                            </div>
                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <input type="email" name="email" id="form3Example3c" class="form-control" />
                                <label class="form-label" for="form3Example3c">Your Email</label>
                            </div>

                            <!-- Password input -->
                            <div class="form-outline mb-4">
                                <input type="password" name="password" id="form3Example4c" class="form-control" />
                                <label class="form-label" for="form3Example4c">Password</label>
                            </div>

                            <!-- Checkbox -->
                            <div class="form-check d-flex justify-content-center mb-4">
                                <input class="form-check-input me-2" type="checkbox" value="" id="form2Example33" checked />
                                <label class="form-check-label" for="form2Example33">
                                    Already have a account? <a href="<?php echo BASE_URL; ?>/login/index.php">Login</a>
                                </label>
                            </div>

                            <!-- Submit button -->
                            <button type="submit" name="register" class="btn btn-primary btn-block mb-4">
                                Register
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

            <div class="col-lg-6 mb-5 mb-lg-0">
                <img src="https://mdbootstrap.com/img/new/ecommerce/vertical/004.jpg" class="w-100 rounded-4 shadow-4" alt="" />
            </div>
        </div>
    </div>
    <!-- Jumbotron -->
</section>
<!-- Section: Design Block -->
<?php require_once("../header/footer.php"); ?>