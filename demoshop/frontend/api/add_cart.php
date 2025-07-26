<?php
session_start();

include_once(__DIR__ . '/../../dbconnect.php');

$id = $_POST['id'];
$name = $_POST['name'];
$price = $_POST['price'];
$quantity = $_POST['quantity'];
$image = $_POST['image'];

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]['quantity'] += $quantity;
    $_SESSION['cart'][$id]['total'] = $_SESSION['cart'][$id]['quantity'] * $price;
} else {
    $_SESSION['cart'][$id] = [
        'id' => $id,
        'name' => $name,
        'price' => $price,
        'quantity' => $quantity,
        'image' => $image,
        'total' => ($quantity * $price)
    ];
}

// Trả về kết quả chuẩn cho frontend
$response = [
    'success' => true,
    'cart' => $_SESSION['cart'],
    'message' => $name . ' đã được thêm vào giỏ hàng!'
];
echo json_encode($response);
