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
        header('Location: ../index.php');
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
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white p-6">
            <h1 class="text-2xl font-semibold mb-6">Jurnal Ramadhan</h1>
            <div class="space-y-4">
                <a href="tambah_jurnal.php" class="block text-gray-300 hover:text-white">Tambah Jurnal</a>
                <a href="logout.php" class="block text-gray-300 hover:text-white">Logout</a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <?php if (isset($message)) echo "<p class='mt-4 text-green-600'>$message</p>"; ?>

            <a href="../index.php" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">&larr; Kembali</a>

            <h2 class="text-2xl font-semibold mt-6 mb-4 text-gray-800">Catat Jurnal Ramadhan</h2>

            <form method="POST" action="" class="space-y-4">
                <!-- Tanggal -->
                <label class="block text-gray-700">
                    Tanggal:
                    <input type="date" name="tanggal" required class="w-full p-2 border border-gray-300 rounded-md">
                </label>

                <!-- Sholat Checkbox -->
                <div class="space-y-2">
                    <label class="inline-flex items-center text-gray-700">
                        <input type="checkbox" name="subuh" class="form-checkbox">
                        <span class="ml-2">Sholat Subuh</span>
                    </label>
                    <label class="inline-flex items-center text-gray-700">
                        <input type="checkbox" name="dzuhur" class="form-checkbox">
                        <span class="ml-2">Sholat Dzuhur</span>
                    </label>
                    <label class="inline-flex items-center text-gray-700">
                        <input type="checkbox" name="ashar" class="form-checkbox">
                        <span class="ml-2">Sholat Ashar</span>
                    </label>
                    <label class="inline-flex items-center text-gray-700">
                        <input type="checkbox" name="maghrib" class="form-checkbox">
                        <span class="ml-2">Sholat Maghrib</span>
                    </label>
                    <label class="inline-flex items-center text-gray-700">
                        <input type="checkbox" name="isya" class="form-checkbox">
                        <span class="ml-2">Sholat Isya</span>
                    </label>
                </div>

                <!-- Tadarus -->
                <label class="block text-gray-700">
                    Tadarus (halaman):
                    <input type="number" name="tadarus" min="0" class="w-full p-2 border border-gray-300 rounded-md">
                </label>

                <!-- Puasa Checkbox -->
                <label class="inline-flex items-center text-gray-700">
                    <input type="checkbox" name="puasa" class="form-checkbox">
                    <span class="ml-2">Puasa</span>
                </label>

                <!-- Catatan -->
                <label class="block text-gray-700">
                    Catatan:
                    <textarea name="catatan" class="w-full p-2 border border-gray-300 rounded-md"></textarea>
                </label>

                <!-- Submit -->
                <button type="submit" class="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700">Simpan</button>
            </form>
        </div>
    </div>
</body>
</html>
