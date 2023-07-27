<?php
class User
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllUsers()
    {
        $sql = "SELECT * FROM users";
        $result = $this->conn->query($sql);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    public function getUserById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function addUser($data)
    {
        $stmt = $this->conn->prepare("INSERT INTO users (username, password,name,role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $data['username'], $data['password'], $data['name'], $data['role']);
        return $stmt->execute();
    }

    public function updateUser($id, $data)
    {
        $stmt = $this->conn->prepare("UPDATE users SET username = ?, name = ? , role = ? WHERE id = ?");
        $stmt->bind_param('sssi', $data['username'], $data['name'], $data['role'], $id);
        return $stmt->execute();
    }

    public function deleteUser($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}
