<?php
$username = $email = $password = "";
$usernameErr = $emailErr = $passwordErr = "";

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $username   = test_input($_POST['username']);
    $email      = test_input($_POST['email']);
    $password   = test_input($_POST['password']);

    if (empty($username)) {
        $usernameErr = "The user field is empty!";
    }

    if (empty($email)) {
        $emailErr = "The email field is empty!";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid Email!";
    }

    if (empty($password)) {
        $passwordErr = "The password field is empty!";
    }


    $filePath = "C:/laragon/www/PHP/File Operations/CRUD_OPERATION/database/db.txt";
    if (!empty($username) && !empty($email) && !empty($password)) {
        if (file_exists($filePath) && is_writable($filePath)) {

            $data = json_decode(file_get_contents($filePath), true) ?? [];
            $id = intval($data) + 1;

            foreach ($data as $key => $item) {
                if ($item['email'] == $email) {
                    $emailErr = "Email already exits!";
                    break;
                }
            }

            $registerData = [
                'id'        => $id,
                'username'  => $username,
                'email'     => $email,
                'password'  => password_hash($password, PASSWORD_DEFAULT),
            ];

            array_push($data, $registerData);
            file_put_contents($filePath, json_encode($data));
            //header("location: index.php");
        }
    }
}



?>

<?php require_once("../header/header.php"); ?>

<div class="container">
    <div class="row">
        <div class="col-8 offset-2">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="mt-5">
                <div class="row mb-3">
                    <label for="userName" class="col-sm-2 col-form-label">User Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="username" class="form-control" id="userName">
                        <span class="text-danger"><?php echo $usernameErr; ?></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" class="form-control" id="inputEmail3">
                        <span class="text-danger"><?php echo $emailErr; ?></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" name="password" class="form-control" id="inputPassword3">
                        <span class="text-danger"><?php echo $passwordErr; ?></span>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" name="reigster">Registration</button>
            </form>
        </div>
    </div>
</div>

<?php require_once("../header/footer.php"); ?>