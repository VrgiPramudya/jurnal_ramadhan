<?php
require_once '../config/connection.php';

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $conn->query("DELETE FROM ibadah_harian WHERE id = $delete_id AND user_id = {$_SESSION['user_id']}");
    header('Location: ../index.php');
    exit;
}
?>