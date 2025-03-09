<?php
session_start();

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'jurnal_ramadhan';
$port = 3306;

$conn = mysqli_connect($host, $user, $password, $dbname, $port);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

?>
