<?php
include 'cart-function.php';
session_start();
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$user = isset($_SESSION['user']) ? $_SESSION['user'] : [];
require_once('./config/database.php');
//autoloadding
spl_autoload_register(function ($className) {
    require_once("./app/models/$className.php");
});

$categoryModel = new CategoryModel();
$categoryList = $categoryModel->getAllCategories();

$productModel = new ProductModel();
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $value = $productModel->getProductsById($id);

    if (!isset($_COOKIE['viewedProduct'])) {
        $value = [$id];
        setcookie('viewedProduct', json_encode($value), time() + 3600);
    } else {
        $viewedProduct = json_decode($_COOKIE['viewedProduct']);
        if (in_array($id, $viewedProduct)) {
            array_diff($viewedProduct, array($id));
        }

        if (count($viewedProduct) == 5) {
            array_pop($viewedProduct);
        }
        array_unshift($viewedProduct, $id);
        setcookie('viewedProduct', json_encode($viewedProduct), time() + 3600);
    }
    $productModel->viewProduct($id);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $value['product_name']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="./public/css/main.css">
</head>

<body>
    <header class="header">
        <div class="row">
            <ul class="menu-list">
                <li class="menu-item">
                    <a href="./view-cart.php" style="display: block;" class="menu-item-link">
                        <i style="color: #fff;" class="bi bi-cart"></i>
                        <span class="span-css">Giỏ hàng (<?php echo total_item($cart) ?>)</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="" class="menu-item-link">
                        <img src="https://ananas.vn/wp-content/themes/ananas/fe-assets/images/svg/icon_tim_cua_hang.svg" alt="">
                        Tìm cửa hàng
                    </a>
                </li>
                <li class="menu-item">
                    <?php if (isset($user['name'])) {
                    ?>
                        <a href="" class="menu-item-link">
                            <img src="https://ananas.vn/wp-content/themes/ananas/fe-assets/images//svg/icon_dang_nhap.svg" alt="">
                            <span><?php echo $user['name']; ?></span>
                        </a>
                        <div class="drop-list">
                            <?php if ($user['username'] == 'admin') {
                                echo '<a href="./management_shop.php" class="drop-item" target="_blank">Trang quản lý</a>';
                            }
                            ?>
                            <a href="./accounts/change_password.php" class="drop-item" target="_blank">Đổi mật khẩu</a>
                            <a href="./accounts/logout.php" class="drop-item">Đăng xuất</a>
                            <?php if ($user['username'] != 'admin') {
                            ?>
                                <a href="./accounts/update_user.php" class="drop-item" target="_blank">Cập nhật thông tin</a>';
                            <?php
                            }
                            ?>
                        </div>
                    <?php } else {
                    ?>
                        <a href="./accounts/login.php" class="menu-item-link">
                            <img src="https://ananas.vn/wp-content/themes/ananas/fe-assets/images//svg/icon_dang_nhap.svg" alt="">
                            <span>Đăng nhập</span>
                        </a>
                    <?php
                    }
                    ?>
                </li>
                <li class="menu-item">
                    <a href="./oder.php" class="menu-item-link">
                        <img src="https://ananas.vn/wp-content/themes/ananas/fe-assets/images/svg/icon_gio_hang.svg" alt="">
                        Đơn hàng
                    </a>
                </li>
            </ul>
        </div>
    </header>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a href="./index.php">
                <img src="https://ananas.vn/wp-content/themes/ananas/fe-assets/images/svg/Logo_Ananas_Header.svg" alt="logo" class="img-fluid" style="margin-right: 20px;">
            </a>
            <a class="navbar-brand" href="./index.php">BAONANAS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="./index.php" style="font-size: 1.2rem;">Trang chủ</a>
                    </li>
                    <?php
                    foreach ($categoryList as $item) {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" id="item-link" style="font-size: 1.2rem;" href="category.php?id=<?php echo $item['id']; ?>"><?php echo $item['category_name']; ?></a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>

                <form class="d-flex" role="search" action="./search.php" method="GET">
                    <input class="form-control me-2" type="search" placeholder="Tìm kiếm" aria-label="Search" name="search">
                    <button class="btn btn-outline-success" type="submit">Tìm</button>
                </form>
            </div>
        </div>
    </nav>
    <div class="container" style="height: 800px;">
        <div class="row">
            <div class="col-md-4">
                <img src="./public/img/<?php echo $value['product_photo']; ?>" alt="" class="img-fluid">
            </div>
            <div class="col-md-8">
                <form action="./cart.php" method="GET">
                    <h1><?php echo $value['product_name']; ?></h1>
                    <p>Mã sản phẩm: <?php echo $value['product_code']; ?></p>
                    <p>Tình trạng: <?php echo $value['product_status']; ?></p>
                    <p>Giá: <?php echo number_format($value['product_price']). ' VNĐ'; ?></p>
                    <p><?php echo $value['product_description']; ?></p>
                    <input type="number" name="quantity" value="1" style="width: 40px">
                    <input type="hidden" name="id" value="<?php echo $value['id']; ?>">
                    <button type="submit" class="btn btn-success">Mua ngay</button>
                </form>
            </div>
        </div>
    </div>
    <div class="footer" style="padding: 40px; background-color: #4c4c4c; color: #fff" >
      <div class="row">
        <div class="col-md-4">
          <img src="./public/img/logo.png" class="img-fluid" width="420px" alt="">
        </div>
        <div class="col-md-8">
          <div class="row">
            <div class="col-md-3">
              <h4>SẢN PHẨM</h4>
                <p>Basas</p>
                <p>Vintas</p>
                <p>Urbas</p>
                <p>Creas</p>
                <p>Track 6</p>
            </div>
            <div class="col-md-3">
              <h4>VỀ CÔNG TY</h4>
              <p>Tuyển dụng</p>
              <p>Liên hệ nhượng quyền</p>
              <p>Về chúng tôi</p>
            </div>
            <div class="col-md-3">
              <h4>HỖ TRỢ</h4>
              <p>FAQs</p>
              <p>Bảo mật thông tin</p>
              <p>Chính sách chung</p>
              <p>Tra cứu đơn hàng</p>
            </div>
            <div class="col-md-3">
              <h4>LIÊN HỆ</h4>
              <p>Email góp ý</p>
              <p>Hotline</p>
              <p>113 114 115</p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <h4>BAONANAS SOCIAL</h4>
              <div>
                <img src="https://ananas.vn/wp-content/themes/ananas/fe-assets/images/svg/icon_facebook.svg" alt="">
                <img src="	https://ananas.vn/wp-content/themes/ananas/fe-assets/images/svg/icon_instagram.svg" alt="">
                <img src="	https://ananas.vn/wp-content/themes/ananas/fe-assets/images/svg/icon_youtube.svg" alt="">
              </div>
            </div>
            <div class="col-md-4">
              <h4>ĐĂNG KÝ NHẬN THÔNG TIN</h4>
              <form action="">
                <input type="text" placeholder="email" style="padding: 5px 0;">
                <button style="border: none; padding: 0">
                <img src="https://ananas.vn/wp-content/themes/ananas/fe-assets/images/arrow_right.jpg" alt="">
              </button>
              </form>
            </div>
            <div class="col-md-4">
              <img src="	https://ananas.vn/wp-content/themes/ananas/fe-assets/images/svg/Logo_Ananas_Footer.svg" alt="">
            </div>
          </div>
        </div>
  </div>
</body>

</html>