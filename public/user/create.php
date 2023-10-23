<?php

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["register"])) {
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    try {
        $username = test_input($_POST['username']);
        $email = test_input($_POST['email']);
        $password = test_input($_POST['password']);

        if (empty($username)) {
            throw new Exception('The username field is empty!');
        }

        if (empty($email)) {
            throw new Exception('The email field is empty!');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Email is Invalid!');
        }

        if (empty($password)) {
            throw new Exception('The password field is empty!');
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
            file_put_contents($filePath, json_encode($data));
            $_SESSION['success'] = "Successfully registered.";
            header("location: index.php");
        }
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
    }
}


?>

<?php require_once("../header/header.php"); ?>

<div class="container">
    <div class="row">
        <div class="col-8 offset-2">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="mt-5">
                <?php if (isset($errorMessage)) :  ?>
                    <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
                <?php endif; ?>
                <div class="row mb-3">
                    <label for="userName" class="col-sm-2 col-form-label">User Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="username" class="form-control" id="userName">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" class="form-control" id="inputEmail3">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" name="password" class="form-control" id="inputPassword3">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" name="register">Registration</button>
            </form>
        </div>
    </div>
</div>

<?php require_once("../header/footer.php"); ?>