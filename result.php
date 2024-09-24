<?php
require_once 'db_connect.php';
require_once 'credit_scoring.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $name = $_GET['name'];
    $age = intval($_GET['age']);
    $maritalStatus = $_GET['maritalStatus'];
    $dependents = intval($_GET['dependents']);
    $occupation = $_GET['occupation'];
    $collateral = $_GET['collateral'];
    $income = floatval(str_replace('.', '', $_GET['income']));
    $loanAmount = floatval($_GET['loanAmount']);

    $score = calculateCreditScore($age, $maritalStatus, $dependents, $occupation, $collateral, $income, $loanAmount);
    $decision = getCreditDecision($score);

    try {
        $stmt = $pdo->prepare("INSERT INTO applicants (name, age, marital_status, dependents, occupation, collateral, income, loan_amount, score, decision) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $age, $maritalStatus, $dependents, $occupation, $collateral, $income, $loanAmount, $score, $decision]);
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
} else {
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Penilaian Kredit</title>
    <link rel="stylesheet" href="/dist/output.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
  
    <style>
        html, body {
            height: 100%; /* Mengatur tinggi body dan html */
            margin: 0; /* Menghilangkan margin default */
        }

        body {
            font-family: 'Roboto', sans-serif;
            color: #1d1d1f;
            line-height: 1.5;
            margin: 0;
            padding: 0;
            background: url('Thumbnail.png') no-repeat center center fixed; /* Ganti dengan path gambar Anda */
            background-size: cover; /* Mengisi seluruh area */
        }

        .container {
            max-width: 800px;
            margin-top: 50px;
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 48px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 40px;
            background-color: white;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>

<body>
    <div class="container">
         <h1 class="font-roboto font-bold">Hasil Penilaian Kredit</h1>
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Skor Kredit: <?php echo $score; ?></h2>
                <h3 class="card-subtitle mb-2 text-muted">Keputusan: <?php echo $decision; ?></h3>
                <table class="table table-bordered mt-4">
                    <tbody>
                        <tr>
                            <th>Nama</th>
                            <td><?php echo htmlspecialchars($name); ?></td>
                        </tr>
                        <tr>
                            <th>Usia</th>
                            <td><?php echo $age; ?> tahun</td>
                        </tr>
                        <tr>
                            <th>Status Pernikahan</th>
                            <td><?php echo $maritalStatus; ?></td>
                        </tr>
                        <tr>
                            <th>Jumlah Tanggungan</th>
                            <td><?php echo $dependents; ?></td>
                        </tr>
                        <tr>
                            <th>Pekerjaan</th>
                            <td><?php echo $occupation; ?></td>
                        </tr>
                        <tr>
                            <th>Jaminan</th>
                            <td><?php echo $collateral; ?></td>
                        </tr>
                        <tr>
                            <th>Penghasilan per Bulan</th>
                            <td>Rp <?php echo number_format($income, 0, ',', '.'); ?></td>
                        </tr>
                        <tr>
                            <th>Jumlah Pinjaman</th>
                            <td>Rp <?php echo number_format($loanAmount, 0, ',', '.'); ?></td>
                        </tr>
                    </tbody>
                </table>
                <a href="index.html" class="btn btn-primary">Kembali ke Formulir</a>
            </div>
        </div>
    </div>
</body>

</html>
