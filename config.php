<?php
// ===== Konfigurasi, koneksi database, session, & helper =====
session_start();

$db_host = "localhost";
$db_user = "root";
$db_pass = "";          // sesuaikan dengan password MySQL kamu (XAMPP default: kosong)
$db_name = "db_sim";

// Koneksi Database MySQL
$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
mysqli_set_charset($koneksi, "utf8mb4");

require_once __DIR__ . "/lang.php";

// Daftar jurusan yang valid
$daftar_jurusan = ["Informatika", "Sistem Informasi", "Teknik Elektro", "Manajemen"];

// Sanitasi data input: hapus spasi berlebih, slash, dan encode karakter HTML
function bersihkan($data) {
    $data = trim($data);
    $data = stripslashes($data);
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

// Proteksi halaman: wajib login lewat $_SESSION
function wajib_login() {
    if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
        header("Location: login.php");
        exit;
    }
}

// Token CSRF sederhana untuk form POST
function csrf_token() {
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}
function csrf_valid($token) {
    return isset($_SESSION['csrf']) && is_string($token) && hash_equals($_SESSION['csrf'], $token);
}
