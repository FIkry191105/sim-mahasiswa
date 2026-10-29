<?php
// ===== Validasi form mahasiswa (dipakai oleh tambah.php & edit.php) =====
// Mengembalikan array error (kosong = valid)
function validasi_mahasiswa($nim, $nama, $email, $jurusan) {
    global $daftar_jurusan;
    $error = [];

    // 1) Kelengkapan data (if-else)
    if ($nim === "" || $nama === "" || $email === "" || $jurusan === "") {
        $error[] = t('err_required');
        return $error; // berhenti, data belum lengkap
    }

    // 2) NIM harus angka 5-15 digit
    if (!preg_match('/^[0-9]{5,15}$/', $nim)) {
        $error[] = t('err_nim');
    }

    // 3) Nama hanya huruf & spasi (titik/apostrof diizinkan; sudah di-encode oleh htmlspecialchars)
    $nama_decoded = htmlspecialchars_decode($nama, ENT_QUOTES);
    if (!preg_match("/^[\p{L} .'-]+$/u", $nama_decoded)) {
        $error[] = t('err_name');
    }

    // 4) Email valid (filter_var)
    if (!filter_var(htmlspecialchars_decode($email), FILTER_VALIDATE_EMAIL)) {
        $error[] = t('err_email');
    }

    // 5) Jurusan harus salah satu dari daftar (switch)
    switch ($jurusan) {
        case "Informatika":
        case "Sistem Informasi":
        case "Teknik Elektro":
        case "Manajemen":
            break; // valid
        default:
            $error[] = t('err_major');
    }

    return $error;
}
