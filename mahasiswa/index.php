<?php
session_start();

if(!isset($_SESSION['login'])){
    header("Location: ../login.php");
    exit;
}

require_once __DIR__.'/../config/db.php';

$success = isset($_GET['success']) ? $_GET['success'] : '';

$update = isset($_GET['update']) ? $_GET['update'] : '';

$delete = isset($_GET['delete']) ? $_GET['delete'] : '';


$keyword = "";

if(isset($_GET['keyword'])){
    $keyword = trim($_GET['keyword']);
}

if($keyword!=""){

    $data = mysqli_query($conn,"
        SELECT *
        FROM students
        WHERE
        nim LIKE '%$keyword%'
        OR
        name LIKE '%$keyword%'
        OR
        major LIKE '%$keyword%'
        ORDER BY id DESC
    ");

}else{

    $data = mysqli_query($conn,"
        SELECT *
        FROM students
        ORDER BY id DESC
    ");

}

$total = mysqli_num_rows(
    mysqli_query($conn,"SELECT * FROM students")
);

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Data Mahasiswa | ASMS</title>

<!-- DATATABLES -->
<link rel="stylesheet"
href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

<link rel="stylesheet"
href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<link
href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<link
rel="stylesheet"
href="../assets/style.css">

</head>

<body>

<!-- SIDEBAR -->

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

<h3 class="fw-bold mb-1">

<i class="bi bi-people-fill text-primary"></i>

Data Mahasiswa

</h3>

<p class="text-muted">

Kelola seluruh data mahasiswa

</p>

</div>

<div>

<span class="badge bg-primary p-3">

<?= date('d M Y'); ?>

</span>

</div>

</div>
<div class="row mb-4">

<div class="col-lg-4">

<div class="card card-dashboard">

<div class="card-body">

<h6 class="text-muted">

Total Mahasiswa

</h6>

<h2 class="fw-bold text-primary">

<?= $total ?>

</h2>

</div>

</div>

</div>

<div class="col-lg-8 text-end">

<a
href="tambah.php"
class="btn btn-primary">

<i class="bi bi-plus-circle-fill"></i>

Tambah Mahasiswa

</a>

</div>

</div>

<div class="card card-dashboard">

<div class="card-body">

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h4 class="fw-bold">

Daftar Mahasiswa

</h4>

<small class="text-muted">

Academic Student Management System

</small>

</div>

<div>

<span class="badge bg-primary">

<?= $total ?>

Mahasiswa

</span>

</div>

</div>

<form
method="GET"
class="row g-3 mb-4">

<div class="col-lg-10">

<input
type="text"
name="keyword"
value="<?= htmlspecialchars($keyword); ?>"
class="form-control"
placeholder="Cari NIM, Nama atau Jurusan...">

</div>

<div class="col-lg-2 d-grid">

<button
class="btn btn-primary">

<i class="bi bi-search"></i>

Cari

</button>

</div>

</form>

<div class="table-responsive">

<table
id="studentTable"
class="table table-hover table-striped align-middle w-100">

<thead>

<tr>

<th>No</th>

<th>NIM</th>

<th>Nama</th>

<th>Jurusan</th>

<th>Angkatan</th>

<th>Email</th>

<th width="170">

Aksi

</th>

</tr>

</thead>

<tbody>

<?php

$no=1;

while($row=mysqli_fetch_assoc($data)){

?>

<tr>

<td><?= $no++; ?></td>

<td><?= htmlspecialchars($row['nim']); ?></td>

<td><?= htmlspecialchars($row['name']); ?></td>

<td>

<span class="badge bg-success">

<?= htmlspecialchars($row['major']); ?>

</span>

</td>

<td><?= htmlspecialchars($row['batch']); ?></td>

<td><?= htmlspecialchars($row['email']); ?></td>

<td>
<a
href="edit.php?id=<?= $row['id']; ?>"
class="btn btn-warning btn-sm">

<i class="bi bi-pencil-square"></i>

</a>

<a
href="delete.php?id=<?= $row['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Yakin ingin menghapus data ini?')">

<i class="bi bi-trash-fill"></i>

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

<footer class="mt-5">

<div class="card card-dashboard">

<div class="card-body text-center">

© <?= date('Y'); ?>

Academic Student Management System

</div>

</div>

</footer>

</div>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<!-- Buttons -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>

<!-- Export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>

$(document).ready(function(){

    $('#studentTable').DataTable({

        responsive:true,

        pageLength:10,

        dom:'Bfrtip',

        buttons:[

            {
                extend:'excel',
                className:'btn btn-success',
                text:'Excel'
            },

            {
                extend:'pdf',
                className:'btn btn-danger',
                text:'PDF'
            },

            {
                extend:'print',
                className:'btn btn-primary',
                text:'Print'
            }

        ],

        language:{

            search:"🔍 Cari :",

            lengthMenu:"Tampilkan _MENU_ data",

            info:"Menampilkan _START_ - _END_ dari _TOTAL_ data",

            paginate:{

                previous:"←",

                next:"→"

            }

        }

    });

});

</script>

</body>
</html>