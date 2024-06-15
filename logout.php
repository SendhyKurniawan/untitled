<?php
session_start(); // Mulai sesi
session_unset(); // Hapus semua variabel sesi
session_destroy(); // Hancurkan sesi
header("Location: index.php"); // Alihkan ke halaman login (atau halaman lain yang diinginkan)
exit();
