<?php
require_once('../config/database.php');
// autoloading
spl_autoload_register(function ($className) {
    require_once("../app/models/$className.php");
});

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$conn->set_charset('utf8mb4');
$productModel = new ProductModel();

if (isset($_POST['delete-id'])) {
    $id = $_POST['delete-id'];
    $productModel->deleteProduct($id);
}

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $err = [];
    if (empty($search)) {
        $err['search'] = 'Vui lòng nhập mã sản phẩm bạn cần tìm';
    }
    if (empty($err)) {
        $productList = mysqli_query($conn, "SELECT * FROM `products` WHERE `product_code` LIKE '%$search%';");
    }
}

if (empty($_GET['search'])) {
    $productList = $productModel->getProducts();
}

if(isset($_POST['sort'])){
    $sort = $_POST['sort'];
    if($sort == '0'){
        $productList = $productModel->getProducts();
    }
    if($sort == '1'){
        $productList = mysqli_query($conn, "SELECT * FROM `products` ORDER BY `id` ASC;");
    }
    if($sort == '2'){
        $productList = mysqli_query($conn, "SELECT * FROM `products` ORDER BY `product_name` ASC;");
    }
    if($sort == '3'){
        $productList = mysqli_query($conn, "SELECT * FROM `products` ORDER BY `product_status` ASC;");
    }
    if($sort == '4'){
        $productList = mysqli_query($conn, "SELECT * FROM `products` ORDER BY `product_code` ASC;");
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAONANAS - Sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <style>
        .has-error {
            color: red;
        }
    </style>
</head>

<body style="background-color: rgba(0,0,0, 0.2);">
    <nav style="padding: 10px 0 40px 0; background-color:#fff">
        <div class="container-fluid">
            <a href="../index.php" style="text-decoration: none;">
                <img src="https://ananas.vn/wp-content/themes/ananas/fe-assets/images/svg/Logo_Ananas_Header.svg" alt="logo" class="img-fluid" style="margin-right: 20px;">
                <a class="navbar-brand" style="font-size: 2rem;" href="../index.php">BAONANAS</a>
            </a>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2" style="height: 100vh; padding: 20px;">
                <div class="row">
                    <div style="background-color: #fff; padding: 20px; border-radius: 20px">
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
            <div class="col-md-10" style="padding: 20px">
                <div style="background-color: #fff; padding: 60px 80px; border-radius: 20px">
                    <h2>QUẢN LÝ SẢN PHẨM</h2>
                    <p>Tìm kiếm sản phẩm</p>
                    <form class="d-flex" role="search" action="./product_list.php" method="GET">
                        <input class="form-control me-2" type="search" placeholder="Tìm kiếm" aria-label="Search" name="search">
                        <button class="btn btn-success" type="submit">Tìm</button>
                    </form>
                    <div class="has-error">
                        <span><?php echo isset($err['search']) ? $err['search'] : '' ?></span>
                    </div>
                    <p style="padding: 10px 0 0 0;">Sắp xếp sản phẩm</p>
                    <form class="d-flex" action="./product_list.php" method="POST" style="width: 255px;">
                        <select name="sort" class="form-control">
                            <option selected value="0">Tuỳ chọn</option>
                            <option value="1">Theo ID</option>
                            <option value="2">Theo tên</option>
                            <option value="3">Theo tình trạng</option>
                            <option value="4">Theo mã sản phẩm</option>
                        </select>
                        <button style="width: 120px; margin-left: 10px;" class="btn btn-success" type="submit">Sắp xếp</button>
                    </form>
                    <a style="margin: 24px 0;" href="./add_product.php" class="btn btn-primary" target="_blank">Thêm sản phẩm</a>
                    <h3 style="padding: 0 0 10px 0;">Danh sách sản phẩm</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hình ảnh</th>
                                <th>Tên</th>
                                <th>Mã sản phẩm</th>
                                <th>Tình trạng</th>
                                <th>Lượt xem</th>
                                <th>Lựa chọn</th>

                            </tr>
                        </thead>
                        <?php
                        foreach ($productList as $item) {
                        ?>
                            <tr>
                                <td><?php echo $item['id']; ?></td>
                                <td> <img src="../public/img/<?php echo $item['product_photo']; ?>" alt="" class="img-fluid" width="75px"> </td>
                                <td><?php echo $item['product_name']; ?></td>
                                <td><?php echo $item['product_code']; ?></td>
                                <td><?php echo $item['product_status']; ?></td>
                                <td style="text-align: center;"><?php echo $item['product_view']; ?></td>
                                <td class="wrapper">
                                    <a href="./update_product.php?id=<?php echo $item['id']; ?>" class="btn btn-warning" target="_blank">SỬA</a>
                                    <form action="./product_list.php" method="post" onsubmit="return confirm('Ban co muon xoa khong?')">
                                        <input type="hidden" name="delete-id" value="<?php echo $item['id']; ?>">
                                        <button type="submit" class="btn btn-danger" style="margin-top: 10px;">XOÁ</button>
                                    </form>
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