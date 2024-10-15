<?php

session_start();
if (!$_SESSION['is_login']) {
    header("location: ../auth/login.php");
}

require "../config/connection.php";

if (isset($_GET["date"])) {
    $date = $_GET['date'];
    $sql = "SELECT * from cashflow WHERE DATE(time) = '$date'";
    $query = mysqli_query($conn, $sql);

    $totalSpend = 0;
    while ($data = mysqli_fetch_array($query)) {
        // Mengonversi menjadi float
        $angka = (float) $data['spend'];

        $totalSpend += $angka;
    }
    $totalSpend = "Rp." . number_format($totalSpend, 2, '.', ',');
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

    <div class="container-fluid">
        <div class="w-full row d-flex justify-content-center align-item-center">
            <main class="col-md-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Daily Cashflow <?php echo $date ?></h1>
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

                <div class="d-flex justify-content-between align-item-center">
                    <h2>History Daily Cashflow</h2>
                    <h2>Total: <?php echo $totalSpend ?></h2>
                </div>
                <table id="example" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Time</th>
                            <th>Description</th>
                            <th>Spend</th>
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
                            </tr>
                        <?php
                            $index++;
                        endwhile;
                        ?>
                    </tbody>
                </table>

                <div class="d-flex justify-content-end align-item-center">

                    <a href="../cashflow.php" class="m-4">
                        <button class="btn btn-primary">
                            back
                        </button>
                    </a>
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