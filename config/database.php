<?php
// Konfigurasi koneksi database
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'digitalent_library';

// Membuat koneksi
$koneksi = mysqli_connect($host, $username, $password, $dbname);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
