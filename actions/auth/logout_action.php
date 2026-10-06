<?php
session_start();
session_unset();
session_destroy();

// Pakai jalur utama proyek biar dijamin pasti ketemu
header("Location: /immanuel-library/index.php");
exit();
?>