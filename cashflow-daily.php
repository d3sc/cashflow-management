<?php

session_start();
include "config/connection.php";

if (!$_SESSION['is_login']) {
    header("location: auth/login.php");
}

if (isset($_GET['success'])) {
    $success = htmlspecialchars($_GET['success'], ENT_QUOTES, 'UTF-8');
}

$tanggalSaatIni = date("d");
$bulanSaatIni = date('m');
$tahunSaatIni = date('Y');
$sql = "SELECT * FROM cashflow WHERE DAY(time) = $tanggalSaatIni AND MONTH(time) = $bulanSaatIni AND YEAR(time) = $tahunSaatIni";
$result = mysqli_query($conn, $sql);

$totalSpend = 0;
while ($data = mysqli_fetch_array($result)) {
    // Mengonversi menjadi float
    $angka = (float) $data['spend'];

    $totalSpend += $angka;
}
$totalSpend = "Rp." . number_format($totalSpend, 2, '.', ',');

if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM cashflow WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("location: cashflow-daily.php?success=record has been successfully deleted!");
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Dashboard Template · Bootstrap v5.0</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">



    <!-- Bootstrap core CSS -->
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- css datatables -->

    <!-- dataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.bootstrap5.js"></script>

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">
</head>

<body>

    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Cashflow Management</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="auth/logout.php">Sign out</a>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php">
                                <span data-feather="home"></span>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="cashflow-daily.php">
                                <span data-feather="shopping-cart"></span>
                                Daily Cashflow
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cashflow.php">
                                <span data-feather="file-text"></span>
                                Cashflow
                            </a>
                        </li>
                    </ul>

                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Saved reports</span>
                        <a class="link-secondary" href="#" aria-label="Add a new report">
                            <span data-feather="plus-circle"></span>
                        </a>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file-text"></span>
                                Current month
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Daily Cashflow</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                            <span data-feather="calendar"></span>
                            This week
                        </button>
                    </div>
                </div>

                <?php
                if ($success) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $success ?>
                    </div>
                <?php
                }
                ?>

                <a href="cashflow-daily/create.php" class="btn btn-primary my-3">
                    Add Cashflow
                </a>

                <div class="d-flex justify-content-between align-item-center">
                    <h2>History Daily Cashflow</h2>
                    <h2>Total: <?php echo $totalSpend ?></h2>
                </div>

                <div class="table-responsive">
                    <table id="example" class="table table-striped table-hover table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Time</th>
                                <th>Description</th>
                                <th>Spend</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $index = 1;

                            $result = mysqli_query($conn, $sql);
                            while ($data = mysqli_fetch_array($result)):
                            ?>
                                <tr>
                                    <td><?php echo $index ?></td>
                                    <td><?php echo $data['time'] ?></td>
                                    <td><?php echo $data['description'] ?></td>
                                    <td><?php echo "Rp." . number_format($data['spend'], 2, '.', ',') ?></td>
                                    <td class="d-flex justify-content-center gap-3">
                                        <a href="cashflow-daily/edit.php?id=<?php echo $data['id'] ?>">
                                            <button class="btn btn-warning">Edit</button>
                                        </a>
                                        <form action="" method="POST">
                                            <input type="text" name="id" value="<?php echo $data['id'] ?>" hidden>
                                            <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php
                                $index++;
                            endwhile;
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Time</th>
                                <th>Description</th>
                                <th>Spend</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </main>
        </div>
    </div>


    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $("#example").DataTable()
        })
    </script>
</body>

</html>