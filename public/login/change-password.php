<?php
require_once("../header/header.php");
require_once("../functions.php");

$data = readDatabaseFile(DB_FILE_PATH);
$id = $_GET["id"] ?? "";

// Check if the user is already logged in, redirect if necessary
if (isset($_SESSION['loggedin'])) {
    header('Location:' . BASE_URL);
    exit();
}

// Check if the user id is not a database in, redirect if necessary
$item = findDataById($data, $id);
if (!$item) {
    header("Location:" . BASE_URL . "/login/index.php");
    exit();
}

// Check if the user email is not a session in, redirect if necessary
if (empty($_SESSION['email'])) {
    header("Location:" . BASE_URL . "/login/index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["changePassword"])) {
    try {

        $oldPassword   = validatedInput($_POST["oldPassword"]);
        $confirmPass   = validatedInput($_POST["confirmPass"]);

        if (empty($oldPassword) || empty($confirmPass)) {
            throw new Exception("All fields are required.");
        }

        validatePassword($oldPassword);
        validatePassword($confirmPass);

        if ($oldPassword == $confirmPass) {

            foreach ($data as $key => &$item) {
                if ($item["id"] == $id) {
                    $item['password'] = password_hash($oldPassword, PASSWORD_DEFAULT);
                }
            }

            writeDatabaseFile(DB_FILE_PATH, $data);
            unset($_SESSION['email']);
            $_SESSION["success"] = 'Password changed successfully.';
            header("location:" . BASE_URL . "/login/index.php");

            exit();
        } else {
            throw new Exception("Password Doesn't Match!.");
        }
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
    }
}

?>

<!--Main layout-->
<main class="pt-0">
    <div class="container">
        <div class="jumbotron color-grey-light mt-70">
            <div class="d-flex align-items-center h-100">
                <div class="container text-center py-5">
                    <h3 class="mb-0">Change password</h3>
                </div>
            </div>
        </div>
        <!-- Grid row -->
        <div class="row d-flex justify-content-center">
            <!-- Grid column -->
            <div class="col-md-6">
                <!--Section: Block Content-->
                <section class="mb-5 text-center">
                    <p>Set a new password</p>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?php echo $id; ?>" method="POST">
                        <?php if (isset($errorMessage)) :  ?>
                            <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
                        <?php endif; ?>
                        <p>Password Generate: <span class="badge bg-success text-wrap text-white fs-3"><?php echo generatePassword(8); ?></span> </p>
                        <div class="form-outline">
                            <input type="password" name="oldPassword" id="newPass" class="form-control my-3" />
                            <label class="form-label" for="newPass">New password</label>
                        </div>
                        <div class="form-outline">
                            <input type="password" name="confirmPass" id="newPassConfirm" class="form-control my-3" />
                            <label class="form-label" for="newPassConfirm">New password</label>
                        </div>

                        <button type="submit" name="changePassword" class="btn btn-primary mb-4">Change password</button>

                    </form>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <u><a href="<?php echo BASE_URL; ?>/login/index.php">Back to Log In</a></u>
                        <u><a href=" <?php echo BASE_URL; ?>/registration/create.php">Register</a></u>
                    </div>
                </section>
                <!--Section: Block Content-->
            </div>
            <!-- Grid column -->
        </div>
        <!-- Grid row -->
    </div>
</main>
<!--Main layout-->
<?php
require_once("../header/footer.php");

?>