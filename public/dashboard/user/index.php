<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/public/dashboard/header/header.php";
require_once $_SERVER['DOCUMENT_ROOT'] . '/public/functions.php';

if (!isset($_SESSION['email'])) {
    header('Location:' . BASE_URL . "/login/index.php");
}

// Check if the user is an admin
if (!isAdmin()) {
    header('Location: ' . BASE_URL . "/index.php");
    exit;
}

$allRegistrations = readDatabaseFile(DB_FILE_PATH);
usort($allRegistrations, function ($a, $b) {
    return $a['id'] - $b['id'];
});


?>

<!--Main layout-->
<main style="margin-top: 58px">
    <div class="container pt-4">

        <!--Section: Sales Performance KPIs-->
        <section class="mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-end py-3">
                    <a href="<?= BASE_URL ?>/dashboard/user/create.php" class="btn btn-info mx-2">Add New User</a>
                    <a href="<?= BASE_URL ?>/dashboard/index.php" class="btn btn-primary">Back</a>
                </div>
                <div class="card-body">
                    <?php if (isset($_GET['success'])) :  ?>
                        <div class="alert alert-success">
                            <?php
                            echo $_GET['success'];
                            ?>
                        </div>
                    <?php endif; ?>
                    <table class="table align-middle mb-0 bg-white">
                        <thead class="bg-light">
                            <tr>
                                <th scope="col">#SL</th>
                                <th scope="col">ID</th>
                                <th scope="col">User Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($allRegistrations)) : ?>
                                <?php $i = 0; ?>
                                <?php foreach ($allRegistrations as $data) : ?>
                                    <tr>
                                        <td><?php echo ++$i; ?></td>
                                        <td><?php echo $data['id']; ?></td>
                                        <td><?php echo $data['username'] ?? ''; ?></td>
                                        <td><?php echo $data['email'] ?? ''; ?></td>
                                        <td><?php echo $data['role'] ?? ''; ?></td>
                                        <td>
                                            <a href="<?= BASE_URL ?>/dashboard/user/view.php?id=<?= $data['id'] ?>" class="btn btn-success btn-sm">View</a>

                                            <a href="<?= BASE_URL ?>/dashboard/user/edit.php?id=<?= $data['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                                            <a href="<?= BASE_URL ?>/dashboard/user/delete.php?id=<?= $data['id'] ?>" class="btn btn-danger btn-sm">Delete</a>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <!--Section: Sales Performance KPIs-->
    </div>
</main>
<!--Main layout-->
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/public/dashboard/header/footer.php"; ?>