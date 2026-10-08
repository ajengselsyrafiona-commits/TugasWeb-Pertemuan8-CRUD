<?php
require '../koneksi.php';

// Ambil semua pelanggan untuk dropdown
$pelanggan = $pdo->query("SELECT * FROM pelanggan ORDER BY nama_pelanggan")->fetchAll();

// Ambil semua produk yang stoknya > 0
$produk = $pdo->query("SELECT * FROM produk WHERE stok > 0 ORDER BY nama_produk")->fetchAll();

// Proses form saat disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pelanggan = $_POST['id_pelanggan'] ?: null;
    $items = $_POST['items']; // array [id_produk => jumlah]
    
    $total = 0;
    
    // Mulai transaksi database
    $pdo->beginTransaction();
    try {
        // Insert ke tabel transaksi (total diisi 0 dulu)
        $stmt = $pdo->prepare("INSERT INTO transaksi (id_pelanggan, total_bayar) VALUES (?, ?)");
        $stmt->execute([$id_pelanggan, 0]);
        $id_transaksi = $pdo->lastInsertId();
        
        // Prepare statement untuk detail & update stok
        $stmtDetail = $pdo->prepare("
            INSERT INTO detail_transaksi (id_transaksi, id_produk, jumlah, subtotal) 
            VALUES (?, ?, ?, ?)
        ");
        $stmtStok = $pdo->prepare("UPDATE produk SET stok = stok - ? WHERE id_produk = ?");
        
        // Loop setiap produk yang dipilih
        foreach ($items as $id_produk => $jumlah) {
            if ($jumlah > 0) {
                // Ambil harga produk
                $p = $pdo->prepare("SELECT harga FROM produk WHERE id_produk = ?");
                $p->execute([$id_produk]);
                $harga = $p->fetchColumn();
                
                $subtotal = $harga * $jumlah;
                $total += $subtotal;
                
                // Insert detail transaksi
                $stmtDetail->execute([$id_transaksi, $id_produk, $jumlah, $subtotal]);
                
                // Kurangi stok produk
                $stmtStok->execute([$jumlah, $id_produk]);
            }
        }
        
        // Update total bayar di tabel transaksi
        $pdo->prepare("UPDATE transaksi SET total_bayar = ? WHERE id_transaksi = ?")
            ->execute([$total, $id_transaksi]);
        
        $pdo->commit();
        
        // Redirect ke halaman detail
        header("Location: detail.php?id=$id_transaksi");
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        die("Error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Transaksi Baru - Sistem Retail</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-container { 
            max-width: 600px; 
            background: #f9f9f9; 
            padding: 20px; 
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        label { display: block; margin-top: 15px; font-weight: bold; }
        select, input { 
            padding: 8px; 
            border: 1px solid #ccc; 
            border-radius: 4px;
        }
        select { width: 100%; }
        .produk-item { 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            padding: 10px;
            margin: 5px 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .produk-info { flex: 1; }
        .produk-input { width: 80px; text-align: center; }
        button { 
            background-color: #4CAF50; 
            color: white; 
            padding: 12px 25px; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer; 
            margin-top: 20px;
            font-size: 16px;
        }
        button:hover { background-color: #45a049; }
        a { color: #2196F3; text-decoration: none; margin-left: 10px; }
        h3 { border-bottom: 2px solid #4CAF50; padding-bottom: 10px; }
    </style>
</head>
<body>
<h2>🛒 Transaksi Baru</h2>

<div class="form-container">
<form method="POST">
    <label>Pelanggan (opsional):</label>
    <select name="id_pelanggan">
        <option value="">-- Pelanggan Umum (Walk-in) --</option>
        <?php foreach ($pelanggan as $p): ?>
        <option value="<?= $p['id_pelanggan'] ?>">
            <?= htmlspecialchars($p['nama_pelanggan']) ?>
        </option>
        <?php endforeach; ?>
    </select>
    
    <h3>Pilih Produk & Jumlah:</h3>
    <?php foreach ($produk as $pr): ?>
    <div class="produk-item">
        <div class="produk-info">
            <strong><?= htmlspecialchars($pr['nama_produk']) ?></strong><br>
            <small>Rp <?= number_format($pr['harga'], 0, ',', '.') ?> | Stok: <?= $pr['stok'] ?></small>
        </div>
        <input type="number" 
               name="items[<?= $pr['id_produk'] ?>]" 
               min="0" 
               max="<?= $pr['stok'] ?>" 
               value="0" 
               class="produk-input">
    </div>
    <?php endforeach; ?>
    
    <button type="submit">💾 Proses Transaksi</button>
    <a href="index.php">← Batal</a>
</form>
</div>
</body>
</html>