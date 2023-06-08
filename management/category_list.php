<?php
require_once('../config/database.php');
// autoloading
spl_autoload_register(function ($className) {
    require_once("../app/models/$className.php");
});
$categoryModel = new CategoryModel();
if (isset($_POST['delete-id'])) {
    $id = $_POST['delete-id'];
    $categoryModel->deleteCategory($id);
}
$categoryList = $categoryModel->getAllCategories();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAONANAS - Danh mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body style="background-color: rgba(0,0,0, 0.2);">
    <nav style="padding: 10px 0 40px 0; background-color: #fff;">
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
                <div style="background-color: #fff; padding: 20px; border-radius: 20px">
                    <h2>QUẢN LÝ SHOP</h2>
                    <div class="col-md-12" style="padding: 10px 10px;">
                        <a href="../index.php" target="_blank" class="btn btn-success" style="width: 100%;">Trang chủ</a>
                    </div>
                    <div class="col-md-12" style="padding: 10px 10px;">
                        <a href="./user_management.php" class="btn btn-success" style="width: 100%">Danh sách tài khoản</a>
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
                <h2>QUẢN LÝ DANH MỤC</h2>
                <h3>Danh mục sản phẩm</h3>
                <a href="./add_category_product.php" class="btn btn-primary" target="_blank">Thêm sản phẩm vào danh mục</a>
                <a href="./add_category.php" class="btn btn-primary" target="_blank">Thêm danh mục</a>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Mã danh mục</th>
                            <th>Tên danh mục</th>
                            <th>Lựa chọn</th>
                        </tr>
                    </thead>
                    <?php
                    foreach ($categoryList as $item) {
                    ?>
                        <tr>
                            <td><?php echo $item['id']; ?></td>
                            <td><?php echo $item['category_name']; ?></td>
                            <td class="wrapper">
                                <a href="update_category.php?id=<?php echo $item['id']; ?>" class="btn btn-warning" target="_blank">SỬA</a>
                                <!-- <a onclick="return confirm('Delete your product');" href="deleteproduct.php?id=<?php echo $item['id']; ?>" class="btn btn-danger">Delete</a> -->
                                <form action="./categorylist.php" method="post" onsubmit="return confirm('Ban co muon xoa khong?')">
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