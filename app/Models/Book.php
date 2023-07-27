<?php
class Book
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllBooks()
    {
        $sql = "SELECT * FROM books";
        $result = $this->conn->query($sql);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    public function getBookById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM books WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function addBook($data)
    {
        $stmt = $this->conn->prepare("INSERT INTO books (title, author, publisher, genre, description, cover_image) 
                                     VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssss', $data['title'], $data['author'], $data['publisher'], $data['genre'], $data['description'], $data['cover_image']);
        return $stmt->execute();
    }

    public function updateBook($id, $data)
    {
        $stmt = $this->conn->prepare("UPDATE books SET 
                                      title = ?,
                                      author = ?,
                                      publisher = ?,
                                      genre = ?,
                                      description = ?,
                                      cover_image = ? 
                                      WHERE id = ?");
        $stmt->bind_param('ssssssi', $data['title'], $data['author'], $data['publisher'], $data['genre'], $data['description'], $data['cover_image'], $data['id']);
        return $stmt->execute();
    }

    public function deleteBook($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM books WHERE id = ?");
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    public function borrowBook($data)
    {
        $sql = "INSERT INTO books_borrow (user_id,book_id,status) value (" . $data['user_id'] . "," . $data['book_id'] . ",'p')";
        return $this->conn->query($sql);
    }

    public function getAllBooksBorrow()
    {
        $sql = "SELECT * FROM books_borrow JOIN books ON books_borrow.book_id = books.id JOIN users ON books_borrow.user_id = users.id WHERE status != 'd' AND status != 'a'";
        $result = $this->conn->query($sql);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }
}
