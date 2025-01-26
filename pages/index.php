<?php
require_once '../config/connection.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php'); 
    exit;
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM ibadah_harian WHERE user_id = $user_id ORDER BY tanggal DESC");

// Hitung total ibadah
$total_sholat_subuh = 0;
$total_sholat_dzuhur = 0;
$total_sholat_ashar = 0;
$total_sholat_maghrib = 0;
$total_sholat_isya = 0;

$total_puasa = 0;
$total_tadarus = 0;
$total_hari = 0;

$journals = []; // Simpan data jurnal dalam array
while ($row = $result->fetch_assoc()) {
    $journals[] = $row;
    $total_hari++;
    $total_sholat_subuh += $row['subuh'];
    $total_sholat_dzuhur += $row['dzuhur'];
    $total_sholat_ashar += $row['ashar'];
    $total_sholat_maghrib += $row['maghrib'];
    $total_sholat_isya += $row['isya'];
    $total_puasa += $row['puasa'];
    $total_tadarus += $row['tadarus'];
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Jurnal Ramadhan</title>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white p-6">
            <h1 class="text-2xl font-semibold mb-6">Jurnal Ramadhan</h1>
            <div class="space-y-4">
                <a href="tambah_jurnal.php" class="block text-gray-300 hover:text-white">Tambah Jurnal</a>
                <a href="../auth/logout.php" class="block text-gray-300 hover:text-white">Logout</a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6 overflow-auto">
            <div class="bg-gray-300 min-w-full h-40 rounded-lg p-4 flex items-center mb-6">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-800">Selamat datang, <?= htmlspecialchars($_SESSION['username']) ?>!</h1>
                    <p class="text-sm text-gray-600 mt-2">Catat setiap momen berharga selama Ramadhan dan jadikan setiap harinya penuh makna.</p>
                </div>
            </div>

            <!-- Ringkasan Ibadah (Grid Layout) -->
            <p class="text-sm text-gray-600">Rekap selama 1 Bulan.</p>
            <div class="flex space-x-4 mt-6 gap-4">
                <div class="bg-white p-6 shadow rounded-lg">
                    <h2 class="text-lg font-semibold text-gray-700">Subuh</h2>
                    <p class="text-3xl font-bold text-gray-900"><?= $total_sholat_subuh ?></p>
                </div>
                <div class="bg-white p-6 shadow rounded-lg">
                    <h2 class="text-lg font-semibold text-gray-700">Dzuhur</h2>
                    <p class="text-3xl font-bold text-gray-900"><?= $total_sholat_dzuhur ?></p>
                </div>
                <div class="bg-white p-6 shadow rounded-lg">
                    <h2 class="text-lg font-semibold text-gray-700">Ashar</h2>
                    <p class="text-3xl font-bold text-gray-900"><?= $total_sholat_ashar ?></p>
                </div>
                <div class="bg-white p-6 shadow rounded-lg">
                    <h2 class="text-lg font-semibold text-gray-700">Maghrib</h2>
                    <p class="text-3xl font-bold text-gray-900"><?= $total_sholat_maghrib ?></p>
                </div>
                <div class="bg-white p-6 shadow rounded-lg">
                    <h2 class="text-lg font-semibold text-gray-700">Isya</h2>
                    <p class="text-3xl font-bold text-gray-900"><?= $total_sholat_isya ?></p>
                </div>
                <div class="bg-white p-6 shadow rounded-lg">
                    <h2 class="text-lg font-semibold text-gray-700">Puasa</h2>
                    <p class="text-3xl font-bold text-gray-900"><?= $total_puasa ?></p>
                </div>
                <div class="bg-white p-6 shadow rounded-lg">
                    <h2 class="text-lg font-semibold text-gray-700">Tadarus</h2>
                    <p class="text-3xl font-bold text-gray-900"><?= $total_tadarus ?> halaman</p>
                </div>
            </div>

            <!-- Daftar Jurnal -->
            <h2 class="text-2xl font-semibold mt-6 mb-4 text-gray-800">Daftar Jurnal Ramadhan</h2>
            <table class="min-w-full bg-white border border-gray-200 rounded-md shadow-md">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border-b text-left text-gray-600">Tanggal</th>
                        <th class="px-4 py-2 border-b text-left text-gray-600">Subuh</th>
                        <th class="px-4 py-2 border-b text-left text-gray-600">Dzuhur</th>
                        <th class="px-4 py-2 border-b text-left text-gray-600">Ashar</th>
                        <th class="px-4 py-2 border-b text-left text-gray-600">Maghrib</th>
                        <th class="px-4 py-2 border-b text-left text-gray-600">Isya</th>
                        <th class="px-4 py-2 border-b text-left text-gray-600">Tadarus</th>
                        <th class="px-4 py-2 border-b text-left text-gray-600">Puasa</th>
                        <th class="px-4 py-2 border-b text-left text-gray-600">Catatan</th>
                        <th class="px-4 py-2 border-b text-left text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($journals as $row): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border-b"><?= htmlspecialchars($row['tanggal']) ?></td>
                        <td class="px-4 py-2 border-b"><?= $row['subuh'] ? 'Ya' : 'Tidak' ?></td>
                        <td class="px-4 py-2 border-b"><?= $row['dzuhur'] ? 'Ya' : 'Tidak' ?></td>
                        <td class="px-4 py-2 border-b"><?= $row['ashar'] ? 'Ya' : 'Tidak' ?></td>
                        <td class="px-4 py-2 border-b"><?= $row['maghrib'] ? 'Ya' : 'Tidak' ?></td>
                        <td class="px-4 py-2 border-b"><?= $row['isya'] ? 'Ya' : 'Tidak' ?></td>
                        <td class="px-4 py-2 border-b"><?= htmlspecialchars($row['tadarus']) ?></td>
                        <td class="px-4 py-2 border-b"><?= $row['puasa'] ? 'Ya' : 'Tidak' ?></td>
                        <td class="px-4 py-2 border-b"><?= htmlspecialchars($row['catatan']) ?></td>
                        <td class="px-4 py-2 border-b">
                            <a href="edit_jurnal.php?id=<?= $row['id'] ?>" class="text-blue-600 hover:text-blue-800 mr-4">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="delete_jurnal.php?delete_id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus?');" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
