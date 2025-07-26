<?php
session_start();
include_once(__DIR__ . '/../../dbconnect.php');

$id = $_POST['id'];

if (isset($_SESSION['cart'][$id])) {
    unset($_SESSION['cart'][$id]);
}
echo json_encode($_SESSION['cart']);
