<?php $title = 'Show Books';
include './app/Views/Templates/header.php' ?>

<div class="container mt-4">
    <divm class="mb-2">
        <a class="btn btn-primary" href="index.php?action=books"> Back</a>
    </divm>

    <div class="card">
        <div class="row g-0">
            <div class="col-md-4 mx-auto my-auto">
                <img src="./public/img/books/<?= $book['cover_image']; ?>" class="img-fluid" alt="<?= $book['title']; ?>">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h1 class="card-title"><?= $book['title']; ?></h1>
                    <p class="card-text"><strong>Author:</strong> <?= $book['author']; ?></p>
                    <p class="card-text"><strong>Publisher:</strong> <?= $book['publisher']; ?></p>
                    <p class="card-text"><strong>Genre:</strong> <?= $book['genre']; ?></p>
                    <p class="card-text"><strong>Description:</strong> <?= $book['description']; ?></p>
                    <?php if ($_SESSION['role'] == 'admin') {
                    ?>
                        <a href="index.php?action=editBooks&id=<?= $book['id']; ?>" class="btn btn-primary">Edit</a>
                    <?php
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './app/Views/Templates/footer.php' ?>