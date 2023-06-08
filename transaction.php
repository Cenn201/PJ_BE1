<?php
include 'cart-function.php';
session_start();
require_once('./config/database.php');
$user = isset($_SESSION['user']) ? $_SESSION['user'] : [];

if(isset($_POST['t_code'])){
    $t_code = $_POST['t_code'];
    $err = [];
    if(empty($t_code)){
        $err['t_code'] = 'Bạn chưa nhập mã giao dịch';
    }
    if(empty($err)){
        header('Location: ./check-out-final.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chuyển khoản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <style>
        .has-error{
            color: red;
        }
    </style>
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
        <div class="mb-3">
            <div class="row">
                <div class="col-md-6">
                    <h3>Chuyển khoản qua tài khoản ngân hàng</h4>
                        <p>Họ và tên người thụ hưởng: Nguyễn Văn Tèo Báo</p>
                        <p>STK: 8668866886 </p>
                        <p>PGD BIVD Chi nhánh Đông Sài Gòn</p>
                        <img style="width: 296px;" src="./public/img/qr_transaction.jpg" class="img-fluid" alt="">
                </div>
                <div class="col-md-6">
                    <form method="POST">
                        <label class="form-label">Mã giao dịch</label>
                        <input type="text" class="form-control" name="t_code">
                        <div class="has-error">
                            <span><?php echo isset($err['t_code']) ? $err['t_code'] : ''; ?></span>
                        </div>
                        <button type="submit" class="btn btn-success" style="margin-top: 20px; float: right;">XÁC NHẬN</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</body>

</html>