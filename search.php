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

$productModel = new ProductModel();

if (isset($_POST['like-id'])) {
  $id = $_POST['like-id'];
  if (!isset($_COOKIE['likedProduct'])) {
    $value = [$id];
    $productModel->likeProductNoLogin($id);
    setcookie('likedProduct', json_encode($value), time() + 3600);
  } else {
    $likedProduct = json_decode($_COOKIE['likedProduct']);
    if (!in_array($id, $likedProduct)) {
      $productModel->likeProductNoLogin($id);
      array_push($likedProduct, $id);
      setcookie('likedProduct', json_encode($likedProduct), time() + 3600);
    } else {
      unset($likedProduct[array_search($id, $likedProduct)]);
      $productModel->unlikeProductNoLogin($id);
      setcookie('likedProduct', json_encode($likedProduct), time() + 3600);
    }
  }
}

$viewedProductList = [];
if (isset($_COOKIE['viewedProduct'])) {
  $lstID = json_decode($_COOKIE['viewedProduct']);
  $viewedProductList = $productModel->getProductByIds($lstID);
}

$categoryModel = new CategoryModel();
$categoryList = $categoryModel->getAllCategories();

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$perPage = 9;
$totalPage = ceil($productModel->getTotalProduct() / $perPage);
$productList = $productModel->getProductsByPage($page, $perPage);

if(isset($_GET['search'])){
  $search = $_GET['search'];
  $productList = $productModel->getSearchProduct($search);
}
if(empty($_GET['search'])){
  header('Location: ./index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BAONANAS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
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
          <a href="" class="menu-item-link">
            <img src="https://ananas.vn/wp-content/themes/ananas/fe-assets/images/svg/icon_heart_header.svg" alt="">
            Yêu thích
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
            <a class="nav-link active" aria-current="page" href="./index.php" style="font-size: 1.2rem;">Home</a>
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
  <div class="container" style="padding: 0 0 120px 0;">
    <div class="row">
      <div class="col-md-10">
        <div class="row">
          <?php foreach ($productList as $item) {
          ?>
            <div class="col-md-4" style="padding: 10px;">

              <form action="" method="post">
                <a class="item-link" target="_blank" href="product.php?id=<?php echo $item['id']; ?>">
                  <img src="./public/img/<?php echo $item['product_photo']; ?>" alt="" class="img-fluid">
                  <h5><?php echo $item['product_name']; ?></h5>
                </a>
                <form action="./index.php" action="POST">
                  <input type="hidden" name="like-id" value="<?php echo $item['id']; ?>">
                  <button class="btn btn-danger">
                    <span><?php echo $item['product_like']; ?></span>
                    <i class="bi bi-heart-fill"></i>
                  </button>
                  <button class="btn btn-warning" disabled>
                    <span><?php echo $item['product_view'] ?></span>
                    <i class="bi bi-eye-fill"></i>
                  </button>
                </form>
                <p>Giá: <?php echo $item['product_price']; ?> VND</p>
                <a href="./cart.php?id=<?php echo $item['id'] ?>" class="btn btn-success">Mua ngay</a>
              </form>
            </div>
          <?php
          }
          ?>
        </div>
      </div>
      <div class="col-md-2">
        <h4>Sản phẩm đã xem</h4>
        <div class="card" style="width: 18rem; background-color: #fff; padding: 5px;">
          <?php foreach ($viewedProductList as $view) {
          ?>
            <img src="./public/img/<?php echo $view['product_photo'] ?>" class="card-img-top" style="border-top-right-radius: 10px; border-top-left-radius: 0;">
            <div class="card-body" style="margin-bottom: 24px; border-bottom-left-radius: 10px; background-color: rgba(0,0,0, 0.2); ">
              <h5 class="card-title"><?php echo $view['product_name'] ?></h5>
              <p class="card-text">Giá: <?php echo $view['product_price'] ?> VND</p>
            </div>
          <?php
          }
          ?>
        </div>
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
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>

</html>