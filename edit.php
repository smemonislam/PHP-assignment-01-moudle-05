<?php
$fname = $lname = $age = $class = $roll = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $fname  = $_POST["fname"];
    $lname  = $_POST["lname"];
    $age    = $_POST["age"];
    $class  = $_POST["class"];
    $roll   = $_POST["roll"];

    $filePath = "C:/laragon/www/PHP/File Operations/CRUD/database/db.txt";
    if (file_exists($filePath) && is_writable($filePath)) {

        $data = file_get_contents($filePath);
        $allStudents = json_decode($data, true);

        foreach ($allStudents as $key => $item) {
            if ($item["roll"] == $_GET['roll']) {
                unset($allStudents[$key]);
                $student = [
                    "id"    => $id,
                    "fname" => $fname,
                    "lname" => $lname,
                    "age"   => $age,
                    "class" => $class,
                    "roll"  => $roll
                ];
                break;
            }
        }
        array_push($allStudents, $student);
        $studentData = json_encode($allStudents);
        file_put_contents($filePath, $studentData, LOCK_EX);
        header("Location: index.php");
    }
}

if (isset($_GET['roll'])) {
    $filePath = "C:/laragon/www/PHP/File Operations/CRUD/database/db.txt";
    if (file_exists($filePath) && is_writable($filePath)) {
        $data = file_get_contents($filePath);
        $allStudents = json_decode($data, true);
        foreach ($allStudents as $key => $item) {
            if ($item["roll"] == $_GET['roll']) {
                $newValues = $item;
            }
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
                <form class="row g-3" action="edit.php?roll=<?php echo $_GET['roll'] ?>" method="POST">
                    <div class="col-md-6">
                        <label for="fName" class="form-label">First Name</label>
                        <input type="text" name="fname" class="form-control" id="fName" value="<?php echo $newValues['fname']; ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="lName" class="form-label">Last Name</label>
                        <input type="text" name="lname" class="form-control" id="lName" value="<?php echo $newValues['lname']; ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="age" class="form-label">Age</label>
                        <input type="number" name="age" class="form-control" id="age" value="<?php echo $newValues['age']; ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="studentClass" class="form-label">Class</label>
                        <input type="text" name="class" class="form-control" id="studentClass" value="<?php echo $newValues['class']; ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="studentRoll" class="form-label">Roll</label>
                        <input type="text" name="roll" class="form-control" id="studentRoll" value="<?php echo $newValues['roll']; ?>" required>
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