<?php
include '../cart-function.php';
require_once('../config/database.php');
// autoloading
spl_autoload_register(function ($className) {
    require_once("../app/models/$className.php");
});

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$conn->set_charset('utf8mb4');

$oder_querry = mysqli_query($conn, "SELECT * FROM oder WHERE oder_id = '$id'");
$oder = mysqli_fetch_assoc($oder_querry);
$id_account = $oder['user_id'];
$account_querry = mysqli_query($conn, "SELECT * FROM user WHERE id = '$id_account'");
$account = mysqli_fetch_assoc($account_querry);

$product = mysqli_query($conn, "SELECT * FROM oder_detail INNER JOIN products ON oder_detail.id_product = products.id WHERE oder_detail.id_oder = '$id'");

if (isset($_POST['status'])) {
    $status = $_POST['status'];
    mysqli_query($conn, "UPDATE `oder` SET `status` = '$status' WHERE `oder_id` = '$id'");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAONANAS - Chi tiết đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body style="background-color: rgba(0,0,0, 0.2);">
    <nav style="padding: 10px 0 40px 0; background-color:#fff;">
        <div class="container-fluid">
            <a href="../index.php" style="text-decoration: none;">
                <img src="https://ananas.vn/wp-content/themes/ananas/fe-assets/images/svg/Logo_Ananas_Header.svg" alt="logo" class="img-fluid" style="margin-right: 20px;">
                <a class="navbar-brand" style="font-size: 2rem;" href="../index.php">BAONANAS</a>
            </a>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2" style=" height: 100vh; padding: 20px;">
                <div class="row">
                    <div style="background-color: #fff; padding: 20px; border-radius: 20px;">
                        <h2>QUẢN LÝ SHOP</h2>
                        <div class="col-md-12" style="padding: 10px 10px;">
                            <a href="../index.php" target="_blank" class="btn btn-success" style="width: 100%;">Trang chủ</a>
                        </div>
                        <div class="col-md-12" style="padding: 10px 10px;">
                            <a href="./user_management.php" class="btn btn-success" style="width: 100%">Người dùng</a>
                        </div>
                        <div class="col-md-12" style="padding: 10px 10px;">
                            <a href="./category_list.php" class="btn btn-success" style="width: 100%">Danh mục sản phẩm</a>
                        </div>
                        <div class="col-md-12" style="padding: 10px 10px;">
                            <a href="./product_list.php" class="btn btn-success" style="width: 100%">Danh sách sản phẩm</a>
                        </div>
                        <div class="col-md-12" style="padding: 10px 10px;">
                            <a href="./order_list.php" class="btn btn-success" style="width: 100%">Quản lý đơn hàng</a>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-10" style="padding: 20px;">
                <div style="background-color: #fff; padding: 60px 80px; border-radius: 20px">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Thông tin khách hàng</h3>
                        </div>
                        <div class="panel-body text-left">
                            <p>Tên khách hàng: <?php echo $account['name']; ?> </p>
                            <p>Số điện thoại: <?php echo $oder['phone']; ?></p>
                            <p>Địa chỉ: <?php echo $oder['address']; ?></p>
                            <p>Ghi chú: <?php echo $oder['note']; ?></p>
                            <p>
                                Trạng thái:
                                <?php if ($oder['status'] == 0) {
                                    echo 'Chờ xác nhận';
                                }
                                if ($oder['status'] == 1) {
                                    echo 'Đã xác nhận';
                                }
                                if ($oder['status'] == 2) {
                                    echo 'Đang giao hàng';
                                }
                                if ($oder['status'] == 3) {
                                    echo 'Hoàn thành';
                                }
                                if ($oder['status'] == 4) {
                                    echo 'Huỷ';
                                }
                                ?>
                            </p>

                        </div>
                    </div>
                    <table class="table">
                        <h3>Danh sách đơn hàng</h3>
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên sản phẩm</th>
                                <th>Mã sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <?php foreach ($product as $key => $value) {
                        ?>
                            <tr>
                                <td><?php echo $key + 1 ?></td>
                                <td><?php echo $value['product_name']; ?></td>
                                <td><?php echo $value['product_code']; ?></td>
                                <th><?php echo $value['quantity']; ?></th>
                                <th><?php echo $value['price']; ?></th>
                                <th><?php echo $value['price'] * $value['quantity']; ?></th>
                            </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td>TỔNG TIỀN</td>
                            <td><?php echo number_format(total_price($product)) . ' VNĐ'; ?></td>
                        </tr>
                    </table>
                    <form method="POST" class="form-inline" role="form">
                        <div class="form-group">
                            <label class="sr-only">Trạng thái đơn hàng:</label>
                            <select name="status" id="input" class="form-control" required="required" style="width: 180px; margin: 10px 0;">
                                <?php if ($oder['status'] == 0) {
                                ?>
                                    <option selected value="0">Chờ xác nhận</option>
                                    <option value="1">Đã xác nhận</option>
                                    <option value="2">Đang giao hàng</option>
                                    <option value="3">Hoàn thành</option>
                                    <option value="4">Huỷ</option>
                                <?php
                                }
                                ?>
                                <?php if ($oder['status'] == 1) {
                                ?>
                                    <option value="0">Chờ xác nhận</option>
                                    <option selected value="1">Đã xác nhận</option>
                                    <option value="2">Đang giao hàng</option>
                                    <option value="3">Hoàn thành</option>
                                    <option value="4">Huỷ</option>
                                <?php
                                }
                                ?>
                                <?php if ($oder['status'] == 2) {
                                ?>
                                    <option value="0">Chờ xác nhận</option>
                                    <option value="1">Đã xác nhận</option>
                                    <option selected value="2">Đang giao hàng</option>
                                    <option value="3">Hoàn thành</option>
                                    <option value="4">Huỷ</option>
                                <?php
                                }
                                ?>
                                <?php if ($oder['status'] == 3) {
                                ?>
                                    <option value="0">Chờ xác nhận</option>
                                    <option value="1">Đã xác nhận</option>
                                    <option value="2">Đang giao hàng</option>
                                    <option selected value="3">Hoàn thành</option>
                                    <option value="4">Huỷ</option>
                                <?php
                                }
                                ?>
                                <?php if ($oder['status'] == 4) {
                                ?>
                                    <option value="0">Chờ xác nhận</option>
                                    <option value="1">Đã xác nhận</option>
                                    <option value="2">Đang giao hàng</option>
                                    <option value="3">Hoàn thành</option>
                                    <option selected value="4">Huỷ</option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">CẬP NHẬT</button>
                    </form>
                </div>



            </div>
        </div>

    </div>
</body>

</html>