<?php
require_once "config.php";

// Jika sudah login, langsung ke halaman utama
if (!empty($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

$pesan = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = bersihkan($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';   // password tidak di-encode agar hash cocok

    if ($username === "" || $password === "") {
        $pesan = t('err_login_empty');
    } else {
        $stmt = mysqli_prepare($koneksi, "SELECT username, password FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $hasil = mysqli_stmt_get_result($stmt);
        $user  = mysqli_fetch_assoc($hasil);

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);          // cegah session fixation
            $_SESSION['login']    = true;
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit;
        } else {
            $pesan = t('login_failed');
        }
    }
}

include "header.php";
?>
<div class="login-box">
  <h2><?= t('login_title') ?></h2>

  <?php if ($pesan): ?>
    <div class="alert alert-error"><?= $pesan ?></div>
  <?php endif; ?>

  <form method="POST" action="login.php">
    <div class="form-group">
      <label><?= t('username') ?></label>
      <input type="text" name="username" value="<?= $username ?? '' ?>" autofocus>
    </div>
    <div class="form-group">
      <label><?= t('password') ?></label>
      <input type="password" name="password">
    </div>
    <button type="submit" class="btn btn-primary"><?= t('login') ?></button>
  </form>
</div>
<?php include "footer.php"; ?>
