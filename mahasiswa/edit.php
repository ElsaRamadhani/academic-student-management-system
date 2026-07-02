<?php
session_start();

if(!isset($_SESSION['login'])){
    header("Location: ../login.php");
    exit;
}

require_once __DIR__.'/../config/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$result = mysqli_query($conn,"
SELECT *
FROM students
WHERE id='$id'
");

$data = mysqli_fetch_assoc($result);

if(!$data){
    header("Location:index.php");
    exit;
}

$error="";

if(isset($_POST['update'])){

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

        mysqli_query($conn,"
        UPDATE students SET

        nim='$nim',
        name='$name',
        major='$major',
        batch='$batch',
        email='$email'

        WHERE id='$id'
        ");

        header("Location:index.php?update=1");
        exit;

    }

}
?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width,initial-scale=1">

<title>Edit Mahasiswa</title>

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

<h3 class="fw-bold">

Edit Mahasiswa

</h3>

</div>
<div class="card card-dashboard">

<div class="card-body">

<?php if($error!=""){ ?>

<div class="alert alert-danger">

<?= $error ?>

</div>

<?php } ?>

<form method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<label>NIM</label>

<input
type="text"
name="nim"
class="form-control"
value="<?= htmlspecialchars($data['nim']); ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label>Nama</label>

<input
type="text"
name="name"
class="form-control"
value="<?= htmlspecialchars($data['name']); ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label>Jurusan</label>

<input
type="text"
name="major"
class="form-control"
value="<?= htmlspecialchars($data['major']); ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label>Angkatan</label>

<input
type="number"
name="batch"
class="form-control"
value="<?= htmlspecialchars($data['batch']); ?>"
required>

</div>

<div class="col-12 mb-4">

<label>Email</label>

<input
type="email"
name="email"
class="form-control"
value="<?= htmlspecialchars($data['email']); ?>"
required>

</div>

<div class="d-flex gap-2">

<button
class="btn btn-warning"
name="update">

<i class="bi bi-pencil-square"></i>

Update

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