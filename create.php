<?php
$fname = $lname = $age = $class = $roll = "";
$fnameErr = $lnameErr = $ageErr = $classErr = $rollErr = "";

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (empty($_POST["fname"])) {
        $fnameErr = "First name is required";
    } else {
        $fname  = test_input($_POST["fname"]);
    }

    if (empty($_POST["lname"])) {
        $lnameErr = "Last name is required";
    } else {
        $lname  = test_input($_POST["lname"]);
    }

    if (empty($_POST["age"])) {
        $ageErr = "Age is required";
    } else {
        $age    = test_input($_POST["age"]);
    }

    if (empty($_POST["class"])) {
        $classErr = "Class is required";
    } else {
        $class  = test_input($_POST["class"]);
    }

    if (empty($_POST["roll"])) {
        $rollErr = "Roll is required";
    } else {
        $roll   = test_input($_POST["roll"]);
    }


    $filePath = "C:/laragon/www/PHP/File Operations/CRUD_OPERATION/database/db.txt";
    if (!empty($fname) && !empty($lname) && !empty($age) && !empty($class) && !empty($roll)) {
        if (file_exists($filePath) && is_writable($filePath)) {

            $data = json_decode(file_get_contents($filePath), true) ?? [];

            $id = 0;
            for ($i = 0; $i <= count($data); $i++) {
                $id++;
            }

            $student = [
                'id'    => $id,
                'fname' => $fname,
                'lname' => $lname,
                'age'   => $age,
                'class' => $class,
                'roll'  => $roll,
            ];

            array_push($data, $student);
            file_put_contents($filePath, json_encode($data));
            header("location: index.php");
        }
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD - Create</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-8">
                <form class="row g-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="col-md-6">
                        <label for="fName" class="form-label">First Name</label>
                        <input type="text" name="fname" class="form-control" id="fName">
                        <span class="text-danger"><?php echo $fnameErr; ?></span>
                    </div>
                    <div class="col-md-6">
                        <label for="lName" class="form-label">Last Name</label>
                        <input type="text" name="lname" class="form-control" id="lName">
                        <span class="text-danger"><?php echo $lnameErr; ?></span>
                    </div>
                    <div class="col-md-4">
                        <label for="age" class="form-label">Age</label>
                        <input type="number" name="age" class="form-control" id="age">
                        <span class="text-danger"><?php echo $ageErr; ?></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentClass" class="form-label">Class</label>
                        <input type="text" name="class" class="form-control" id="studentClass">
                        <span class="text-danger"><?php echo $classErr; ?></span>
                    </div>
                    <div class="col-md-4">
                        <label for="studentRoll" class="form-label">Roll</label>
                        <input type="text" name="roll" class="form-control" id="studentRoll">
                        <span class="text-danger"><?php echo $rollErr; ?></span>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>