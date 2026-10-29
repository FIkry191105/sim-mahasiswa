<?php
session_start();
$lang = $_SESSION['lang'] ?? 'id';   // simpan bahasa agar tetap konsisten
session_unset();
session_destroy();

session_start();
$_SESSION['lang'] = $lang;
header("Location: login.php");
exit;
