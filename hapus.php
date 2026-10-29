<?php
// ===== DELETE: hapus data berdasarkan id =====
require_once "config.php";
wajib_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_valid($_POST['csrf'] ?? '')) {
    $id = (int)($_POST['id'] ?? 0);

    $stmt = mysqli_prepare($koneksi, "DELETE FROM mahasiswa WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    $_SESSION['flash'] = 'deleted';
}

header("Location: index.php");
exit;
