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
        header('Location: ../index.php');
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
    <title>Edit Jurnal Ramadhan</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
            <a href="../index.php" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">&larr; Kembali</a>

            <h2 class="text-2xl font-semibold mt-6 mb-4 text-gray-800">Edit Jurnal Ramadhan</h2>

            <?php if (isset($message)) echo "<p class='mt-4 text-red-600'>$message</p>"; ?>

            <form method="POST" action="" class="space-y-4">
                <!-- Tanggal Input -->
                <label class="block text-gray-700">Tanggal: 
                    <input type="date" name="tanggal" value="<?= htmlspecialchars($record['tanggal']) ?>" required class="w-full p-2 border border-gray-300 rounded-md">
                </label>

                <!-- Sholat Checkboxes -->
                <div class="space-y-2">
                    <label class="inline-flex items-center text-gray-700">
                        <input type="checkbox" name="subuh" <?= $record['subuh'] ? 'checked' : '' ?> class="form-checkbox">
                        <span class="ml-2">Sholat Subuh</span>
                    </label>
                    <label class="inline-flex items-center text-gray-700">
                        <input type="checkbox" name="dzuhur" <?= $record['dzuhur'] ? 'checked' : '' ?> class="form-checkbox">
                        <span class="ml-2">Sholat Dzuhur</span>
                    </label>
                    <label class="inline-flex items-center text-gray-700">
                        <input type="checkbox" name="ashar" <?= $record['ashar'] ? 'checked' : '' ?> class="form-checkbox">
                        <span class="ml-2">Sholat Ashar</span>
                    </label>
                    <label class="inline-flex items-center text-gray-700">
                        <input type="checkbox" name="maghrib" <?= $record['maghrib'] ? 'checked' : '' ?> class="form-checkbox">
                        <span class="ml-2">Sholat Maghrib</span>
                    </label>
                    <label class="inline-flex items-center text-gray-700">
                        <input type="checkbox" name="isya" <?= $record['isya'] ? 'checked' : '' ?> class="form-checkbox">
                        <span class="ml-2">Sholat Isya</span>
                    </label>
                </div>

                <!-- Tadarus Input -->
                <label class="block text-gray-700">Tadarus (halaman): 
                    <input type="number" name="tadarus" min="0" value="<?= htmlspecialchars($record['tadarus']) ?>" class="w-full p-2 border border-gray-300 rounded-md">
                </label>

                <!-- Puasa Checkbox -->
                <label class="inline-flex items-center text-gray-700">
                    <input type="checkbox" name="puasa" <?= $record['puasa'] ? 'checked' : '' ?> class="form-checkbox">
                    <span class="ml-2">Puasa</span>
                </label>

                <!-- Catatan Textarea -->
                <label class="block text-gray-700">Catatan: 
                    <textarea name="catatan" class="w-full p-2 border border-gray-300 rounded-md"><?= htmlspecialchars($record['catatan']) ?></textarea>
                </label>

                <!-- Submit Button -->
                <button type="submit" class="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700">Simpan</button>
            </form>
        </div>
    </div>
</body>
</html>
