<?php
require_once "config.php";

// Simpan pilihan bahasa ke $_SESSION (hanya 'id' atau 'en')
if (isset($_GET['lang']) && in_array($_GET['lang'], $bahasa_tersedia, true)) {
    $_SESSION['lang'] = $_GET['lang'];
}

// Kembali ke halaman sebelumnya (hanya file lokal, bukan URL luar)
$kembali = basename($_GET['back'] ?? 'index.php');
$boleh = ['index.php', 'login.php', 'tambah.php', 'edit.php'];
if (!in_array($kembali, $boleh, true)) {
    $kembali = 'index.php';
}
$query = isset($_GET['id']) ? '?id=' . (int)$_GET['id'] : '';
header("Location: " . $kembali . $query);
exit;
