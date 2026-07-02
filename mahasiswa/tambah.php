<?php
session_start();

if(!isset($_SESSION['login'])){
    header("Location: ../login.php");
    exit;
}

require_once __DIR__.'/../config/db.php';

$error="";

if(isset($_POST['submit'])){

    $nim=trim($_POST['nim']);
    $name=trim($_POST['name']);
    $major=trim($_POST['major']);
    $batch=trim($_POST['batch']);
    $email=trim($_POST['email']);

    if(
        empty($nim)||
        empty($name)||
        empty($major)||
        empty($batch)||
        empty($email)
    ){

        $error="Semua data wajib diisi.";

    }else{

        $cek=mysqli_query($conn,"
        SELECT *
        FROM students
        WHERE nim='$nim'
        ");

        if(mysqli_num_rows($cek)>0){

            $error="NIM sudah terdaftar.";

        }else{

            mysqli_query($conn,"
            INSERT INTO students
            (nim,name,major,batch,email)
            VALUES
            ('$nim','$name','$major','$batch','$email')
            ");

            header("Location:index.php?success=1");
            exit;

        }

    }

}

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width,initial-scale=1">

<title>Tambah Mahasiswa</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<link
rel="stylesheet"
href="../assets/style.css">

</head>

<body>

<div class="sidebar">

<div class="logo">

🎓 ASMS

</div>

<a href="../index.php">

<i class="bi bi-grid-fill"></i>

Dashboard

</a>

<a href="index.php" class="active">

<i class="bi bi-people-fill"></i>

Mahasiswa

</a>

<a href="../logout.php">

<i class="bi bi-box-arrow-right"></i>

Logout

</a>

</div>

<div class="content">

<div class="topbar">

<div>

<h3 class="fw-bold">

Tambah Mahasiswa

</h3>

<p class="text-muted">

Tambahkan data mahasiswa baru

</p>

</div>

</div>
<div class="card card-dashboard">

<div class="card-body">

<?php if($error!=""){ ?>

<div class="alert alert-danger">

<?= $error; ?>

</div>

<?php } ?>

<form method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">

NIM

</label>

<input
type="text"
name="nim"
class="form-control"
placeholder="Masukkan NIM"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Nama

</label>

<input
type="text"
name="name"
class="form-control"
placeholder="Masukkan Nama"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Jurusan

</label>

<input
type="text"
name="major"
class="form-control"
placeholder="Masukkan Jurusan"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Angkatan

</label>

<input
type="number"
name="batch"
class="form-control"
min="2000"
max="2100"
required>

</div>

<div class="col-12 mb-4">

<label class="form-label">

Email

</label>

<input
type="email"
name="email"
class="form-control"
placeholder="Masukkan Email"
required>

</div>

<div class="d-flex gap-2">

<button
class="btn btn-primary"
name="submit">

<i class="bi bi-check-circle-fill"></i>

Simpan

</button>

<a
href="index.php"
class="btn btn-secondary">

<i class="bi bi-arrow-left-circle"></i>

Kembali

</a>

</div>

</div>

</form>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>