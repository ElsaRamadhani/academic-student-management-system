<?php
session_start();
require_once __DIR__ . '/config/db.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

/* ===========================
   DASHBOARD STATISTICS
=========================== */

// Total Mahasiswa
$total = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM students")
);

// Total Jurusan
$totalJurusan = mysqli_num_rows(
    mysqli_query($conn, "SELECT DISTINCT major FROM students")
);

// Angkatan Terbaru
$angkatan = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT MAX(batch) AS terbaru FROM students")
);

// Data Chart
$chart = mysqli_query($conn,"
SELECT major,COUNT(*) total
FROM students
GROUP BY major
");

$labels = [];
$values = [];

while($row=mysqli_fetch_assoc($chart)){
    $labels[]=$row['major'];
    $values[]=$row['total'];
}

// Statistik tabel
$tabel=mysqli_query($conn,"
SELECT major,COUNT(*) total
FROM students
GROUP BY major
");

?>
<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>ASMS Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<link rel="preconnect"
href="https://fonts.googleapis.com">

<link rel="preconnect"
href="https://fonts.gstatic.com"
crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<link rel="stylesheet"
href="assets/style.css">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>

<!-- ======================
SIDEBAR
====================== -->

<div class="sidebar">

<div class="logo">

🎓 ASMS

</div>

<a href="index.php" class="active">

<i class="bi bi-grid-fill"></i>

Dashboard

</a>

<a href="mahasiswa/index.php">

<i class="bi bi-people-fill"></i>

Data Mahasiswa

</a>

<a href="#">

<i class="bi bi-bar-chart-fill"></i>

Statistik

</a>

<a href="logout.php">

<i class="bi bi-box-arrow-right"></i>

Logout

</a>

</div>

<!-- ======================
CONTENT
====================== -->

<div class="content">

<!-- TOPBAR -->

<div class="topbar">

<div>

<h3 class="fw-bold mb-1">

Dashboard

</h3>

<span class="text-secondary">

Academic Student Management System

</span>

</div>

<div class="d-flex align-items-center gap-3">

<span class="badge bg-primary p-3">

<i class="bi bi-calendar-event"></i>

<?= date('d M Y'); ?>

</span>

<div class="text-end">

<b>Administrator</b>

<br>

<small class="text-muted">

Online

</small>

</div>

<div style="
width:50px;
height:50px;
border-radius:50%;
background:#2563eb;
color:white;
display:flex;
align-items:center;
justify-content:center;
font-size:22px;
">

<i class="bi bi-person-fill"></i>

</div>

</div>

</div>

<!-- ======================
WELCOME
====================== -->

<div class="mb-4">

<h2 class="fw-bold">

Selamat Datang 👋

</h2>

<p class="text-muted">

Kelola data mahasiswa dengan mudah melalui dashboard ASMS.

</p>

</div>

<!-- ======================
STATISTIK CARD
====================== -->

<div class="row g-4">
    <!-- CARD 1 -->

<div class="col-lg-4 col-md-6">

<div class="card card-dashboard">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center">

            <div>

            <div class="card-title text-white">

                    Total Mahasiswa

                </div>

                <div class="card-number text-white">

                    <?= $total; ?>

                </div>

                <small class="text-success">

                    <i class="bi bi-arrow-up"></i>

                    Data Mahasiswa Aktif

                </small>

            </div>

            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                style="width:70px;height:70px;">

                <i class="bi bi-people-fill fs-2"></i>

            </div>

        </div>

    </div>

</div>

</div>

<!-- CARD 2 -->

<div class="col-lg-4 col-md-6">

<div class="card card-dashboard">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center">

            <div>

            <div class="card-title text-white">

                    Total Jurusan

                </div>

                <div class="card-number text-white">

                    <?= $totalJurusan; ?>

                </div>

                <small class="text-primary">

                    <i class="bi bi-building"></i>

                    Jurusan Terdaftar

                </small>

            </div>

            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center"
                style="width:70px;height:70px;">

                <i class="bi bi-mortarboard-fill fs-2"></i>

            </div>

        </div>

    </div>

</div>

</div>

<!-- CARD 3 -->

<div class="col-lg-4 col-md-12">

<div class="card card-dashboard">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center">

            <div>

            <div class="card-title text-white">

                    Angkatan Terbaru

                </div>

                <div class="card-number text-white">

                    <?= $angkatan['terbaru']; ?>

                </div>

                <small class="text-warning">

                    <i class="bi bi-calendar-event"></i>

                    Tahun Akademik

                </small>

            </div>

            <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center"
                style="width:70px;height:70px;">

                <i class="bi bi-calendar3 fs-2"></i>

            </div>

        </div>

    </div>

</div>

</div>

</div>
<!-- ===========================
QUICK ACTION
=========================== -->

<div class="row mt-4 mb-4">

    <div class="col-lg-3 col-md-6 mb-3">

        <a href="mahasiswa/tambah.php" class="text-decoration-none">

            <div class="card card-dashboard h-100">

                <div class="card-body text-center">

                    <i class="bi bi-person-plus-fill fs-1 text-primary"></i>

                    <h5 class="mt-3 fw-bold">

                        Tambah Mahasiswa

                    </h5>

                    <small class="text-muted">

                        Input data mahasiswa baru

                    </small>

                </div>

            </div>

        </a>

    </div>

    <div class="col-lg-3 col-md-6 mb-3">

        <a href="mahasiswa/index.php" class="text-decoration-none">

            <div class="card card-dashboard h-100">

                <div class="card-body text-center">

                    <i class="bi bi-people-fill fs-1 text-success"></i>

                    <h5 class="mt-3 fw-bold">

                        Data Mahasiswa

                    </h5>

                    <small class="text-muted">

                        Lihat seluruh mahasiswa

                    </small>

                </div>

            </div>

        </a>

    </div>

    <div class="col-lg-3 col-md-6 mb-3">

        <div class="card card-dashboard h-100">

            <div class="card-body text-center">

                <i class="bi bi-bar-chart-fill fs-1 text-warning"></i>

                <h5 class="mt-3 fw-bold">

                    Statistik

                </h5>

                <small class="text-muted">

                    Grafik & laporan

                </small>

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-md-6 mb-3">

        <div class="card card-dashboard h-100">

            <div class="card-body text-center">

                <i class="bi bi-printer-fill fs-1 text-danger"></i>

                <h5 class="mt-3 fw-bold">

                    Print

                </h5>

                <small class="text-muted">

                    Cetak laporan

                </small>

            </div>

        </div>

    </div>

</div>

<!-- ===========================
CHART
=========================== -->

<div class="row mt-4">

<div class="col-lg-8">

    <div class="chart-box">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h4 class="fw-bold">

                <i class="bi bi-bar-chart-fill text-primary"></i>

                Statistik Mahasiswa

            </h4>

            <span class="badge bg-primary">

                <?= date('Y'); ?>

            </span>

        </div>

        <canvas id="myChart" height="120"></canvas>

    </div>

</div>

<div class="col-lg-4">

    <!-- PIE CHART -->

    <div class="chart-box mb-4">

        <h5 class="fw-bold mb-4">

            <i class="bi bi-pie-chart-fill text-danger"></i>

            Distribusi Jurusan

        </h5>

        <canvas id="pieChart"></canvas>

    </div>

    <div class="card card-dashboard h-100">

        <div class="card-body">

            <h5 class="fw-bold mb-4">

                Ringkasan

            </h5>

            <div class="mb-4">

                <small>Total Mahasiswa</small>

                <div class="progress mt-2">

                    <div class="progress-bar bg-primary"
                        style="width:100%">

                        <?= $total ?>

                    </div>

                </div>

            </div>

            <div class="mb-4">

                <small>Total Jurusan</small>

                <div class="progress mt-2">

                    <div class="progress-bar bg-success"
                        style="width:100%">

                        <?= $totalJurusan ?>

                    </div>

                </div>

            </div>

            <div>

                <small>Angkatan</small>

                <div class="progress mt-2">

                    <div class="progress-bar bg-warning"
                        style="width:100%">

                        <?= $angkatan['terbaru'] ?>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</div>

<!-- ===========================
TABEL
=========================== -->

<div class="card card-dashboard mt-4">

<div class="card-body">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h4 class="fw-bold">

            <i class="bi bi-table"></i>

            Statistik Jurusan

        </h4>

    </div>

    <table class="table align-middle">

        <thead>

            <tr>

                <th>No</th>

                <th>Jurusan</th>

                <th>Total Mahasiswa</th>

            </tr>

        </thead>

        <tbody>

            <?php
            $no = 1;
            while($row = mysqli_fetch_assoc($tabel)){
            ?>

            <tr>

                <td><?= $no++; ?></td>

                <td><?= $row['major']; ?></td>

                <td>

                    <span class="badge bg-primary">

                        <?= $row['total']; ?>

                    </span>

                </td>

            </tr>

            <?php } ?>

        </tbody>

    </table>

</div>

</div>
<!-- ===========================
CHART JS
=========================== -->

<script>

const ctx = document.getElementById('myChart');

new Chart(ctx,{

    type:'bar',

    data:{

        labels:<?= json_encode($labels); ?>,

        datasets:[{

            label:'Jumlah Mahasiswa',

            data:<?= json_encode($values); ?>,

            backgroundColor:[
                '#2563eb',
                '#10b981',
                '#f59e0b',
                '#ef4444',
                '#8b5cf6',
                '#06b6d4',
                '#ec4899',
                '#84cc16'
            ],

            borderRadius:10,

            borderSkipped:false,

            maxBarThickness:55

        }]

    },

    options:{

        responsive:true,

        maintainAspectRatio:false,

        plugins:{

            legend:{
                display:false
            },

            title:{

                display:true,

                text:'Grafik Mahasiswa per Jurusan',

                font:{
                    size:18,
                    weight:'bold'
                }

            }

        },

        scales:{

            y:{

                beginAtZero:true,

                ticks:{
                    precision:0
                },

                grid:{
                    color:'#eeeeee'
                }

            },

            x:{

                grid:{
                    display:false
                }

            }

        }

    }

});
// ==========================
// PIE / DOUGHNUT CHART
// ==========================

const pie = document.getElementById('pieChart');

new Chart(pie,{

    type:'doughnut',

    data:{

        labels:<?= json_encode($labels); ?>,

        datasets:[{

            data:<?= json_encode($values); ?>,

            backgroundColor:[

                '#2563eb',
                '#10b981',
                '#f59e0b',
                '#ef4444',
                '#8b5cf6',
                '#06b6d4',
                '#ec4899',
                '#84cc16'

            ],

            borderWidth:2

        }]

    },

    options:{

        responsive:true,

        plugins:{

            legend:{

                position:'bottom'

            }

        }

    }

});

</script>

<!-- ===========================
FOOTER
=========================== -->

<footer class="mt-5">

<div class="card card-dashboard">

<div class="card-body text-center">

<h6 class="mb-1">

Academic Student Management System

</h6>

<p class="text-muted mb-0">

© <?= date('Y'); ?> ASMS • Developed with ❤️ using PHP, Bootstrap 5 & Chart.js

</p>

</div>

</div>

</footer>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>