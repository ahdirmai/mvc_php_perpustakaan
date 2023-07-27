<nav class="navbar navbar-expand-md navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.php?action=dashboard">
            <i class="fas fa-cogs me-2"></i> Dashboard
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($_SESSION['page'] == 'books') ? 'active' : ''; ?>" href="index.php?action=books">
                        <i class="fas fa-box me-2"></i> Books
                    </a>
                </li>
                <?php if ($_SESSION['role'] == 'admin') { ?>
                    <li class="nav-item">
                        <!-- str_contains('How are you', 'are') -->
                        <a class="nav-link <?php echo ($_SESSION['page'] == 'users') ? 'active' : ''; ?>" href="index.php?action=users">
                            <i class="fas fa-users me-2"></i> Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <!-- str_contains('How are you', 'are') -->
                        <a class="nav-link <?php echo ($_SESSION['page'] == 'book_borrow') ? 'active' : ''; ?>" href="index.php?action=booksborrow">
                            <i class="fas fa-users me-2"></i> Books Borrow
                        </a>
                    </li>
                <?php } ?>

            </ul>
        </div>
        <?php if (isset($_SESSION['username'])) : ?>
            <div class="text-end">
                <a class="btn btn-danger " href="index.php?action=logout">
                    Logout
                </a>
            </div>
        <?php endif; ?>
    </div>
</nav>