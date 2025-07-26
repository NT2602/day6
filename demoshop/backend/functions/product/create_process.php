<?php
include_once(__DIR__ . '/../../../dbconnect.php');
$conn = connectDb();

$description = $_POST['description'] ?? '';
$image = $_POST['image_url'] ?? '';
$name = $_POST['name'];
$price = $_POST['price'];
$stock_quantity = $_POST['stock_quantity'];
$category = $_POST['category'];

$sql = "INSERT INTO products (name, description, price, stock_quantity, image_url, category) 
        VALUES ('$name', '$description', '$price', '$stock_quantity', '$image', '$category')";

if ($conn->query($sql) === TRUE) {
    header("Location: index.php");
} else {
    header("Location: createProduct.php");
}

$conn->close();
