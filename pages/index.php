<?php
require_once '../config/connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php'); 
    exit;
}

$result = $conn->query("SELECT * FROM ibadah_harian WHERE user_id = {$_SESSION['user_id']} ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Jurnal Ramadhan</title>
</head>
<body>
    <h1>Selamat datang, <?= $_SESSION['username'] ?>!</h1>
    <a href="logout.php">Logout</a>
    <a href="tambah_jurnal.php">Tambah Jurnal</a>

    <h2>Daftar Jurnal Ramadhan</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Subuh</th>
                <th>Dzuhur</th>
                <th>Ashar</th>
                <th>Maghrib</th>
                <th>Isya</th>
                <th>Tadarus</th>
                <th>Puasa</th>
                <th>Catatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['tanggal'] ?></td>
                <td><?= $row['subuh'] ? 'Ya' : 'Tidak' ?></td>
                <td><?= $row['dzuhur'] ? 'Ya' : 'Tidak' ?></td>
                <td><?= $row['ashar'] ? 'Ya' : 'Tidak' ?></td>
                <td><?= $row['maghrib'] ? 'Ya' : 'Tidak' ?></td>
                <td><?= $row['isya'] ? 'Ya' : 'Tidak' ?></td>
                <td><?= $row['tadarus'] ?></td>
                <td><?= $row['puasa'] ? 'Ya' : 'Tidak' ?></td>
                <td><?= $row['catatan'] ?></td>
                <td>
                    <a href="edit_jurnal.php?id=<?= $row['id'] ?>">Edit</a>
                    <a href="delete_jurnal.php?delete_id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>