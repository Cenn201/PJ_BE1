<?php
    require_once('../config/database.php');
    // autoloading
    spl_autoload_register(function($className)
    {
        require_once("../app/models/$className.php");
    });
    
    $productModel = new ProductModel();
    if(isset($_POST['delete-id'])){
        $id = $_POST['delete-id'];
        $productModel->deleteProduct($id);
    }
    $productList = $productModel->getProducts();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAONANAS - Sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body style="background-color: rgba(0,0,0, 0.2);">
<nav style="padding: 10px 0 40px 0;">
  <div class="container-fluid">
    <a href="../index.php">
      <img src="https://ananas.vn/wp-content/themes/ananas/fe-assets/images/svg/Logo_Ananas_Header.svg" alt="logo" class="img-fluid" style="margin-right: 20px;">
      <a class="navbar-brand" style="font-size: 2rem;" href="../index.php">BAONANAS</a>
    </a>
  </div>
</nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2" style=" height: 100vh; background-color: #fff; padding: 20px; border: 1px solid #999; border-radius: 20px; margin-left: 40px" >
                <div class="row">
                    <h2>Quản lý Shop</h2>
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
                        <a href="#" class="btn btn-success" style="width: 100%">Quản lý đơn hàng</a>
                    </div>
                </div>
            </div>
            <div class="col-md-9" style="background-color: #fff; margin-left: 60px; padding: 20px 60px; border-radius: 20px; border: 1px solid #999" >
            <h1>Quản lý đơn hàng</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Tên khách hàng</th>
                    <th>Tổng tiền</th>
                    <th>Địa chỉ</th>
                    <th>Ghi chú</th>
                    <th>Trạng thái</th>
                    <th>Lựa chọn</th>
                    
                </tr>
            </thead>
            <?php
            foreach($productList as $item) {
            ?>
            <tr>
                <td><?php echo $item['id']; ?></td>
                <td> <img src="../public/img/<?php echo $item['product_photo']; ?>" alt="" class="img-fluid" width="75px"> </td>
                <td><?php echo $item['product_name']; ?></td>
                <td><?php echo $item['product_code']; ?></td>
                <td><?php echo $item['product_status']; ?></td>
                <td style="text-align: center;"><?php echo $item['product_view']; ?></td>
                <td class="wrapper">
                    <a href="" class="btn btn-warning" target="_blank">XEM CHI TIẾT</a>
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
</body>
</html>