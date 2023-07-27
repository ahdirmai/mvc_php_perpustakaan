<!-- app/Views/Books/print.php -->
<h1>Books Data</h1>
<table>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Author</th>
        <th>Publisher</th>
        <th>Genre</th>
        <th>Description</th>
    </tr>
    <?php foreach ($books as $book) : ?>
        <tr>
            <td><?php echo $book['id']; ?></td>
            <td><?php echo $book['title']; ?></td>
            <td><?php echo $book['author']; ?></td>
            <td><?php echo $book['publisher']; ?></td>
            <td><?php echo $book['genre']; ?></td>
            <td><?php echo $book['description']; ?></td>
        </tr>
    <?php endforeach; ?>
</table>