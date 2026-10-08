<?php
require '../koneksi.php';

// ✅ PREPARED STATEMENT untuk DELETE
$stmt = $pdo->prepare("DELETE FROM produk WHERE id_produk = ?");
$stmt->execute([$_GET['id']]);

header("Location: index.php");
exit;
?>