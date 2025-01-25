<?php
require_once '../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = $_POST['tanggal'];
    $subuh = isset($_POST['subuh']) ? 1 : 0;
    $dzuhur = isset($_POST['dzuhur']) ? 1 : 0;
    $ashar = isset($_POST['ashar']) ? 1 : 0;
    $maghrib = isset($_POST['maghrib']) ? 1 : 0;
    $isya = isset($_POST['isya']) ? 1 : 0;
    $tadarus = isset($_POST['tadarus']) && $_POST['tadarus'] !== '' ? (int)$_POST['tadarus'] : 0;
    $puasa = isset($_POST['puasa']) ? 1 : 0;
    $catatan = $_POST['catatan'] ?? '';
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO ibadah_harian (user_id, tanggal, subuh, dzuhur, ashar, maghrib, isya, tadarus, puasa, catatan) 
            VALUES ($user_id, '$tanggal', $subuh, $dzuhur, $ashar, $maghrib, $isya, $tadarus, $puasa, '$catatan')";
    if ($conn->query($sql)) {
        $message = "Data berhasil disimpan!";
        header('Location: index.php');
    } else {
        $message = "Error: " . $conn->error;
    }
}

$result = $conn->query("SELECT * FROM ibadah_harian WHERE user_id = {$_SESSION['user_id']} ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jurnal Ramadhan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Selamat datang, <?= $_SESSION['username'] ?>!</h1>
    <a href="logout.php">Logout</a>

    <?php if (isset($message)) echo "<p>$message</p>"; ?>

    <h2>Catatan Jurnal Ramadhan</h2>
    <form method="POST" action="">
        <label>Tanggal: <input type="date" name="tanggal" required></label><br><br>

        <label><input type="checkbox" name="subuh"> Sholat Subuh</label><br>
        <label><input type="checkbox" name="dzuhur"> Sholat Dzuhur</label><br>
        <label><input type="checkbox" name="ashar"> Sholat Ashar</label><br>
        <label><input type="checkbox" name="maghrib"> Sholat Maghrib</label><br>
        <label><input type="checkbox" name="isya"> Sholat Isya</label><br><br>

        <label>Tadarus (halaman): <input type="number" name="tadarus" min="0"></label><br><br>

        <label><input type="checkbox" name="puasa"> Puasa</label><br><br>

        <label>Catatan: <textarea name="catatan"></textarea></label><br><br>

        <button type="submit">Simpan</button>
    </form>