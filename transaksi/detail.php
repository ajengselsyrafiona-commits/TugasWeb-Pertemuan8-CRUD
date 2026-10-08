<?php
require '../koneksi.php';

// Ambil info transaksi + nama pelanggan (JOIN 2 tabel)
$stmt = $pdo->prepare("
    SELECT t.*, p.nama_pelanggan 
    FROM transaksi t
    LEFT JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
    WHERE t.id_transaksi = ?
");
$stmt->execute([$_GET['id']]);
$transaksi = $stmt->fetch();

// Kalau transaksi tidak ada, redirect
if (!$transaksi) {
    header("Location: index.php");
    exit;
}

// Ambil detail transaksi + nama produk + kategori (JOIN 3 tabel!)
$stmt = $pdo->prepare("
    SELECT dt.jumlah, dt.subtotal, 
           pr.nama_produk, pr.harga,
           kat.nama_kategori
    FROM detail_transaksi dt
    JOIN produk pr ON dt.id_produk = pr.id_produk
    LEFT JOIN kategori kat ON pr.id_kategori = kat.id_kategori
    WHERE dt.id_transaksi = ?
");
$stmt->execute([$_GET['id']]);
$details = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Detail Transaksi #<?= $transaksi['id_transaksi'] ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .info-box { 
            background: #f9f9f9; 
            padding: 15px; 
            border-radius: 8px; 
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .total-row { background-color: #e8f5e9 !important; font-weight: bold; }
        a { color: #2196F3; text-decoration: none; }
        .btn-back { 
            background-color: #2196F3; 
            color: white; 
            padding: 10px 15px; 
            text-decoration: none; 
            border-radius: 4px;
            display: inline-block;
            margin-top: 20px;
        }
        .btn-back:hover { background-color: #1976D2; }
        h2 { color: #333; }
    </style>
</head>
<body>
<h2>🧾 Detail Transaksi #<?= htmlspecialchars($transaksi['id_transaksi']) ?></h2>

<div class="info-box">
    <p><strong>Pelanggan:</strong> <?= htmlspecialchars($transaksi['nama_pelanggan'] ?? 'Umum (Walk-in)') ?></p>
    <p><strong>Tanggal:</strong> <?= htmlspecialchars($transaksi['tanggal_transaksi']) ?></p>
</div>

<table>
    <tr>
        <th>Produk</th>
        <th>Kategori</th>
        <th>Harga Satuan</th>
        <th>Jumlah</th>
        <th>Subtotal</th>
    </tr>
    <?php foreach ($details as $d): ?>
    <tr>
        <td><?= htmlspecialchars($d['nama_produk']) ?></td>
        <td><?= htmlspecialchars($d['nama_kategori'] ?? '-') ?></td>
        <td>Rp <?= number_format($d['harga'], 0, ',', '.') ?></td>
        <td><?= htmlspecialchars($d['jumlah']) ?></td>
        <td>Rp <?= number_format($d['subtotal'], 0, ',', '.') ?></td>
    </tr>
    <?php endforeach; ?>
    <tr class="total-row">
        <td colspan="4" style="text-align:right;">TOTAL BAYAR:</td>
        <td>Rp <?= number_format($transaksi['total_bayar'], 0, ',', '.') ?></td>
    </tr>
</table>

<a href="index.php" class="btn-back">← Kembali ke Daftar Transaksi</a>
</body>
</html>