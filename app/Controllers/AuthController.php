<?php
// controller/AuthController.php
require_once './app/Models/Auth.php';

class AuthController
{
    private $conn;
    private $auth;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->auth = new Auth($conn); // Inisialisasi objek Auth
    }

    public function login()
    {
        // echo $this->conn;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Proses login pengguna di sini (validasi dan autentikasi)
            $username = $_POST['username'];
            $password = $_POST['password'];

            // echo $password;
            // Panggil metode login() dari kelas Auth
            if ($this->auth->login($username, $password)) {
                header('Location: index.php?action=dashboard');
            } else {
                // Tambahkan pesan kesalahan jika login gagal

                echo $error = 'Invalid credentials';
                require './app/Views/Auth/login.php';
            }
        } else {
            require './app/Views/Auth/login.php';
        }
    }

    public function logout()
    {
        $this->auth->logout(); // Panggil metode logout() dari kelas Auth
    }

    public function dashboard()
    {
        $_SESSION['page'] = "dashboard";

        require './app/Views/Dashboard/index.php';
    }
}
