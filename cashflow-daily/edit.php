<?php
require "../config/connection.php";

session_start();
if (!$_SESSION['is_login']) {
    header("location: ../auth/login.php");
}

if (isset($_GET["id"])) {
    $id = $_GET['id'];
    $sql = "SELECT * from cashflow WHERE id = $id";
    $query = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($query);

    $spend = (float) $data['spend'];
    $description = $data['description'];
}

$error = "";

if (isset($_POST["submit"])) {
    $description = $_POST["description"];
    $spend = $_POST["spend"];

    if (empty($description) || empty($spend)) {
        $error = "All input fields must be filled!";
    }

    if (!is_numeric($spend)) {
        $error = "Investment amount must be a valid number!";
    }

    if (empty($error)) {
        $sql = "UPDATE cashflow SET
                    description = '$description',
                    spend = '$spend' WHERE id = $id";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            header("Location: ../cashflow-daily.php?success=record has been successfully edited!");
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}

?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Dashboard Template · Bootstrap v5.0</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">



    <!-- Bootstrap core CSS -->
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

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
    <link href="../css/dashboard.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <div class="row">

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Edit Cashflow</h1>
                </div>

                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                }
                ?>

                <div class="container">
                    <div class="mt-4">
                        <div class="container">
                            <div class="mt-4">
                                <!-- Form sederhana untuk create -->
                                <form action="" method="post">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <input type="text" class="form-control" id="description" name="description" value="<?php echo htmlspecialchars($description); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="spend" class="form-label">Spend</label>
                                        <input type="number" class="form-control" id="spend" name="spend" value="<?php echo htmlspecialchars($spend) ?>" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </main>
    </div>
    </div>

</body>
<script src="assets/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
<script src="js/dashboard.js"></script>

</html>