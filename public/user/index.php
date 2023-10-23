<?php
$filePath = "C:/laragon/www/PHP/File Operations/CRUD_OPERATION/database/db.txt";
if (file_exists($filePath) && is_readable($filePath)) {
    $allRegistrations = json_decode(file_get_contents($filePath), true);
}
?>


<?php require_once("../header/header.php"); ?>
<div class="container">
    <div class="row">
        <div class="col-lg-12">

            <?php if (isset($_SESSION['success'])) :  ?>
                <div class="alert alert-success"><?php echo $_SESSION['success']; ?></div>
            <?php endif; ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">User Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    if (isset($allRegistrations)) :
                        foreach ($allRegistrations as $data) :
                    ?>
                            <tr>
                                <td><?php echo $data['id'] ?? ""; ?></td>
                                <td><?php echo $data['username'] ?? ""; ?></td>
                                <td><?php echo $data['email'] ?? ""; ?></td>
                                <td>
                                    <a href="#" class="btn btn-success btn-sm">Edit</a>
                                    <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once("../header/footer.php"); ?>