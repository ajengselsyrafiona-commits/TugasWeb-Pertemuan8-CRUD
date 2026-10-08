<?php
require '../koneksi.php';

// JOIN transaksi dengan pelanggan
$stmt = $pdo->prepare("
    SELECT t.id_transaksi, t.tanggal_transaksi, 
           p.nama_pelanggan, t.total_bayar
    FROM transaksi t
    LEFT JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
    ORDER BY t.tanggal_transaksi DESC
");
$stmt->execute();
$transaksi = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Transaksi - Sistem Retail</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #2196F3; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        a { color: #2196F3; text-decoration: none; margin-right: 10px; }
        a:hover { text-decoration: underline; }
        .btn-tambah { 
            background-color: #2196F3; 
            color: white; 
            padding: 10px 15px; 
            text-decoration: none; 
            border-radius: 4px;
        }
        .btn-tambah:hover { background-color: #1976D2; }
    </style>
</head>
<body>
<h2> Data Transaksi</h2>
<a href="tambah.php" class="btn-tambah">+ Transaksi Baru</a>

<table>
    <tr>
        <th>ID</th>
        <th>Tanggal</th>
        <th>Pelanggan</th>
        <th>Total Bayar</th>
        <th>Aksi</th>
    </tr>
    <?php foreach ($transaksi as $t): ?>
    <tr>
        <td><?= htmlspecialchars($t['id_transaksi']) ?></td>
        <td><?= htmlspecialchars($t['tanggal_transaksi']) ?></td>
        <td><?= htmlspecialchars($t['nama_pelanggan'] ?? 'Umum') ?></td>
        <td>Rp <?= number_format($t['total_bayar'], 0, ',', '.') ?></td>
        <td>
            <a href="detail.php?id=<?= $t['id_transaksi'] ?>">👁️ Detail</a>
            <a href="hapus.php?id=<?= $t['id_transaksi'] ?>" 
               onclick="return confirm('Yakin mau hapus transaksi ini?')">🗑️ Hapus</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>