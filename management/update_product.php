<?php
require_once('../config/database.php');
// autoloading
spl_autoload_register(function ($className) {
    require_once("../app/models/$className.php");
});

$productModel = new ProductModel();
$id = isset($_GET['id']) ? $_GET['id'] : 0;
if ($id == 0) {
    echo "Bạn vui lòng đăng nhập dưới quyền admin để thực hiện các thao tác này!";
    die();
} else {
    $itemProduct = $productModel->getProductsById($id);
}

$msg = '';
if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $photo = $itemProduct['product_photo'];
    $code = $_POST['code'];
    $status = $_POST['status'];
    $err = [];
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

    if ($status == 0) {
        $status = 'Còn hàng';
    } else {
        $status = 'Hết hàng';
    }
    $uploadPath = '../public/img/' . $_FILES['photo']['name'];
    if (is_uploaded_file($_FILES['photo']['tmp_name']) && move_uploaded_file($_FILES['photo']['tmp_name'], $uploadPath)) {
        $photo = $_FILES['photo']['name'];
    }
    if (empty($err)) {
        $productModel->updateProduct($name, $description, $price, $photo, $code, $status, $id);
        $msg = "Cập nhật thông tin sản phẩm thành công";
    } else {
        $msg = "Cập nhật sản phẩm thất bại";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAONANAS - Cập nhật sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <style>
        .has-error {
            color: red;
        }
    </style>
</head>

<body>
    <nav style="padding: 10px 0 40px 0;">
        <div class="container-fluid">
            <a href="../index.php" style="text-decoration: none;">
                <img src="https://ananas.vn/wp-content/themes/ananas/fe-assets/images/svg/Logo_Ananas_Header.svg" alt="logo" class="img-fluid" style="margin-right: 20px;">
                <a class="navbar-brand" style="font-size: 2rem; text-decoration: none;" href="../index.php">BAONANAS</a>
            </a>
        </div>
    </nav>
    <div class="container">
        <h2 style="padding: 0 0 20px 0; text-align: center;">CẬP NHẬT SẢN PHẨM</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Tên sản phẩm</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $itemProduct['product_name']; ?>">
                <div class="has-error">
                    <span><?php echo isset($err['name']) ? $err['name'] : ''; ?></span>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <input type="text" class="form-control" id="description" name="description" value="<?php echo $itemProduct['product_description']; ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Giá tiền</label>
                <input type="text" class="form-control" id="price" name="price" value="<?php echo $itemProduct['product_price']; ?>">
                <div class="has-error">
                    <span><?php echo isset($err['price']) ? $err['price'] : ''; ?></span>
                </div>
            </div>
            <div div class="mb-3">
                <label class="form-label">Mã sản phẩm</label>
                <input type="text" class="form-control" id="code" name="code" value="<?php echo $itemProduct['product_code']; ?>">
                <div class="has-error">
                    <span><?php echo isset($err['code']) ? $err['code'] : ''; ?></span>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Trạng thái</label>
                <select name="status" class="form-control">
                <?php if($itemProduct['product_status'] == 'Còn hàng'){
                    ?>
                    <option selected value="0">Còn hàng</option>
                    <option value="1">Hết hàng</option>
                <?php
                } else{ 
                ?>
                    <option value="0">Còn hàng</option>
                    <option selected value="1">Hết hàng</option>
                <?php  
                }
                ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Hình ảnh</label>
                <input type="file" class="form-control" id="photo" name="photo" value="<?php echo $itemProduct['product_photo']; ?>" multiple>
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
        <h3 style="text-align: center;"><?php echo $msg ?></h3>
    </div>
</body>

</html>