<?php
session_start(); // Memulai sesi untuk memastikan sesi saat ini aktif
session_destroy(); // Menghancurkan semua data sesi pengguna
header("Location: Dashboard.php"); // Mengarahkan pengguna ke halaman login
exit(); // Menghentikan eksekusi script setelah melakukan redirect
