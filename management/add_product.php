<!-- Final -->
<?php
require_once('../config/database.php');

spl_autoload_register(function ($className) {
    require_once("../app/models/$className.php");
});

$productModel = new ProductModel();

if (isset($_POST['product_name'])) {
    $name = $_POST['product_name'];
    $description = $_POST['product_description'];
    $price = $_POST['product_price'];
    $photo = '';
    $code = $_POST['product_code'];
    $status = $_POST['product_status'];
    $err = [];

    $uploadPath = '../public/img/' . $_FILES['product_photo']['name'];
    if (is_uploaded_file($_FILES['product_photo']['tmp_name']) && move_uploaded_file($_FILES['product_photo']['tmp_name'], $uploadPath)) {
        $photo = $_FILES['product_photo']['name'];
    }

    if (empty($name)) {
        $err['name'] = 'Bạn chưa nhập tên sản phẩm';
    }

    if ($price < 0) {
        $err['price'] = 'Giá sản phẩm phải lớn hơn 0';
    }

    if (empty($price)) {
        $err['price'] = 'Bạn chưa nhập giá sản phẩm';
    }

    if (empty($code)) {
        $err['code'] = 'Bạn chưa nhập mã sản phẩm';
    }

    if($status == 0){
        $status = 'Còn hàng';
    }
    else{
        $status = 'Hết hàng';
    }
    
    if (empty($err)) {
        $productModel->addProduct($name, $description, $price, $photo, $code, $status);
        echo  'Thêm sản phẩm thành công';
    } else {
        echo 'Thêm sản phẩm không thành công';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAONANAS - Thêm sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>
<style>
    .has-error {
        color: red;
    }
</style>

<body>
    <nav style="padding: 10px 0 40px 0;">
        <div class="container-fluid">
            <a href="../index.php" style="text-decoration: none;">
                <img src="https://ananas.vn/wp-content/themes/ananas/fe-assets/images/svg/Logo_Ananas_Header.svg" alt="logo" class="img-fluid" style="margin-right: 20px;">
                <a class="navbar-brand" style="font-size: 2rem;" href="../index.php">BAONANAS</a>
            </a>
        </div>
    </nav>
    <div class="container">
        <h2 style="padding: 0 0 20px 0; text-align: center;">THÊM SẢN PHẨM</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="product_name" class="form-label">Tên sản phẩm</label>
                <input type="text" class="form-control" id="product_name" name="product_name">
                <div class="has-error">
                    <span><?php echo isset($err['name']) ? $err['name'] : ''; ?></span>
                </div>
            </div>
            <div class="mb-3">
                <label label for="product_description" class="form-label">Mô tả</label>
                <input type="text" class="form-control" id="product_description" name="product_description">
            </div>
            <div div class="mb-3">
                <label for="product_price" class="form-label">Giá tiền</label>
                <input type="text" class="form-control" id="product_price" name="product_price">
                <div class="has-error">
                    <span><?php echo isset($err['price']) ? $err['price'] : ''; ?></span>
                </div>
            </div>
            <div div class="mb-3">
                <label for="product_code" class="form-label">Mã sản phẩm</label>
                <input type="text" class="form-control" id="product_code" name="product_code">
                <div class="has-error">
                    <span><?php echo isset($err['code']) ? $err['code'] : ''; ?></span>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Trạng thái</label>
                <select name="product_status" class="form-control">
                    <option value="0">Còn hàng</option>
                    <option value="1">Hết hàng</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">
                    Hình ảnh
                    <input type="file" name="product_photo" id="product_photo" multiple>
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Xác nhận</button>
        </form>
    </div>
</body>
</html>