<?php
session_start();
session_destroy();

echo("Oturum kapatıldı.");
header("Location: http://localhost/");
?>
