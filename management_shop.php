<?php
include './cart-function.php';

session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : [];
if ($user['username'] != 'admin') {
    header('Location: index.php');
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAONANAS - Quản lý</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body style="background-color: rgba(0,0,0, 0.2);">
    <nav style="padding: 10px 0 40px 0; background-color:#fff">
        <div class="container-fluid">
            <a href="./index.php" style="text-decoration: none;">
                <img src="	https://ananas.vn/wp-content/themes/ananas/fe-assets/images/svg/Logo_Ananas_Header.svg" alt="logo" class="img-fluid" style="margin-right: 20px;">
                <a class="navbar-brand" style="font-size: 2rem;" href="./index.php">BAONANAS</a>
            </a>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2" style=" height: 100vh; padding: 20px;">
                <div class="row">
                    <div style="background-color: #fff; padding: 20px; border-radius: 20px">
                        <h2>QUẢN LÝ SHOP</h2>
                        <div class="col-md-12" style="padding: 10px 10px;">
                            <a href="./management_shop.php" target="_blank" class="btn btn-success" style="width: 100%;">Trang chủ</a>
                        </div>
                        <div class="col-md-12" style="padding: 10px 10px;">
                            <a href="./management/user_management.php" class="btn btn-success" style="width: 100%">Dach sách tài khoản</a>
                        </div>
                        <div class="col-md-12" style="padding: 10px 10px;">
                            <a href="./management/category_list.php" class="btn btn-success" style="width: 100%">Danh mục sản phẩm</a>
                        </div>
                        <div class="col-md-12" style="padding: 10px 10px;">
                            <a href="./management/product_list.php" class="btn btn-success" style="width: 100%">Danh sách sản phẩm</a>
                        </div>
                        <div class="col-md-12" style="padding: 10px 10px;">
                            <a href="./management/order_list.php" class="btn btn-success" style="width: 100%">Quản lý đơn hàng</a>
                        </div>
                </div>
                </div>
            </div>
            <div class="col-md-10" style="padding: 20px;">
            <div style="background-color: #fff; padding: 60px 80px; border-radius: 20px" >
                <h2 style="padding: 0 0 40px 0; text-align:center;">THÔNG TIN</h2>
                <div class="row">
                    <div class="col-md-4">
                        <img src="./public/img/logo.png" class="img-fluid" alt="">
                    </div>
                    <div class="col-md-6">
                        <h4>Công ty cổ phần Baonanas</h4>
                        <h5>Địa chỉ: Tầng 90 toà nhà TDC Building Centre, 53 Võ Văn Ngân, Linh Chiểu, Thành phố Thủ Đức, Thành phố Hồ Chí Minh</h5>
                        <h5>Mã số thuế: 8668866868</h5>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</body>

</html>