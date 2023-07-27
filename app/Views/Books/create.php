<?php $title = 'Create Books';
include './app/Views/Templates/header.php' ?>

<div class="container mt-4">
    <h1 class="display-4">Add New Book</h1>
    <form action="index.php?action=createBooks" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="author" class="form-label">Author</label>
            <input type="text" class="form-control" id="author" name="author" required>
        </div>
        <div class="mb-3">
            <label for="publisher" class="form-label">Publisher</label>
            <input type="text" class="form-control" id="publisher" name="publisher">
        </div>
        <div class="mb-3">
            <label for="genre" class="form-label">Genre</label>
            <input type="text" class="form-control" id="genre" name="genre">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="5"></textarea>
        </div>
        <div class="mb-3">
            <label for="cover_image" class="form-label">Cover Image</label>
            <input type="file" class="form-control" id="cover_image" name="cover_image" onchange="previewImage(event)">
        </div>

        <!-- Image Preview -->
        <div class="mb-3" id="imagePreviewContainer" style="display: none;">
            <label class="form-label">Cover Image Preview:</label><br>
            <img id="imagePreview" src="#" alt="Cover Image Preview" style="max-width: 300px;">
        </div>

        <button type="submit" class="btn btn-primary">Add Book</button>
    </form>
</div>

<script>
    // Function untuk menampilkan preview gambar
    function previewImage(event) {
        const coverImageInput = event.target;
        const imagePreviewContainer = document.getElementById('imagePreviewContainer');
        const imagePreview = document.getElementById('imagePreview');

        const file = coverImageInput.files[0];
        const reader = new FileReader();

        reader.onloadend = function() {
            imagePreview.src = reader.result;
            imagePreviewContainer.style.display = 'block';
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            imagePreview.src = "#";
            imagePreviewContainer.style.display = 'none';
        }
    }
</script>

<?php include './app/Views/Templates/footer.php' ?>