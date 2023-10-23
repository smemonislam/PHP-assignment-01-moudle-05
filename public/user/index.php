<?php
$filePath = "C:/laragon/www/PHP/File Operations/CRUD_OPERATION/database/db.txt";
if (file_exists($filePath) && is_readable($filePath)) {
    $allStudents = json_decode(file_get_contents($filePath), true);
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Age</th>
                            <th scope="col">Class</th>
                            <th scope="col">Roll</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allStudents as $student) { ?>
                            <tr>
                                <td><?php echo $student['id']; ?></td>
                                <td><?php echo $student['fname']; ?></td>
                                <td><?php echo $student['lname']; ?></td>
                                <td><?php echo $student['age']; ?></td>
                                <td><?php echo $student['class']; ?></td>
                                <td><?php echo $student['roll']; ?></td>
                                <td>
                                    <a href="create.php" class="btn btn-info btn-sm">Create</a>
                                    <a href="#" class="btn btn-success btn-sm">Edit</a>
                                    <a href="delete.php?id=<?php echo $student['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>