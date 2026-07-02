<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

require_once __DIR__ . '/../config/db.php';

// Pastikan ID valid
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}

// Cek apakah data ada
$cek = mysqli_query($conn, "SELECT * FROM students WHERE id='$id'");

if (mysqli_num_rows($cek) == 0) {
    header("Location: index.php");
    exit;
}

// Hapus data
mysqli_query($conn, "DELETE FROM students WHERE id='$id'");

header("Location: index.php?delete=success");
exit;