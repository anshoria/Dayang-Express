<?php
// Langkah 1: Menghubungkan ke database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'dayangexpress';

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Langkah 2: Mengambil data dari database
$query = "SELECT WEEK(tanggal) AS minggu, SUM(harga) AS total_pendapatan FROM pengiriman GROUP BY WEEK(tanggal) ORDER BY minggu DESC LIMIT 4";
$result = mysqli_query($koneksi, $query);

// Langkah 3: Mengumpulkan data
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $minggu = $row['minggu'];
    $total_pendapatan = $row['total_pendapatan'];
    $data[$minggu] = $total_pendapatan;
}

// Langkah 4: Menentukan minggu-minggu yang ingin ditampilkan
$minggu_minggu = array(1, 2, 3, 4); // Misalnya, kita ingin menampilkan 4 minggu terakhir

// Langkah 5: Mengisi minggu-minggu lainnya dengan data 0
foreach ($minggu_minggu as $minggu) {
    if (!isset($data[$minggu])) {
        $data[$minggu] = 0;
    }
}

// Langkah 6: Mengurutkan data berdasarkan minggu
ksort($data);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Grafik Pendapatan Per Minggu</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="grafik"></canvas>

    <script>
        var ctx = document.getElementById('grafik').getContext('2d');
        var data = <?php echo json_encode($data); ?>;

        var labels = Object.keys(data);
        var values = Object.values(data);

        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan',
                    data: values,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>

<?php
// Langkah 7: Menutup koneksi database
mysqli_close($koneksi);
?>
