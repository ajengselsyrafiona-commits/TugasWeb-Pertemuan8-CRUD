<?php
require '../koneksi.php';

// Hapus transaksi (detail_transaksi ikut terhapus karena ON DELETE CASCADE)
$stmt = $pdo->prepare("DELETE FROM transaksi WHERE id_transaksi = ?");
$stmt->execute([$_GET['id']]);

header("Location: index.php");
exit;
?>