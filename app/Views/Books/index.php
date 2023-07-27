<?php $title = 'Data Books';
include './app/Views/Templates/header.php' ?>

<div class="container mt-4">
    <h1 class="display-4">Book List</h1>
    <?php if ($_SESSION['role'] == 'admin') {
    ?>
        <div class="text-end mb-2">
            <a class="btn btn-primary" href="index.php?action=createBooks">Tambah Buku</a>
            <a class="btn btn-secondary" href="index.php?action=exportBooksPDF" target="_blank">Export to PDF</a>
            <a class="btn btn-secondary" href="index.php?action=exportBooksExcel" target="_blank">Export to Excel</a>
            <a class="btn btn-secondary" href="index.php?action=printBooks" target="_blank">Print</a>
        </div>
    <?php
    } ?>
    <table class="table table-bordered table-striped">
        <thead class="text-center">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Publisher</th>
                <th>Genre</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php foreach ($books as $book) : ?>
                <tr>
                    <td><?= $book['id']; ?></td>
                    <td><?= $book['title']; ?></td>
                    <td><?= $book['author']; ?></td>
                    <td><?= $book['publisher']; ?></td>
                    <td><?= $book['genre']; ?></td>
                    <td class="text-center">
                        <a href="index.php?action=showBooks&id=<?= $book['id']; ?>" class="btn btn-primary btn-sm"> <i class="fas fa-eye"></i>View</a>

                        <?php if ($_SESSION['role'] == 'admin') { ?>
                            <a href="index.php?action=editBooks&id=<?= $book['id']; ?>" class="btn btn-info btn-sm"> <i class="fas fa-edit"></i>Edit</a>
                            <a href="index.php?action=deleteBooks&id=<?php echo $book['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this Book?')">
                                <i class="fas fa-trash"></i> Delete
                            </a>
                        <?php } else {
                        ?>
                            <?php $status_peminjaman = null;
                            foreach ($books_borrow as $borrow) {
                                if (($borrow['user_id'] == $_SESSION['user_id']) && ($borrow['book_id'] == $book['id'])) {
                                    $status_peminjaman = $borrow['status'];
                                    break;
                                } ?>
                            <?php
                            } ?>
                            <?php
                            if ($status_peminjaman == 'p') {
                            ?>
                                <button disabled class=" btn btn-warning btn-sm">Peminjaman sedang di proses</button>
                            <?php } else { ?>
                                <a href="index.php?action=borrowBooks&book_id=<?= $book['id']; ?>&user_id=<?= $_SESSION['user_id'] ?>" class="btn btn-success btn-sm"> </i>Pinjam</a>
                        <?php
                            }
                        } ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include './app/Views/Templates/footer.php' ?>