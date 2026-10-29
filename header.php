<?php
$halaman = basename($_SERVER['PHP_SELF']);
$id_q = isset($_GET['id']) ? '&id=' . (int)$_GET['id'] : '';
?>
<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= t('app_title') ?></title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar">
  <span class="brand"><?= t('app_title') ?></span>
  <span class="nav-right">
    <?= t('language') ?>:
    <a href="set_lang.php?lang=id&back=<?= $halaman . $id_q ?>" class="<?= $_SESSION['lang']=='id' ? 'aktif' : '' ?>">ID</a> |
    <a href="set_lang.php?lang=en&back=<?= $halaman . $id_q ?>" class="<?= $_SESSION['lang']=='en' ? 'aktif' : '' ?>">EN</a>
    <?php if (!empty($_SESSION['login'])): ?>
      &nbsp;·&nbsp; <?= t('welcome') ?>, <b><?= htmlspecialchars($_SESSION['username']) ?></b>
      <a class="btn-logout" href="logout.php"><?= t('logout') ?></a>
    <?php endif; ?>
  </span>
</nav>
<div class="container">
