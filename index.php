<?php

session_start();
include "config/connection.php";

if (!$_SESSION['is_login']) {
    header("location: auth/login.php");
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

    <!-- Bootstrap core CSS -->
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">

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
                            <a class="nav-link active" aria-current="page" href="index.php">
                                <span data-feather="home"></span>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cashflow-daily.php">
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
                                Income
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <div class="">
                        <h1 class="h2">Dashboard</h1>
                        <h4>Welcome back, <?php echo $_SESSION['username'] ?> 👋</h4>
                    </div>
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

                <div class="d-flex justify-content-between align-item-center">
                    <h2>Weekly Report</h2>
                    <h2 id="weeklyTotalSpend">Weekly Total : </h2>
                </div>
                <canvas class="my-4 w-100" id="weeklyChart" width="900" height="380"></canvas>

                <div class="mb-5"></div>

                <div class="d-flex justify-content-between align-item-center">
                    <h2>Monthly Report</h2>
                    <h2 id="monthlyTotalSpend">Monthly Total : </h2>
                </div>
                <canvas class="my-4 w-100" id="monthlyChart" width="900" height="380"></canvas>
            </main>
        </div>
    </div>


    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
    <script src="js/dashboard.js"></script>

    <script>
        $(document).ready(function() {
            "use strict";

            feather.replace({
                "aria-hidden": "true"
            });

            // AJAX untuk mengambil data dari PHP
            $.ajax({
                url: 'data/weekly.php', // Ganti dengan path file PHP Anda
                type: 'GET',
                dataType: 'json', // Mengharapkan data JSON dari PHP
                success: function(data) {
                    // Menginisialisasi chart setelah data dari PHP diterima
                    var ctx = $("#weeklyChart");
                    let monthlyTotalSpend = $("#monthlyTotalSpend");

                    let dataPoints = [
                        data.Monday,
                        data.Tuesday,
                        data.Wednesday,
                        data.Thursday,
                        data.Friday,
                        data.Saturday,
                        data.Sunday
                    ];

                    let monthlySpend = dataPoints.reduce((accumulator, currentValue) => accumulator + currentValue);

                    monthlyTotalSpend.append("Rp. " + monthlySpend.toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    }).replace('Rp', '').trim())

                    var myChart = new Chart(ctx, {
                        type: "line",
                        data: {
                            labels: [
                                "Monday", "Tuesday", "Wednesday",
                                "Thursday", "Friday", "Saturday", "Sunday"
                            ],
                            datasets: [{
                                data: dataPoints, // Data dari PHP dimasukkan ke sini
                                lineTension: 0,
                                backgroundColor: "transparent",
                                borderColor: "#007bff",
                                borderWidth: 4,
                                pointBackgroundColor: "#007bff",
                            }],
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: false,
                                    },
                                }],
                            },
                            legend: {
                                display: false,
                            },
                        },
                    });
                },
                error: function(jqxhr, textStatus, error) {
                    console.error("Request failed: " + textStatus + ", " + error);
                }
            });

            // AJAX untuk mengambil data dari PHP
            $.ajax({
                url: 'data/monthly.php', // Ganti dengan path file PHP Anda
                type: 'GET',
                dataType: 'json', // Mengharapkan data JSON dari PHP
                success: function(data) {
                    // Menginisialisasi chart setelah data dari PHP diterima
                    var ctx = $("#monthlyChart");
                    let weeklyTotalSpend = $("#weeklyTotalSpend");

                    let dataPoints = [
                        data.January,
                        data.February,
                        data.March,
                        data.April,
                        data.May,
                        data.June,
                        data.July,
                        data.August,
                        data.September,
                        data.October,
                        data.November,
                        data.December
                    ];


                    let weeklySpend = dataPoints.reduce((accumulator, currentValue) => accumulator + currentValue);

                    weeklyTotalSpend.append("Rp. " + weeklySpend.toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    }).replace('Rp', '').trim())

                    var myChart = new Chart(ctx, {
                        type: "line",
                        data: {
                            labels: [
                                "January", "February", "March",
                                "April", "May", "June",
                                "July", "August", "September",
                                "October", "November", "December"
                            ],
                            datasets: [{
                                data: dataPoints, // Data dari PHP dimasukkan ke sini
                                lineTension: 0,
                                backgroundColor: "transparent",
                                borderColor: "#007bff",
                                borderWidth: 4,
                                pointBackgroundColor: "#007bff",
                            }],
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: false,
                                    },
                                }],
                            },
                            legend: {
                                display: false,
                            },
                        },
                    });
                },
                error: function(jqxhr, textStatus, error) {
                    console.error("Request failed: " + textStatus + ", " + error);
                }
            });
        });
    </script>
</body>

</html>