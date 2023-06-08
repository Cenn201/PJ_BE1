<?php
include 'cart-function.php';
session_start();
require_once ('./config/database.php');
spl_autoload_register(function ($className) {
    require_once("./app/models/$className.php");
});
$user = isset($_SESSION['user']) ? $_SESSION['user'] : [];

$cartModel = new CartModel();
$oderList = $cartModel->getOderByUserId($user['id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
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
<?php if(isset($_SESSION['user'])){
?>
<form method="POST" action="check-out.php">
<div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h4>Thông tin đơn hàng</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Tên khách hàng</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Địa chỉ</th>
                            <th>Ghi chú</th>
                            <th>Tổng tiền</th>
                            <th>Tạng thái</th>
                        </tr>
                    </thead>
                    <?php foreach ($oderList as $oder){
                        $tmp = '';
                    ?>
                    <tbody>
                        <tr>
                            <td><?php echo $oder['id']?></td>
                            <td><?php echo $oder['name']?></td>
                            <td><?php echo $oder['email']?></td>
                            <td><?php echo $oder['phone']?></td>
                            <td><?php echo $oder['address']?></td>
                            <td><?php echo $oder['note'] ?></td>
                            <td><?php echo number_format($oder['total_price']) .' VNĐ'?></td>
                            <?php if($oder['status'] == 0){
                                $tmp = 'Chưa xác nhận';
                            }
                            else if($oder['status'] == 1){
                                $tmp = 'Đã xác nhận';
                            }
                            else{
                                $tmp = 'Hoàn thành';
                            }
                            ?>
                            <td><?php echo $tmp ?></td>
                        </tr>
                    </tbody>
                    <?php 
                    }
                    ?>
                </table>
            </div>
        </div>

    </div>
    </div>
</form>
<?php } 
else {
?>
    <div class="alert alert-danger">
        <strong>Vui lòng đăng nhập để xem đơn hàng</strong> <a style="text-decoration: none;" href="./accounts/login.php?action=check-out">Đăng nhập</a>
    </div>
<?php    
}
?>
</body>

</html>