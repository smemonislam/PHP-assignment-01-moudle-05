<?php require_once("../header/header.php"); ?>

<?php

if (!isset($_SESSION['email']) && !isset($_SESSION['loggedin'])) {
    header('Location:' . BASE_URL);
}

$filePath = "C:/laragon/www/PHP/File Operations/CRUD_OPERATION/database/db.txt";

$id = $_GET["id"];
if (file_exists($filePath) && is_readable($filePath)) {
    $data = json_decode(file_get_contents($filePath), true) ?? [];
    foreach ($data as $key => $item) {
        if ($item["id"] == $id) {
            $value = $item;
            break;
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["update"])) {
    try {
        function validated_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

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

            foreach ($data as $key => $item) {
                if ($item["id"] == $id) {
                    unset($data[$key]);
                    $registerData = [
                        'id'        => $id,
                        'username'  => $username,
                        'email'     => $email,
                        'password'  => password_hash($password, PASSWORD_DEFAULT),
                    ];
                    break;
                }
            }

            array_push($data, $registerData);
            file_put_contents($filePath, json_encode($data), LOCK_EX);
            header("location:" . BASE_URL . "/dashboard/index.php?success=Update Successfully.");
        }
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
    }
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
                                <input type="text" name="username" id="userName" class="form-control" value="<?php echo $value['username']; ?>" />
                                <label class="form-label" for="userName">Your Userame</label>
                            </div>
                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <input type="email" name="email" id="email3c" class="form-control" value="<?php echo $value['email']; ?>" />
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