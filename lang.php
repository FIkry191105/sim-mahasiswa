<?php
// ===== Sistem Dual Bahasa (disimpan di $_SESSION['lang']) =====
$bahasa_tersedia = ['id', 'en'];

if (!isset($_SESSION['lang']) || !in_array($_SESSION['lang'], $bahasa_tersedia, true)) {
    $_SESSION['lang'] = 'id'; // default Bahasa Indonesia
}

$TEKS = [
  'id' => [
    'app_title'      => 'Sistem Informasi Data Mahasiswa',
    'login'          => 'Masuk',
    'login_title'    => 'Login Sistem',
    'username'       => 'Username',
    'password'       => 'Password',
    'login_failed'   => 'Username atau password salah!',
    'err_login_empty'=> 'Username dan password wajib diisi!',
    'logout'         => 'Keluar',
    'welcome'        => 'Halo',
    'data_title'     => 'Data Mahasiswa',
    'add_title'      => 'Tambah Data Mahasiswa',
    'edit_title'     => 'Ubah Data Mahasiswa',
    'add_btn'        => '+ Tambah Data',
    'no'             => 'No',
    'nim'            => 'NIM',
    'name'           => 'Nama Lengkap',
    'email'          => 'Email',
    'major'          => 'Jurusan',
    'action'         => 'Aksi',
    'choose_major'   => '-- Pilih Jurusan --',
    'save'           => 'Simpan',
    'update'         => 'Perbarui',
    'cancel'         => 'Batal',
    'edit'           => 'Edit',
    'delete'         => 'Hapus',
    'confirm_delete' => 'Yakin ingin menghapus data ini?',
    'no_data'        => 'Belum ada data.',
    'err_required'   => 'Semua field wajib diisi!',
    'err_nim'        => 'NIM harus berupa angka (5-15 digit)!',
    'err_name'       => 'Nama hanya boleh berisi huruf dan spasi!',
    'err_email'      => 'Format email tidak valid!',
    'err_major'      => 'Jurusan tidak valid!',
    'err_nim_dup'    => 'NIM sudah terdaftar!',
    'err_csrf'       => 'Token keamanan tidak valid, silakan ulangi.',
    'err_notfound'   => 'Data tidak ditemukan!',
    'saved'          => 'Data berhasil disimpan.',
    'updated'        => 'Data berhasil diperbarui.',
    'deleted'        => 'Data berhasil dihapus.',
    'language'       => 'Bahasa',
  ],
  'en' => [
    'app_title'      => 'Student Data Information System',
    'login'          => 'Login',
    'login_title'    => 'System Login',
    'username'       => 'Username',
    'password'       => 'Password',
    'login_failed'   => 'Wrong username or password!',
    'err_login_empty'=> 'Username and password are required!',
    'logout'         => 'Logout',
    'welcome'        => 'Hello',
    'data_title'     => 'Student Data',
    'add_title'      => 'Add Student Data',
    'edit_title'     => 'Edit Student Data',
    'add_btn'        => '+ Add Data',
    'no'             => 'No',
    'nim'            => 'Student ID',
    'name'           => 'Full Name',
    'email'          => 'Email',
    'major'          => 'Major',
    'action'         => 'Actions',
    'choose_major'   => '-- Select Major --',
    'save'           => 'Save',
    'update'         => 'Update',
    'cancel'         => 'Cancel',
    'edit'           => 'Edit',
    'delete'         => 'Delete',
    'confirm_delete' => 'Are you sure you want to delete this data?',
    'no_data'        => 'No data yet.',
    'err_required'   => 'All fields are required!',
    'err_nim'        => 'Student ID must be numeric (5-15 digits)!',
    'err_name'       => 'Name may only contain letters and spaces!',
    'err_email'      => 'Invalid email format!',
    'err_major'      => 'Invalid major!',
    'err_nim_dup'    => 'Student ID is already registered!',
    'err_csrf'       => 'Invalid security token, please try again.',
    'err_notfound'   => 'Data not found!',
    'saved'          => 'Data saved successfully.',
    'updated'        => 'Data updated successfully.',
    'deleted'        => 'Data deleted successfully.',
    'language'       => 'Language',
  ],
];

// Ambil teks sesuai bahasa yang tersimpan di session
function t($key) {
    global $TEKS;
    $l = $_SESSION['lang'];
    return $TEKS[$l][$key] ?? $key;
}
