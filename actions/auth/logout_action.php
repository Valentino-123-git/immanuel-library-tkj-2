<?php
session_start();
session_unset();
session_destroy();

// Otomatis mengarahkan ke pages/login.php jika ada, atau ke index.php
if (file_exists(__DIR__ . '/../../pages/login.php')) {
    header("Location: ../../pages/login.php");
} else {
    header("Location: ../../index.php");
}
exit();
?>