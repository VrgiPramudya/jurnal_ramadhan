<?php
require_once '../config/connection.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$alert = ""; // Variabel untuk pesan alert

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Menggunakan prepared statement untuk keamanan
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek apakah user ditemukan
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: ../pages/index.php');
            exit;
        } else {
            $alert = "Password salah!";
        }
    } else {
        $alert = "User tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-sm">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Login</h1>

        <form method="POST" action="">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-600 mb-2">Username</label>
                <input type="text" id="username" name="username" required class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-600 mb-2">Password</label>
                <input type="password" id="password" name="password" required class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit" name="login" class="w-full py-3 bg-[#333] text-white font-semibold rounded-md hover:bg-[#555] focus:outline-none focus:ring-2 focus:ring-blue-500">Login</button>
        </form>

        <p class="mt-4 text-center text-sm text-gray-600">Belum punya akun? <a href="register.php" class="text-blue-600 hover:underline">Daftar di sini</a>.</p>
    </div>

    <!-- Menampilkan alert jika ada kesalahan -->
    <?php if (!empty($alert)) : ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?php echo $alert; ?>',
            });
        </script>
    <?php endif; ?>

</body>
</html>
