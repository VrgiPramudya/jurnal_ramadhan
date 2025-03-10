<?php
session_start();

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'jurnal_ramadhan';

$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

?>
