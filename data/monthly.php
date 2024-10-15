<?php

include "../config/connection.php";

// Assuming you have a connection to the database and have executed your SQL query
$mysql = "SELECT * FROM cashflow WHERE YEAR(time) = YEAR(CURDATE());";
$result = mysqli_query($conn, $mysql);

// Initialize an array for each month of the year
$dataPoints = [
    'January'   => 0,
    'February'  => 0,
    'March'     => 0,
    'April'     => 0,
    'May'       => 0,
    'June'      => 0,
    'July'      => 0,
    'August'    => 0,
    'September' => 0,
    'October'   => 0,
    'November'  => 0,
    'December'  => 0,
];

// Process data from the database
while ($data = mysqli_fetch_array($result)) {
    // Get the month from the 'time' column
    $month = date('F', strtotime($data['time'])); // 'F' gives full textual representation of a month

    // Convert spend value to float
    $angka = (float) $data['spend'];

    // Add the spend to the corresponding month
    if (isset($dataPoints[$month])) {
        $dataPoints[$month] += $angka; // Accumulate spend for that month
    }
}

// Ubah array $dataPoints menjadi array numerik yang sesuai untuk Chart.js
$dataPointsForChart = array_values($dataPoints); // [0] untuk January, [1] untuk February, dll.

echo json_encode($dataPoints);
