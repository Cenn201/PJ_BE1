<?php
include 'cart-function.php';
session_start();
require_once ('./config/database.php');
$user = isset($_SESSION['user']) ? $_SESSION['user'] : [];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body style="background-color: rgba(0,0,0, 0.2);">
    <nav style="padding: 10px 0 40px 0;">
        <div class="container-fluid">
            <a href="./index.php">
                <img src="https://ananas.vn/wp-content/themes/ananas/fe-assets/images/svg/Logo_Ananas_Header.svg" alt="logo" class="img-fluid" style="margin-right: 20px;">
                <a class="navbar-brand" style="font-size: 2rem;" href="./index.php">BAONANAS</a>
            </a>
        </div>
    </nav>
<div class="container">
    <h1 style="text-align: center;">Cảm ơn bạn <?php echo $user['name'] ?> đã mua sản phẩm từ công ty chúng tôi</h1>
    <h2>Chúng tôi sẽ sớm liên hệ cho bạn để xác nhận đơn hàng</h2>
    <a class="btn btn-success" href="./index.php">Về trang chủ</a>
</div>      
</body>
</html>