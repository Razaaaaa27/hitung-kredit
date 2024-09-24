<?php
function calculateCreditScore($age, $maritalStatus, $dependents, $occupation, $collateral, $income, $loanAmount)
{
    $score = 0;

    // Usia
    if ($age >= 35) $score += 3;
    elseif ($age >= 23) $score += 2;
    elseif ($age >= 18) $score += 1;

    // Status Pernikahan
    if ($maritalStatus == 'Menikah') $score += 2;
    else $score += 1;

    // Jumlah Tanggungan
    if ($dependents == 0) $score += 3;
    elseif ($dependents == 1) $score += 3;
    elseif ($dependents <= 3) $score += 2;
    else $score += 1;

    // Pekerjaan
    $highScoreJobs = ['PNS', 'Jaksa', 'Dosen', 'Dokter', 'Bidan', 'Pengacara', 'Wiraswasta Besar'];
    $mediumScoreJobs = ['Karyawan Tetap', 'Guru Sertifikasi', 'Wiraswasta Menengah', 'Pensiun'];
    $lowScoreJobs = ['Karyawan Kontrak', 'Karyawan Harian', 'Wiraswasta Kecil', 'Guru honor', 'Petani'];
    $veryLowScoreJobs = ['Asisten rumah tangga', 'Ibu rumah tangga', 'Pelajar/Mahasiswa', 'Tidak bekerja'];

    if (in_array($occupation, $highScoreJobs)) $score += 4;
    elseif (in_array($occupation, $mediumScoreJobs)) $score += 3;
    elseif (in_array($occupation, $lowScoreJobs)) $score += 2;
    elseif (in_array($occupation, $veryLowScoreJobs)) $score += 1;

    // Jaminan
    if ($collateral == 'Rumah') $score += 3;
    elseif ($collateral == 'Mobil') $score += 2;
    elseif ($collateral == 'Sepeda motor') $score += 1;

    // Penghasilan (dimodifikasi untuk memberikan bobot lebih besar)
    if ($income >= 10000000) $score += 8;
    elseif ($income >= 5000000) $score += 6;
    elseif ($income >= 3000000) $score += 4;
    elseif ($income >= 2000000) $score += 2;
    elseif ($income >= 1000000) $score += 1;

    // Jumlah Pinjaman (dimodifikasi untuk memperhitungkan rasio pinjaman terhadap penghasilan)
    $loanToIncomeRatio = $loanAmount / ($income * 12);
    if ($loanToIncomeRatio <= 0.3) $score += 5;
    elseif ($loanToIncomeRatio <= 0.5) $score += 3;
    elseif ($loanToIncomeRatio <= 0.7) $score += 1;
    else $score -= 2; // Penalti untuk rasio pinjaman yang terlalu tinggi

    return $score;
}

function getCreditDecision($score)
{
    if ($score >= 15) return "Diterima";
    else return "Ditolak";
}
