<?php $title = 'Edit Books';
include './app/Views/Templates/header.php' ?>
<div class="container mt-4">
    <div>
        <a class="btn btn-primary" href="index.php?action=books"> Back</a>
    </div>
    <h1 class="display-4">Edit Book</h1>
    <form action="index.php?action=editBooks&id=<?= $book['id']; ?>" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= $book['title']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="author" class="form-label">Author</label>
            <input type="text" class="form-control" id="author" name="author" value="<?= $book['author']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="publisher" class="form-label">Publisher</label>
            <input type="text" class="form-control" id="publisher" name="publisher" value="<?= $book['publisher']; ?>">
        </div>
        <div class="mb-3">
            <label for="genre" class="form-label">Genre</label>
            <input type="text" class="form-control" id="genre" name="genre" value="<?= $book['genre']; ?>">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="5"><?= $book['description']; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="cover_image" class="form-label">Cover Image</label>
            <input type="file" class="form-control" id="cover_image" name="cover_image" onchange="previewImage(event)">
        </div>

        <!-- Image Preview jika ada gambar yang sudah diunggah sebelumnya -->
        <?php if (!empty($book['cover_image'])) : ?>
            <div class="mb-3">
                <label class="form-label">Cover Image Preview:</label><br>
                <img src="/public/img/books/<?= $book['cover_image']; ?>" alt="Cover Image Preview" style="max-width: 300px;" id="imagePreview">
            </div>
        <?php endif; ?>

        <button type="submit" class="btn btn-primary">Update Book</button>
    </form>
</div>

<script>
    // Function untuk menampilkan preview gambar
    function previewImage(event) {
        const coverImageInput = event.target;
        const imagePreview = document.getElementById('imagePreview');

        const file = coverImageInput.files[0];
        const reader = new FileReader();

        reader.onloadend = function() {
            imagePreview.src = reader.result;
        }

        if (file) {
            reader.readAsDataURL(file);
            imagePreview.style.display = 'block';
        } else {
            imagePreview.src = "";
            imagePreview.style.display = 'none';
        }
    }
</script>

<?php include './app/Views/Templates/footer.php' ?>