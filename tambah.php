<?php
// ===== CREATE: simpan data baru =====
require_once "config.php";
require_once "validasi.php";
wajib_login();

$error = [];
$nim = $nama = $email = $jurusan = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitasi semua input
    $nim     = bersihkan($_POST['nim'] ?? '');
    $nama    = bersihkan($_POST['nama'] ?? '');
    $email   = bersihkan($_POST['email'] ?? '');
    $jurusan = bersihkan($_POST['jurusan'] ?? '');

    if (!csrf_valid($_POST['csrf'] ?? '')) {
        $error[] = t('err_csrf');
    } else {
        // Validasi kelengkapan & format
        $error = validasi_mahasiswa($nim, $nama, $email, $jurusan);
    }

    // Cek NIM duplikat
    if (empty($error)) {
        $cek = mysqli_prepare($koneksi, "SELECT id FROM mahasiswa WHERE nim = ?");
        mysqli_stmt_bind_param($cek, "s", $nim);
        mysqli_stmt_execute($cek);
        mysqli_stmt_store_result($cek);
        if (mysqli_stmt_num_rows($cek) > 0) {
            $error[] = t('err_nim_dup');
        }
    }

    // Simpan ke database (prepared statement)
    if (empty($error)) {
        $stmt = mysqli_prepare($koneksi, "INSERT INTO mahasiswa (nim, nama, email, jurusan) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssss", $nim, $nama, $email, $jurusan);
        mysqli_stmt_execute($stmt);

        $_SESSION['flash'] = 'saved';
        header("Location: index.php");
        exit;
    }
}

include "header.php";
?>
<h2><?= t('add_title') ?></h2>

<?php foreach ($error as $e): ?>
  <div class="alert alert-error"><?= $e ?></div>
<?php endforeach; ?>

<form method="POST" action="tambah.php">
  <input type="hidden" name="csrf" value="<?= csrf_token() ?>">

  <div class="form-group">
    <label><?= t('nim') ?></label>
    <input type="text" name="nim" value="<?= $nim ?>">
  </div>
  <div class="form-group">
    <label><?= t('name') ?></label>
    <input type="text" name="nama" value="<?= $nama ?>">
  </div>
  <div class="form-group">
    <label><?= t('email') ?></label>
    <input type="text" name="email" value="<?= $email ?>">
  </div>
  <div class="form-group">
    <label><?= t('major') ?></label>
    <select name="jurusan">
      <option value=""><?= t('choose_major') ?></option>
      <?php foreach ($daftar_jurusan as $j): ?>
        <option value="<?= $j ?>" <?= ($jurusan === $j) ? 'selected' : '' ?>><?= $j ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <button type="submit" class="btn btn-primary"><?= t('save') ?></button>
  <a href="index.php" class="btn btn-secondary"><?= t('cancel') ?></a>
</form>
<?php include "footer.php"; ?>
