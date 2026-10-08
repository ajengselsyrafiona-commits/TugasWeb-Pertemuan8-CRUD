<?php
require '../koneksi.php';

// ambil data produk
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM produk WHERE id_produk = ?");
$stmt->execute([$id]);
$produk = $stmt->fetch();

if (!$produk) {
    header("Location: index.php");
    exit;
}

// ambil kategori
$kategoris = $pdo->query("SELECT * FROM kategori ORDER BY nama_kategori")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Produk - Sistem Retail</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-container { 
            max-width: 500px; 
            background: #f9f9f9; 
            padding: 20px; 
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        label { display: block; margin-top: 15px; font-weight: bold; }
        input, select { 
            width: 100%; 
            padding: 8px; 
            margin-top: 5px; 
            border: 1px solid #ccc; 
            border-radius: 4px;
            box-sizing: border-box;
        }
        button { 
            background-color: #2196F3; 
            color: white; 
            padding: 10px 20px; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer; 
            margin-top: 20px;
        }
        button:hover { background-color: #1976D2; }
        a { color: #2196F3; text-decoration: none; margin-left: 10px; }
    </style>
</head>
<body>
<h2>✏️ Edit Produk</h2>

<div class="form-container">
<form action="proses.php" method="POST">
    <input type="hidden" name="aksi" value="edit">
    <input type="hidden" name="id_produk" value="<?= $produk['id_produk'] ?>">
    
    <label>Nama Produk:</label>
    <input type="text" name="nama_produk" 
           value="<?= htmlspecialchars($produk['nama_produk']) ?>" required>
    
    <label>Harga (Rp):</label>
    <input type="number" name="harga" 
           value="<?= $produk['harga'] ?>" min="0" required>
    
    <label>Stok:</label>
    <input type="number" name="stok" 
           value="<?= $produk['stok'] ?>" min="0" required>
    
    <label>Kategori:</label>
    <select name="id_kategori" required>
        <option value="">-- Pilih Kategori --</option>
        <?php foreach ($kategoris as $k): ?>
        <option value="<?= $k['id_kategori'] ?>"
            <?= $k['id_kategori'] == $produk['id_kategori'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($k['nama_kategori']) ?>
        </option>
        <?php endforeach; ?>
    </select>
    
    <button type="submit">💾 Update Produk</button>
    <a href="index.php">← Batal</a>
</form>
</div>
</body>
</html>