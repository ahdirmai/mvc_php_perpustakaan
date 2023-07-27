<?php $title = 'Create Users';
include './app/Views/Templates/header.php' ?>
<div class="container mt-4">
    <!-- Create User Form -->
    <h1 class="display-4 font-weight-bold mb-4">Create User</h1>
    <form action="index.php?action=createUsers" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username">
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Role</label>
            <select class="form-select" aria-label="Default select example" id="role" name="role">
                <!-- <option selected>Open this select menu</option> -->
                <option value="admin">Admin</option>
                <option value="user"> Users</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Create User</button>
    </form>
</div>

<!-- Tambahkan link ke JavaScript Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>