<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Nama Produk</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Kategori</th>
        <th>Aksi</th>
    </tr>
    <?php foreach ($produk as $p): ?>
    <tr>
        <td><?= $p['id_produk'] ?></td>
        <td><?= $p['nama_produk'] ?></td>
        <td>Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
        <td><?= $p['stok'] ?></td>
        <td><?= $p['nama_kategori'] ?? '-' ?></td>
        <td>
            <a href="edit.php?id=<?= $p['id_produk'] ?>">Edit</a> |
            <a href="hapus.php?id=<?= $p['id_produk'] ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>