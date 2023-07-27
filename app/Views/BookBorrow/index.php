<?php $title = 'Data Books Borrow';
include './app/Views/Templates/header.php' ?>

<div class="container mt-4">
    <h1 class="display-4">Data Peminjaman Buku</h1>
    <!-- <div class="text-end mb-2">
        <a class="btn btn-secondary" href="index.php?action=exportBooksBorrowPDF" target="_blank">Export to PDF</a>
        <a class="btn btn-secondary" href="index.php?action=exportBooksBorrowExcel" target="_blank">Export to Excel</a>
        <a class="btn btn-secondary" href="index.php?action=printBooksBorrow" target="_blank">Print</a>
    </div> -->
    <table class="table table-bordered table-striped">
        <thead class="text-center">
            <tr>
                <th>ID</th>
                <th>Nama Peminjam</th>
                <th>Judul Buku</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php foreach ($books_borrow as $data) : ?>
                <tr>
                    <td><?= $data['id']; ?></td>
                    <td><?= $data['name']; ?></td>
                    <td><?= $data['title']; ?></td>
                    <td>
                        <?php $status = null;
                        if ($data['status'] == 'p') {
                            $status = "Pending";
                        } elseif ($data['status'] == 'a') {
                            $status = "Accept";
                        } elseif ($data['status'] == 'd') {
                            $status = "Deciline";
                        } ?>

                        <?= $status; ?></td>
                    <td>
                        <?php if ($status == "Pending") {
                        ?>
                            <a href="index.php?action=updateBorrow&id=<?php echo $data['id']; ?>&status=a" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to Accept this borrow?')">
                                <i class="fas fa-check"></i> Accept
                            </a>
                            <a href="index.php?action=updateBorrow&id=<?php echo $data['id']; ?>&status=d" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to Deciline this borrow?')">
                                <i class="fas fa-xmark"></i> Deciline
                            </a>
                            <?php } else {
                            if ($status == "Accept") { ?>

                                <button disabled class=" btn btn-success btn-sm">Sedang Dipinjam</button>
                            <?php } else { ?>
                                <button disabled class=" btn btn-danger btn-sm">Peminjaman Ditolak</button>
                            <?php } ?>


                        <?php
                        } ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include './app/Views/Templates/footer.php' ?>