<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: /demoshop/frontend/index.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include_once(__DIR__ . '/../../dbconnect.php');
    $conn = connectDb();

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: /demoshop/frontend/index.php');
            exit();
        } else {
            $error = "Invalid Username or Password!";
            header("Location: login.php");
        }
    } else {
        $error = "Invalid Username or Password!";
        header("Location: login.php");
    }

    $conn->close();
}
