<?php
session_start();
require_once __DIR__ . '/config/db.php';

if(isset($_SESSION['login'])){
    header("Location: index.php");
    exit;
}

$error="";

if(isset($_POST['login'])){

    $username = trim($_POST['username']);
    $password = md5($_POST['password']);

    $query = mysqli_query($conn,"
        SELECT * FROM users
        WHERE username='$username'
        AND password='$password'
    ");

    if(mysqli_num_rows($query)>0){

        $_SESSION['login']=true;

        header("Location:index.php");
        exit;

    }else{

        $error="Username atau Password salah.";

    }

}
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width,initial-scale=1.0">

<title>Login | ASMS</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<style>

*{

margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;

}

body{

background:linear-gradient(135deg,#2563eb,#60a5fa);

height:100vh;

display:flex;

justify-content:center;

align-items:center;

overflow:hidden;

}

.login-card{

width:430px;

background:white;

border-radius:25px;

padding:40px;

box-shadow:0 25px 60px rgba(0,0,0,.2);

animation:fade .7s;

}

@keyframes fade{

from{

opacity:0;
transform:translateY(30px);

}

to{

opacity:1;
transform:translateY(0);

}

}

.logo{

width:90px;

height:90px;

background:#2563eb;

border-radius:50%;

display:flex;

justify-content:center;

align-items:center;

margin:auto;

color:white;

font-size:40px;

margin-bottom:20px;

}

.form-control{

height:50px;

border-radius:12px;

}

.btn-login{

height:50px;

border-radius:12px;

background:#2563eb;

border:none;

font-weight:600;

font-size:17px;

transition:.3s;

}

.btn-login:hover{

background:#1d4ed8;

transform:translateY(-2px);

}

</style>

</head>

<body>

<div class="login-card">

<div class="logo">

<i class="bi bi-mortarboard-fill"></i>

</div>

<h2 class="fw-bold text-center">

ASMS

</h2>

<p class="text-center text-muted mb-4">

Academic Student Management System

</p>

<?php if($error!=""){ ?>

<div class="alert alert-danger">

<?= $error; ?>

</div>

<?php } ?>

<form method="POST">

<div class="mb-3">

<label class="form-label">

Username

</label>

<div class="input-group">

<span class="input-group-text">

<i class="bi bi-person-fill"></i>

</span>

<input
type="text"
name="username"
class="form-control"
placeholder="Masukkan Username"
required>

</div>

</div>

<div class="mb-4">

<label class="form-label">

Password

</label>

<div class="input-group">

<span class="input-group-text">

<i class="bi bi-lock-fill"></i>

</span>

<input
type="password"
name="password"
class="form-control"
placeholder="Masukkan Password"
required>

</div>

</div>

<button
class="btn btn-primary btn-login w-100"
name="login">

<i class="bi bi-box-arrow-in-right"></i>

LOGIN

</button>

</form>

<hr>

<p class="text-center text-muted mt-3 mb-0">

© <?= date('Y'); ?>

Academic Student Management System

</p>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>