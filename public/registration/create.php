<?php require_once("../header/header.php"); ?>

<?php
if (isset($_SESSION['email'])) {
    header('Location:' . BASE_URL);
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["register"])) {
    function validated_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    try {
        $username   = validated_input($_POST['username']);
        $email      = validated_input($_POST['email']);
        $password   = validated_input($_POST['password']);

        if (empty($username) || empty($email) || empty($password)) {
            throw new Exception('All fields are required.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Email is Invalid!');
        }


        $filePath = "C:/laragon/www/PHP/File Operations/CRUD_OPERATION/database/db.txt";

        if (file_exists($filePath) && is_writable($filePath)) {
            $data = json_decode(file_get_contents($filePath), true) ?? [];

            foreach ($data as $item) {
                if ($item['email'] == $email) {
                    throw new Exception('Email Already Exists!');
                }
            }

            // Generate a unique ID by finding the maximum ID in the existing data
            $maxId = 0;
            foreach ($data as $item) {
                if ($item['id'] > $maxId) {
                    $maxId = $item['id'];
                }
            }

            $id = $maxId + 1;


            $registerData = [
                'id' => $id,
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
            ];

            array_push($data, $registerData);
            file_put_contents($filePath, json_encode($data), LOCK_EX);
            $_SESSION['success'] = "Successfully registered.";
            header("location:" . BASE_URL . "/login/index.php");
        }
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
                                    Subscribe to our newsletter
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