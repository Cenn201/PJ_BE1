<?php
require_once('../config/database.php');
// autoloading
spl_autoload_register(function ($className) {
    require_once("../app/models/$className.php");
});

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$conn->set_charset('utf8mb4');
$oderModel = new CartModel();
$oderList = $oderModel->getOderAndUser();

if(isset($_POST['sort'])){
    $sort = $_POST['sort'];
    if($sort == '0'){
        $oderList = $oderModel->getOderAndUser();
    }
    if($sort == '1'){
        $oderList = mysqli_query($conn, "SELECT * FROM `oder` INNER JOIN `user` ON `user`.`id` = `oder`.`user_id` ORDER BY `total_price` DESC;");
    }
    if($sort == '2'){
        $oderList = mysqli_query($conn, "SELECT * FROM `oder` INNER JOIN `user` ON `user`.`id` = `oder`.`user_id` ORDER BY `status` DESC;");
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAONANAS - Đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body style="background-color: rgba(0,0,0, 0.2);">
    <nav style="padding: 10px 0 40px 0; background-color: #fff;" >
        <div class="container-fluid">
            <a href="../index.php" style="text-decoration: none;">
                <img src="https://ananas.vn/wp-content/themes/ananas/fe-assets/images/svg/Logo_Ananas_Header.svg" alt="logo" class="img-fluid" style="margin-right: 20px;">
                <a class="navbar-brand" style="font-size: 2rem;" href="../index.php">BAONANAS</a>
            </a>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2" style=" height: 100vh; padding: 20px">
                <div class="row">
                    <div style="background-color: #fff; padding: 20px; border-radius: 20px">
                        <h2>QUẢN LÝ SHOP</h2>
                        <div  class="col-md-12" style="padding: 10px 10px;">
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
            <div style="background-color: #fff; padding: 60px 80px; border-radius: 20px" >
            <h2>QUẢN LÝ ĐƠN HÀNG</h2>
                    <p style="padding: 10px 0 0 0;">Sắp xếp sản phẩm</p>
                    <form class="d-flex" action="./order_list.php" method="POST" style="width: 255px;">
                        <select name="sort" class="form-control">
                            <option selected value="0">Tuỳ chọn</option>
                            <option value="1">Theo doanh thu</option>
                            <option value="2">Theo trạng thái</option>
                        </select>
                        <button style="width: 120px; margin-left: 10px;" class="btn btn-success" type="submit">Sắp xếp</button>
                    </form>
                    <h3 style="padding: 40px 0 10px 0;">Danh sách đơn hàng</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Tên khách hàng</th>
                            <th>Tổng tiền</th>
                            <th>Ghi chú</th>
                            <th>Trạng thái</th>
                            <th>Hình thức thanh toán</th>
                            <th>Lựa chọn</th>
                        </tr>
                    </thead>
                    <?php
                    foreach ($oderList as $oder) {
                    ?>
                        <tr>
                            <td><?php echo $oder['oder_id']; ?></td>
                            <td><?php echo $oder['name']; ?></td>
                            <td><?php echo number_format($oder['total_price']) . ' VNĐ'; ?></td>
                            <td><?php echo $oder['note']; ?></td>
                            <td>
                                <?php if ($oder['status'] == 0) {
                                    echo "Chờ xác nhận";
                                }

                                if ($oder['status'] == 1) {
                                    echo "Đã xác nhận";
                                }
                                if ($oder['status'] == 2) {
                                    echo "Đang giao hàng";
                                }
                                if ($oder['status'] == 3) {
                                    echo "Hoàn thành";
                                }
                                if ($oder['status'] == 4) {
                                    echo "Huỷ";
                                }
                                ?>
                            </td>
                            <td><?php if($oder['pay'] == 1){
                                echo 'COD';
                                } 
                                if($oder['pay'] == 2){
                                    echo 'Chuyển khoản';
                                }
                                if($oder['pay'] == 3){
                                    echo 'MOMO';
                                }
                                ?>
                            </td>
                            <td class="wrapper">
                                <a href="./order_detail.php?id=<?php echo $oder['oder_id']; ?>" class="btn btn-warning" target="_blank">CHI TIẾT</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>

            </div>
        </div>

    </div>
</body>

</html>