<?php
require_once '../config/connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

$id = $_GET['id'] ?? 0;
$record = $conn->query("SELECT * FROM ibadah_harian WHERE id = $id AND user_id = {$_SESSION['user_id']}")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = $_POST['tanggal'];
    $subuh = isset($_POST['subuh']) ? 1 : 0;
    $dzuhur = isset($_POST['dzuhur']) ? 1 : 0;
    $ashar = isset($_POST['ashar']) ? 1 : 0;
    $maghrib = isset($_POST['maghrib']) ? 1 : 0;
    $isya = isset($_POST['isya']) ? 1 : 0;
    $tadarus = $_POST['tadarus'] ?? 0;
    $puasa = isset($_POST['puasa']) ? 1 : 0;
    $catatan = $_POST['catatan'];

    $sql = "UPDATE ibadah_harian SET tanggal = '$tanggal', subuh = $subuh, dzuhur = $dzuhur, ashar = $ashar, maghrib = $maghrib, isya = $isya, tadarus = $tadarus, puasa = $puasa, catatan = '$catatan' WHERE id = $id AND user_id = {$_SESSION['user_id']}";
    if ($conn->query($sql)) {
        header('Location: index.php');
        exit;
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Edit Jurnal Ramadhan</title>
</head>
<body>
    <h1>Edit Jurnal Ramadhan</h1>
    <a href="index.php">Kembali</a>

    <?php if (isset($message)) echo "<p>$message</p>"; ?>

    <form method="POST" action="">
        <label>Tanggal: <input type="date" name="tanggal" value="<?= $record['tanggal'] ?>" required></label><br><br>

        <label><input type="checkbox" name="subuh" <?= $record['subuh'] ? 'checked' : '' ?>> Sholat Subuh</label><br>
        <label><input type="checkbox" name="dzuhur" <?= $record['dzuhur'] ? 'checked' : '' ?>> Sholat Dzuhur</label><br>
        <label><input type="checkbox" name="ashar" <?= $record['ashar'] ? 'checked' : '' ?>> Sholat Ashar</label><br>
        <label><input type="checkbox" name="maghrib" <?= $record['maghrib'] ? 'checked' : '' ?>> Sholat Maghrib</label><br>
        <label><input type="checkbox" name="isya" <?= $record['isya'] ? 'checked' : '' ?>> Sholat Isya</label><br><br>

        <label>Tadarus (halaman): <input type="number" name="tadarus" min="0" value="<?= $record['tadarus'] ?>"></label><br><br>

        <label><input type="checkbox" name="puasa" <?= $record['puasa'] ? 'checked' : '' ?>> Puasa</label><br><br>

        <label>Catatan: <textarea name="catatan"><?= $record['catatan'] ?></textarea></label><br><br>

        <button type="submit">Simpan</button>
    </form>
</body>
</html>
