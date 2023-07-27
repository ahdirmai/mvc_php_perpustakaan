<?php $title = 'Data Users';
include './app/Views/Templates/header.php' ?>
<!-- Main content -->
<div class="container mt-4">
    <!-- Table Users Content -->
    <h1 class="display-4 font-weight-bold mb-4">User List</h1>
    <div class="text-end">
        <a class="btn btn-primary" href="index.php?action=createUsers">Tambah Users</a>
        <a class="btn btn-secondary" href="index.php?action=exportUsersPDF" target="_blank">Export to PDF</a>
        <a class="btn btn-secondary" href="index.php?action=exportUsersExcel" target="_blank">Export to Excel</a>
        <a class="btn btn-secondary" href="index.php?action=printUsers" target="_blank">Print</a>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Name</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['name']; ?></td>
                    <td><?php echo $user['role']; ?></td>
                    <td>
                        <?php if ($_SESSION['user_id'] == $user['id']) {
                        } else { ?>
                            <a href="index.php?action=editUsers&id=<?php echo $user['id']; ?>" class="btn btn-primary btn-sm me-2">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="index.php?action=deleteUsers&id=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">
                                <i class="fas fa-trash"></i> Delete
                            </a>
                        <?php } ?>

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>




</div>

<?php include './app/Views/Templates/footer.php' ?>