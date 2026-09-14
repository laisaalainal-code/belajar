<?php
require_once 'config/database.php';

 
 $stmt = $pdo->query("SELECT * FROM produk ORDER BY created_at DESC");
 $produk_list = $stmt->fetchAll();


// Pesan dari redirect
$pesan = $_GET['pesan'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
    <h1>Manajemen Produk</h1>
    <a href="create.php">+ Tambah Produk</a>
</nav>

<div class="container">
    <?php if ($pesan === 'tambah'): ?>
        <div class="alert alert-success">Produk berhasil ditambahkan.</div>
    <?php elseif ($pesan === 'edit'): ?>
        <div class="alert alert-success">Produk berhasil diperbarui.</div>
    <?php elseif ($pesan === 'hapus'): ?>
        <div class="alert alert-success">Produk berhasil dihapus.</div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <h2>Daftar Produk</h2>
            <span style="font-size:13px;color:#888;">Total: <?= count($produk_list) ?> produk</span>
        </div>

        <?php if (empty($produk_list)): ?>
            <p style="text-align:center;color:#888;padding:30px 0;">Belum ada produk. <a href="create.php">Tambahkan sekarang</a>.</p>
        <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Deskripsi</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produk_list as $i => $p): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><strong><?= htmlspecialchars($p['nama']) ?></strong></td>
                    <td><span class="badge"><?= htmlspecialchars($p['kategori']) ?></span></td>
                    <td>Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
                    <td><?= $p['stok'] ?></td>
                    <td style="max-width:200px;color:#666;font-size:13px;">
                        <?= htmlspecialchars(mb_strimwidth($p['deskripsi'] ?? '', 0, 60, '...')) ?>
                    </td>
                    <td style="text-align:center;white-space:nowrap;">
                        <a href="edit.php?id=<?= $p['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <button
                            class="btn btn-danger btn-sm"
                            onclick="konfirmasiHapus(<?= $p['id'] ?>, '<?= htmlspecialchars(addslashes($p['nama'])) ?>')">
                            Hapus
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal-overlay" id="modalHapus">
    <div class="modal">
        <h3>Konfirmasi Hapus</h3>
        <p id="modalPesan">Apakah Anda yakin ingin menghapus produk ini?</p>
        <div class="modal-actions">
            <a id="btnHapusYa" href="#" class="btn btn-danger">Ya, Hapus</a>
            <button class="btn btn-secondary" onclick="tutupModal()">Batal</button>
        </div>
    </div>
</div>

<script>
function konfirmasiHapus(id, nama) {
    document.getElementById('modalPesan').textContent = 'Hapus produk "' + nama + '"?';
    document.getElementById('btnHapusYa').href = 'delete.php?id=' + id;
    document.getElementById('modalHapus').classList.add('active');
}

function tutupModal() {
    document.getElementById('modalHapus').classList.remove('active');
}

// Tutup modal klik di luar
document.getElementById('modalHapus').addEventListener('click', function(e) {
    if (e.target === this) tutupModal();
});
</script>

</body>
</html>