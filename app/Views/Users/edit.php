<?php $title = 'Edit Users';
include './app/Views/Templates/header.php' ?>
<!-- Main content -->
<div class="container mt-4">
    <!-- Edit User Form -->
    <h1 class="display-4 font-weight-bold mb-4">Edit User</h1>
    <form action="index.php?action=editUsers&id=<?php echo $user['id']; ?>" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $user['name']; ?>">
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username']; ?>">
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Role</label>
            <select class="form-select" aria-label="Default select example" id="role" name="role">
                <!-- <option selected>Open this select menu</option> -->
                <option value="admin" <?= $user['role'] === "admin" ? 'selected' : '' ?>>Admin</option>
                <option value="user" <?= $user['role'] === "user" ? 'selected' : '' ?>> Users</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<?php include './app/Views/Templates/footer.php' ?>