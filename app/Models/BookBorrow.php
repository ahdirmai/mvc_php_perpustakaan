<?php
class BookBorrow
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllBooksBorrow()
    {
        $sql = "SELECT books_borrow.id,name,title,status FROM books_borrow JOIN books ON books_borrow.book_id = books.id JOIN users ON books_borrow.user_id = users.id";
        $result = $this->conn->query($sql);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    public function setStatusBorrow($data)
    {
        $stmt = $this->conn->prepare("UPDATE books_borrow SET status = ? WHERE id = ?");
        $stmt->bind_param('si', $data['status'], $data['id']);
        return $stmt->execute();
    }
}
