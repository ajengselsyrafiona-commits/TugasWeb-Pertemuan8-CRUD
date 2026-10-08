<?php
require '../koneksi.php';

if ($_POST['aksi'] === 'tambah') {
    // ✅ PREPARED STATEMENT - Anti SQL Injection
    $stmt = $pdo->prepare("
        INSERT INTO produk (nama_produk, harga, stok, id_kategori) 
        VALUES (?, ?, ?, ?)
    ");
    $stmt->execute([
        $_POST['nama_produk'],
        $_POST['harga'],
        $_POST['stok'],
        $_POST['id_kategori']
    ]);
    header("Location: index.php");
    exit;
}

if ($_POST['aksi'] === 'edit') {
    $stmt = $pdo->prepare("
        UPDATE produk 
        SET nama_produk=?, harga=?, stok=?, id_kategori=? 
        WHERE id_produk=?
    ");
    $stmt->execute([
        $_POST['nama_produk'],
        $_POST['harga'],
        $_POST['stok'],
        $_POST['id_kategori'],
        $_POST['id_produk']
    ]);
    header("Location: index.php");
    exit;
}
?>