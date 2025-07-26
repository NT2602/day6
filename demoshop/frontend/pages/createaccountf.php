<?php
session_start();
include_once(__DIR__ . '/../../dbconnect.php');
$conn = connectDb();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $username = trim($_POST['username']);
   $email = trim($_POST['email']);
   $password = $_POST['password'];
   $confirm_password = $_POST['confirm_password'];

   if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
      $error = "Vui lòng điền đầy đủ thông tin.";
   } elseif ($password !== $confirm_password) {
      $error = "Mật khẩu xác nhận không khớp.";
   } else {
      $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
         $error = "Email đã được sử dụng.";
      } else {

         $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
         $role = 'user';
         $insert = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
         $insert->bind_param("ssss", $username, $email, $hashedPassword, $role);

         if ($insert->execute()) {
            $success = "Đăng ký thành công. Bạn có thể đăng nhập.";
            header("Location: login.php");
            $conn->close();
            exit();
         } else {
            $error = "Đăng ký thất bại. Vui lòng thử lại.";
            header("Location: register.php");
            $conn->close();
            exit();
         }
      }
   }
}
