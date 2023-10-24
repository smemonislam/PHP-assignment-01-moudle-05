<?php require_once("../header/header.php"); ?>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    function validated_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    try {
        $_SESSION['loggedin'] = false;

        $email      = validated_input($_POST["email"]);
        $password   = validated_input($_POST["password"]);

        if (empty($email)) {
            throw new Exception("The email field is empty!");
        }

        if (empty($password)) {
            throw new Exception("The password field is empty!");
        }
        $filePath = "C:/laragon/www/PHP/File Operations/CRUD_OPERATION/database/db.txt";
        if (file_exists($filePath) && is_readable($filePath)) {
            $data = json_decode(file_get_contents($filePath), true) ?? [];

            foreach ($data as $item) {
                if ($email == $item['email'] && password_verify($password, $item['password'])) {
                    $_SESSION['loggedin'] = true;
                    $_SESSION['email'] = $email;
                    header("Location:" . BASE_URL);
                }
            }
            
            if (!$_SESSION['loggedin']) {
                throw new Exception("Email or Password does'nt match!");
            }
        }
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
    }
}

?>


<section class="vh-100" style="background-color: #eee;">
    <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center vh-100">
            <div class="col-md-9 col-lg-6 col-xl-5">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp" class="img-fluid" alt="Sample image">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                <?php if (isset($_SESSION['success'])) :  ?>
                    <div class="alert alert-success">
                        <?php
                        echo $_SESSION['success'];
                        session_destroy();
                        ?>
                    </div>
                <?php endif; ?>

                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                    <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                        <p class="lead fw-normal mb-0 me-3">Sign in with</p>
                        <button type="button" class="btn btn-primary btn-floating mx-1">
                            <i class="fab fa-facebook-f"></i>
                        </button>

                        <button type="button" class="btn btn-primary btn-floating mx-1">
                            <i class="fab fa-twitter"></i>
                        </button>

                        <button type="button" class="btn btn-primary btn-floating mx-1">
                            <i class="fab fa-linkedin-in"></i>
                        </button>
                    </div>

                    <div class="divider d-flex align-items-center my-4">
                        <p class="text-center fw-bold mx-3 mb-0">Or</p>
                    </div>
                    <?php if (isset($errorMessage)) :  ?>
                        <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
                    <?php endif; ?>
                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <input type="email" name="email" id="emailID" class="form-control form-control-lg" placeholder="Enter email" />
                        <label class="form-label" for="emailID">Email address</label>
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-3">
                        <input type="password" name="password" id="form3Example4" class="form-control form-control-lg" placeholder="Enter password" />
                        <label class="form-label" for="form3Example4">Password</label>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <!-- Checkbox -->
                        <div class="form-check mb-0">
                            <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
                            <label class="form-check-label" for="form2Example3">
                                Remember me
                            </label>
                        </div>
                        <a href="#!" class="text-body">Forgot password?</a>
                    </div>

                    <div class="text-center text-lg-start mt-4 pt-2">
                        <button type="submit" name="login" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                        <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="#!" class="link-danger">Register</a></p>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <div class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
        <!-- Copyright -->
        <div class="text-white mb-3 mb-md-0">
            Copyright © 2020. All rights reserved.
        </div>
        <!-- Copyright -->
    </div>
</section>
<?php require_once("../header/footer.php"); ?>