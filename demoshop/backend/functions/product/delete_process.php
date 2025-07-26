<?php
include_once(__DIR__ . '/../../../dbconnect.php');
$conn = connectDb();

// Lấy dữ liệu từ form
$id = $_POST['id'];


$sql = "delete from products 
        WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    header("Location: index.php"); 
} else {

    header("Location: update.php?id=$id"); 
}

$conn->close();
