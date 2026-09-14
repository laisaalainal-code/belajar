<?php
require_once 'config/database.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: index.php');
    exit;
}

// Pastikan produk ada sebelum dihapus
$stmt = $pdo->prepare("SELECT id FROM produk WHERE id = ?");
$stmt->execute([$id]);

if ($stmt->fetch()) {
    $del = $pdo->prepare("DELETE FROM produk WHERE id = ?");
    $del->execute([$id]);
}

header('Location: index.php?pesan=hapus');
exit;