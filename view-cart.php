<?php
include 'cart-function.php';
session_start();
$cnt = 0;
if (isset($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
} else {
    $cart = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body style="background-color: rgba(0,0,0, 0.2);">
    <nav style="padding: 10px 0 40px 0;">
        <div class="container-fluid">
            <a href="./index.php" style="text-decoration: none;">
                <img src="https://ananas.vn/wp-content/themes/ananas/fe-assets/images/svg/Logo_Ananas_Header.svg" alt="logo" class="img-fluid" style="margin-right: 20px;">
                <a class="navbar-brand" style="font-size: 2rem;" href="./index.php">BAONANAS</a>
            </a>
        </div>
    </nav>

    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Hình ảnh</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                    <th>Lựa chọn</th>
                </tr>
            </thead>
            <?php foreach ($cart as $item) {
            ?>
                <tr>
                    <td><?php echo $cnt += 1; ?> </td>
                    <td><?php echo $item['name']; ?></td>
                    <td><img src="./public/img/<?php echo $item['image'] ?>" alt="" class="img-fluid" width="75px"></td>
                    <td>
                        <form action="./cart.php" method="GET">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="id" value="<?php echo $item['id'] ?>">
                            <input type="text" name="quantity" value="<?php echo $item['quantity']; ?>" style="width: 40px; text-align: center;">
                            <button type="submit" style="display: none;" class="btn btn-warning">Cập nhật</button>
                        </form>
                    </td>
                    <td><?php echo $item['price']; ?></td>
                    <td><?php echo $item['price'] * $item['quantity']; ?></td>
                    <td><a href="cart.php?id=<?php echo $item['id']; ?>&action=delete" class="btn btn-danger">Xoá</a></td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <td>Tổng tiền</td>
                <td colspan="6" class="text-center"><?php echo number_format(total_price($cart)) ?> VNĐ</td>
            </tr>
        </table>
        <div class="" style="float: right;">
            <a href="./index.php" class="btn btn-primary">Mua thêm sản phẩm</a>
            <?php if(empty($cart)){
                ?>
            <a style="pointer-events: none;" href="./check-out.php" class="btn btn-success">Đặt hàng</a>
            <?php
            } else {
            ?>
            <a href="./check-out.php" class="btn btn-success">Đặt hàng</a>
            <?php    
            }
            ?>
        </div>
    </div>
</body>

</html>