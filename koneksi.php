<?php
// koneksi ke database retail_db
$host = 'localhost';
$dbname = 'retail_db';
$username = 'root';
$password = ''; // default laragon kosong

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>