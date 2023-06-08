<?php
include './cart-function.php';
session_start();
require_once('./config/database.php');
spl_autoload_register(function ($className) {
    require_once("./app/models/$className.php");
});
$user = isset($_SESSION['user']) ? $_SESSION['user'] : [];
if (isset($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
} else {
    $cart = [];
}
$id = isset($_GET['oder_id']) ? $_GET['oder_id'] : null;
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$conn->set_charset('utf8mb4');
$querry = mysqli_query($conn, "SELECT * FROM `oder` WHERE `oder_id` = '$id';");
$value = mysqli_fetch_assoc($querry);
$product = mysqli_query($conn, "SELECT * FROM oder_detail INNER JOIN products ON oder_detail.id_product = products.id WHERE oder_detail.id_oder = '$id'");
if (isset($_POST['phone'])) {
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $note = $_POST['note'];
    $err = [];
    if (empty($phone)) {
        $err['phone'] = 'Bạn chưa nhập số điện thoại';
    }
    if (strlen($phone) > 10) {
        $err['phone'] = 'Số điện thoại không quá 10 số';
    }
    if (empty($address)) {
        $err['address'] = 'Bạn chưa nhập địa chỉ nhận hàng';
    }
    if (empty($err)) {
        $querry = mysqli_query($conn, "UPDATE `oder` SET `phone` = '$phone', `address` = '$address', `note` = '$note' WHERE `oder_id` = '$id';");
        if ($querry == true) {
            echo 'Cập nhật thông tin thành công';
            header('Location: order.php');
        } else {
            echo 'Cập nhật thông tin không thành công';
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
    <title>Cập nhật thông tin giao hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <style>
        .has-error {
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
    <?php if (isset($_SESSION['user'])) {
    ?>
        <form method="POST" action="">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <form action="" method="POST">
                            <h4>Thông tin khách hàng</h4>
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
                                <input type="text" class="form-control" name="phone" value="<?php echo $value['phone']; ?>">
                                <div class="has-error">
                                    <span><?php echo isset($err['phone']) ? $err['phone'] : ''; ?></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Địa chỉ</label>
                                <input type="text" class="form-control" name="address" value="<?php echo $value['address'] ?>">
                                <div class="has-error">
                                    <span><?php echo isset($err['address']) ? $err['address'] : ''; ?></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ghi chú</label>
                                <input type="text" class="form-control" name="note" value="<?php echo $value['note']; ?>">
                            </div>
                            <button type="submit" class="btn btn-warning">CẬP NHẬT</button>
                            <a href="./cancel-oder.php?id=<?php echo $id?>" class="btn btn-danger">HUỶ</a>
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
                            <?php foreach ($product as $item) {
                            ?>
                                <tr>
                                    <td><?php echo $item['product_name']; ?></td>
                                    <td><img src="./public/img/<?php echo $item['product_photo'] ?>" alt="" class="img-fluid" width="75px"></td>
                                    <td><?php echo $item['quantity'] ?></td>
                                    <td><?php echo $item['price']; ?></td>
                                    <td><?php echo $item['price'] * $item['quantity']; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                            <tr>
                                <td>Tổng tiền</td>
                                <td colspan="6" class="text-center"><?php echo number_format($item['quantity'] * $item['price']) . ' VNĐ' ?> VNĐ</td>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>
            </div>
        </form>
    <?php } else {
    ?>
        <div class="alert alert-danger">
            <strong>Vui lòng đăng nhập để mua hàng</strong> <a style="text-decoration: none;" href="./accounts/login.php?action=check-out">Đăng nhập</a>
        </div>
    <?php
    }
    ?>
</body>

</html>