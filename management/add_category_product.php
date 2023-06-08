<?php
require_once('../config/database.php');

spl_autoload_register(function ($className) {
    require_once("../app/models/$className.php");
});

$categoryModel = new CategoryModel();
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$conn->set_charset('utf8mb4');

if (isset($_POST['p_id'])) {
    $p_id = $_POST['p_id'];
    $c_id = $_POST['c_id'];
    $err = [];

    if (empty($p_id)) {
        $err['p_id'] = 'Bạn chưa nhập mã sản phẩm';
    }

    if (!empty($p_id)) {
        $sql = "SELECT * FROM products WHERE id = $p_id";
        $querry = mysqli_query($conn, $sql);
        $checkProduct = mysqli_num_rows($querry);
        if ($checkProduct == 0) {
            $err['p_id'] = 'Mã sản phẩm này không tồn tại';
        }
    }

    if (empty($err)) {
        $categoryModel->addCategoryProduct($p_id, $c_id);
        echo "Thêm sản phẩm vào danh mục thành công!";
    } else {
        echo "Thêm sản phẩm vào danh mục thất bại!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAONANAS - Thêm sản phẩm vào danh mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
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
                <a class="navbar-brand" style="font-size: 2rem;" href="../index.php">BAONANAS</a>
            </a>
        </div>
    </nav>
    <div class="container">
        <h2 style="padding: 0 0 20px 0; text-align: center">THÊM SẢN PHẨM VÀO DANH MỤC NIÊM YẾT</h2>
        <form action="./add_category_product.php" method="POST">
            <div class="mb-3">
                <label for="product_id" class="form-label">Mã sản phẩm</label>
                <input type="text" class="form-control" id="p_id" name="p_id">
                <div class="has-error">
                    <span><?php echo isset($err['p_id']) ? $err['p_id'] : '' ?></span>
                </div>
            </div>
            <div class="mb-3">
                <label for="form-label">Danh mục</label>
                <select name="c_id" class="form-control">
                    <option value="1">Basas</option>
                    <option value="2">Vintas</option>
                    <option value="3">Urbas</option>
                    <option value="4">Pattas</option>
                    <option value="5">Creas</option>
                    <option value="6">Track 6</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Xác nhận</button>
        </form>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>

</html>