<?php
// ===== READ: tampilkan seluruh data =====
require_once "config.php";
wajib_login();

$flash = $_SESSION['flash'] ?? "";
unset($_SESSION['flash']);

$hasil = mysqli_query($koneksi, "SELECT * FROM mahasiswa ORDER BY id DESC");

include "header.php";
?>
<h2><?= t('data_title') ?></h2>

<?php if ($flash): ?>
  <div class="alert <?= strpos($flash, 'err_') === 0 ? 'alert-error' : 'alert-success' ?>"><?= t($flash) ?></div>
<?php endif; ?>

<a href="tambah.php" class="btn btn-primary"><?= t('add_btn') ?></a>

<table>
  <thead>
    <tr>
      <th><?= t('no') ?></th>
      <th><?= t('nim') ?></th>
      <th><?= t('name') ?></th>
      <th><?= t('email') ?></th>
      <th><?= t('major') ?></th>
      <th><?= t('action') ?></th>
    </tr>
  </thead>
  <tbody>
  <?php if (mysqli_num_rows($hasil) > 0): ?>
    <?php $no = 1; while ($row = mysqli_fetch_assoc($hasil)): ?>
    <tr>
      <td><?= $no++ ?></td>
      <td><?= htmlspecialchars($row['nim'], ENT_QUOTES, 'UTF-8') ?></td>
      <td><?= $row['nama'] ?></td>
      <td><?= $row['email'] ?></td>
      <td><?= htmlspecialchars($row['jurusan'], ENT_QUOTES, 'UTF-8') ?></td>
      <td>
        <a href="edit.php?id=<?= (int)$row['id'] ?>" class="btn btn-warning"><?= t('edit') ?></a>
        <form method="POST" action="hapus.php" class="inline"
              onsubmit="return confirm('<?= t('confirm_delete') ?>');">
          <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
          <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
          <button type="submit" class="btn btn-danger"><?= t('delete') ?></button>
        </form>
      </td>
    </tr>
    <?php endwhile; ?>
  <?php else: ?>
    <tr><td colspan="6" style="text-align:center"><?= t('no_data') ?></td></tr>
  <?php endif; ?>
  </tbody>
</table>
<?php include "footer.php"; ?>
