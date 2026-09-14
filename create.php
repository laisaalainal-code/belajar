<?php
require_once 'config/database.php';

$errors = [];
$input  = ['nama' => '', 'kategori' => '', 'harga' => '', 'stok' => '', 'deskripsi' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input['nama']      = trim($_POST['nama'] ?? '');
    $input['kategori']  = trim($_POST['kategori'] ?? '');
    $input['harga']     = trim($_POST['harga'] ?? '');
    $input['stok']      = trim($_POST['stok'] ?? '');
    $input['deskripsi'] = trim($_POST['deskripsi'] ?? '');

    // Validasi
    if ($input['nama'] === '')
        $errors['nama'] = 'Nama produk wajib diisi.';
    elseif (mb_strlen($input['nama']) > 100)
        $errors['nama'] = 'Nama produk maksimal 100 karakter.';

    if ($input['kategori'] === '')
        $errors['kategori'] = 'Kategori wajib dipilih.';

    if ($input['harga'] === '')
        $errors['harga'] = 'Harga wajib diisi.';
    elseif (!is_numeric($input['harga']) || $input['harga'] < 0)
        $errors['harga'] = 'Harga harus berupa angka positif.';

    if ($input['stok'] === '')
        $errors['stok'] = 'Stok wajib diisi.';
    elseif (!ctype_digit($input['stok']))
        $errors['stok'] = 'Stok harus berupa bilangan bulat positif.';

    if (empty($errors)) {
        $stmt = $pdo->prepare(
            "INSERT INTO produk (nama, kategori, harga, stok, deskripsi) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $input['nama'],
            $input['kategori'],
            $input['harga'],
            (int)$input['stok'],
            $input['deskripsi'],
        ]);
        header('Location: index.php?pesan=tambah');
        exit;
    }
}

$kategori_list = ['Elektronik', 'Fashion', 'Makanan & Minuman', 'Furnitur', 'Olahraga', 'Kesehatan', 'Lainnya'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
    <h1>Tambah Produk</h1>
    <a href="index.php">← Kembali</a>
</nav>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Form Tambah Produk</h2>
        </div>

        <form method="POST" action="create.php">

            <div class="form-group">
                <label for="nama">Nama Produk <span class="required">*</span></label>
                <input
                    type="text"
                    id="nama"
                    name="nama"
                    value="<?= htmlspecialchars($input['nama']) ?>"
                    placeholder="Masukkan nama produk"
                    maxlength="100">
                <?php if (!empty($errors['nama'])): ?>
                    <small style="color:#e74c3c;"><?= $errors['nama'] ?></small>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="kategori">Kategori <span class="required">*</span></label>
                <select id="kategori" name="kategori">
                    <option value="">-- Pilih Kategori --</option>
                    <?php foreach ($kategori_list as $k): ?>
                        <option value="<?= $k ?>" <?= $input['kategori'] === $k ? 'selected' : '' ?>>
                            <?= $k ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (!empty($errors['kategori'])): ?>
                    <small style="color:#e74c3c;"><?= $errors['kategori'] ?></small>
                <?php endif; ?>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="harga">Harga (Rp) <span class="required ">*</span></label>
                    <input
                        type="number"
                        id="harga"
                        name="harga"
                        value="<?= htmlspecialchars($input['harga']) ?>"
                        placeholder="Contoh: 150000"
                        min="0"
                        step="100">
                    <?php if (!empty($errors['harga'])): ?>
                        <small style="color:#e74c3c;"><?= $errors['harga'] ?></small>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="stok">Stok <span class="required">*</span></label>
                    <input
                        type="number"
                        id="stok"
                        name="stok"
                        value="<?= htmlspecialchars($input['stok']) ?>"
                        placeholder="Jumlah stok"
                        min="0">
                    <?php if (!empty($errors['stok'])): ?>
                        <small style="color:#e74c3c;"><?= $errors['stok'] ?></small>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" placeholder="Deskripsi produk (opsional)"><?= htmlspecialchars($input['deskripsi']) ?></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-success">Simpan Produk</button>
                <a href="index.php" class="btn btn-secondary">Batal</a>
            </div>

        </form>
    </div>
</div>

</body>
</html>