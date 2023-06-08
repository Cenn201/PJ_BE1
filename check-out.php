<?php
include 'cart-function.php';
require_once ('./config/database.php');
session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : [];
if (isset($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
} else {
    $cart = [];
}

$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$connection->set_charset('utf8mb4');

if(isset($_POST['name'])) {
    $user_id = $user['id'];
    $total_price = total_price($cart);
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $note = $_POST['note'];
    $pay = $_POST['pay'];
    $err = [];
    if(empty($phone)) {
        $err['phone'] = 'Bạn chưa nhập số điện thoại';
    }
    if(strlen($phone) >= 11){
        $err['phone'] = 'Số điện thoại không quá 10 số';
    }
    if(empty($address)){
        $err['address'] = 'Bạn chưa nhập địa chỉ nhận hàng';
    }
    if($pay == '0'){
        $err['pay'] = 'Vui lòng chọn phương thức thanh toán';
    }
    if(empty($err)){
        $sql = "INSERT INTO `oder` (`user_id`, `total_price`, `address`, `phone`, `pay`, note) VALUES ('$user_id', '$total_price', '$address', '$phone', '$pay', '$note')";
        $querry = mysqli_query($connection, $sql);
        if($querry == true){
            $id_oder = mysqli_insert_id($connection);
            foreach($cart as $item){
                $sql2 = "INSERT INTO oder_detail(id_oder, id_product, quantity, price) VALUES ('$id_oder', '$item[id]', '$item[quantity]', '$item[price]')";
                mysqli_query($connection, $sql2);
            }
            unset($_SESSION['cart']);
            if($pay == '1'){
                header('Location: ./check-out-final.php');
            }
            if($pay == '2'){
                header('Location: ./transaction.php');
            }
            if($pay == '3'){
                header('Location: ./momo.php');
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng</title>
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
            <a href="./index.php" style="text-decoration: none;">
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
            <div class="col-lg-6">
                <h4>Thông tin khách hàng</h4>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Tên khách hàng</label>
                        <input type="text" class="form-control" name="name" value="<?php echo $user['name'] ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" name="email" value="<?php echo $user['email'] ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" name="phone">
                        <div class="has-error">
                            <span><?php echo isset($err['phone']) ? $err['phone'] : ''; ?></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" name="address">
                        <div class="has-error">
                            <span><?php echo isset($err['address']) ? $err['address'] : ''; ?></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phương thức thanh toán</label>
                        <select name="pay" class="form-control">
                            <option selected value="0">Tuỳ chọn</option>
                            <option value="1">COD</option>
                            <option value="2">Chuyển khoản</option>
                            <option value="3">MOMO</option>
                        </select>
                        <div class="has-error">
                            <span><?php echo isset($err['pay']) ? $err['pay'] : '' ?></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ghi chú</label>
                        <input type="text" class="form-control" name="note">
                    </div>
                </form>
            </div>
            <div class="col-lg-6">
                <h4>Thông tin đơn hàng</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Hình ảnh</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <?php foreach ($cart as $item) {
                    ?>
                        <tr>
                            <td><?php echo $item['name']; ?></td>
                            <td><img src="./public/img/<?php echo $item['image'] ?>" alt="" class="img-fluid" width="75px"></td>
                            <td><?php echo $item['quantity'] ?></td>
                            <td><?php echo $item['price']; ?></td>
                            <td><?php echo $item['price'] * $item['quantity']; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <td>Tổng tiền</td>
                        <td colspan="6" class="text-center"><?php echo number_format(total_price($cart)) ?> VNĐ</td>
                    </tr>
                </table>
                <button style="float: right;" type="submit" class="btn btn-primary">Đặt hàng</button>
            </div>
        </div>
    </div>
    </div>
</form>
<?php } 
else {
?>
    <div class="alert alert-danger">
        <strong>Vui lòng đăng nhập để mua hàng</strong> <a style="text-decoration: none;" href="./accounts/login.php?action=check-out">Đăng nhập</a>
    </div>
<?php    
}
?>
</body>

</html>