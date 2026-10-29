<?php
// ===== UPDATE: ubah data berdasarkan id (identitas unik) =====
require_once "config.php";
require_once "validasi.php";
wajib_login();

$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);

// Ambil data lama
$stmt = mysqli_prepare($koneksi, "SELECT * FROM mahasiswa WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$data) {
    $_SESSION['flash'] = 'err_notfound';
    header("Location: index.php");
    exit;
}

$error   = [];
$nim     = $data['nim'];
$nama    = $data['nama'];
$email   = $data['email'];
$jurusan = $data['jurusan'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim     = bersihkan($_POST['nim'] ?? '');
    $nama    = bersihkan($_POST['nama'] ?? '');
    $email   = bersihkan($_POST['email'] ?? '');
    $jurusan = bersihkan($_POST['jurusan'] ?? '');

    if (!csrf_valid($_POST['csrf'] ?? '')) {
        $error[] = t('err_csrf');
    } else {
        $error = validasi_mahasiswa($nim, $nama, $email, $jurusan);
    }

    // Cek NIM duplikat milik data lain
    if (empty($error)) {
        $cek = mysqli_prepare($koneksi, "SELECT id FROM mahasiswa WHERE nim = ? AND id <> ?");
        mysqli_stmt_bind_param($cek, "si", $nim, $id);
        mysqli_stmt_execute($cek);
        mysqli_stmt_store_result($cek);
        if (mysqli_stmt_num_rows($cek) > 0) {
            $error[] = t('err_nim_dup');
        }
    }

    if (empty($error)) {
        $up = mysqli_prepare($koneksi, "UPDATE mahasiswa SET nim = ?, nama = ?, email = ?, jurusan = ? WHERE id = ?");
        mysqli_stmt_bind_param($up, "ssssi", $nim, $nama, $email, $jurusan, $id);
        mysqli_stmt_execute($up);

        $_SESSION['flash'] = 'updated';
        header("Location: index.php");
        exit;
    }
}

include "header.php";
?>
<h2><?= t('edit_title') ?></h2>

<?php foreach ($error as $e): ?>
  <div class="alert alert-error"><?= $e ?></div>
<?php endforeach; ?>

<form method="POST" action="edit.php?id=<?= $id ?>">
  <input type="hidden" name="id" value="<?= $id ?>">
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

  <button type="submit" class="btn btn-primary"><?= t('update') ?></button>
  <a href="index.php" class="btn btn-secondary"><?= t('cancel') ?></a>
</form>
<?php include "footer.php"; ?>
