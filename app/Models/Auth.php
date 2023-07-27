<?php
// model/Auth.php

class Auth
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function login($username, $password)
    {
        global $koneksi;
        $stmt = $koneksi->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $user['role'];
                $_SESSION['user_id'] = $user['id'];
                return true;
            }
        }

        return false;
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: index.php?action=login');
    }

    public function getRole()
    {
        // session_start();
        return $_SESSION['role'] ?? 'user'; // default 'user' jika tidak ada session role
    }
}
