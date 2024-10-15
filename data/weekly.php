<?php

include "../config/connection.php";

$mysql = "SELECT * FROM cashflow WHERE WEEK(time) = WEEK(CURDATE()) AND YEAR(time) = YEAR(CURDATE());";
$result = mysqli_query($conn, $mysql);

$dataPoints = [
    'Monday' => 0,
    'Tuesday' => 0,
    'Wednesday' => 0,
    'Thursday' => 0,
    'Friday' => 0,
    'Saturday' => 0,
    'Sunday' => 0,
];

// Ambil data dari database
while ($data = mysqli_fetch_array($result)) {
    // Mengambil tanggal dari kolom 'time' dan mengonversinya ke format hari
    $dayOfWeek = date('l', strtotime($data['time'])); // Mengambil nama hari dalam bahasa Inggris (contoh: Monday, Tuesday)

    // Mengonversi menjadi float
    $angka = (float) $data['spend'];

    // Menambahkan nilai pengeluaran ke hari yang sesuai
    if (isset($dataPoints[$dayOfWeek])) {
        $dataPoints[$dayOfWeek] += $angka; // Tambahkan nilai ke hari yang sesuai
    }
}

// Ubah array $dataPoints menjadi array numerik yang sesuai untuk Chart.js
$dataPointsForChart = array_values($dataPoints); // [0] untuk Monday, [1] untuk Tuesday, dll.

echo json_encode($dataPoints);
