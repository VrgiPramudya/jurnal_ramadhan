<?php
require_once '../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    if ($conn->query($sql)) {
        echo "Registrasi berhasil!";
        header('Location: login.php');
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-sm">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Register</h1>

        <form method="POST" action="">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-600 mb-2">Username</label>
                <input type="text" id="username" name="username" required class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-600 mb-2">Password</label>
                <input type="password" id="password" name="password" required class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit" class="w-full py-3 bg-[#333] text-white font-semibold rounded-md hover:bg-[#555] focus:outline-none focus:ring-2 focus:ring-blue-500">Daftar</button>
        </form>

        <p class="mt-4 text-center text-sm text-gray-600">Sudah punya akun? <a href="login.php" class="text-blue-600 hover:underline">Login di sini</a>.</p>
    </div>

</body>
</html>
