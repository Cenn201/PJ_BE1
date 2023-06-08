<?php
session_start();
require_once('../config/database.php');
spl_autoload_register(function ($className) {
    require_once("../app/models/$className.php");
});

$userModel = new UserModel();
if (isset($_POST['delete-id'])) {
    $id = $_POST['delete-id'];
    $userModel->deleteUser($id);
}
$listUser = $userModel->getListUser();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAONANAS - Người dùng</title>
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
                        <a href="#" class="btn btn-success" style="width: 100%">Quản lý đơn hàng</a>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-md-10" style="padding: 20px;">
            <div style="background-color: #fff; padding: 60px 80px; border-radius: 20px" >
                <h2>QUẢN LÝ DANH SÁCH TÀI KHOẢN</h2>
                <h3>Danh sách tài khoản</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Họ và tên</th>
                            <th>Email</th>
                            <th>Tên người dùng</th>
                            <th>Mật khẩu</th>
                            <th>Lựa chọn</th>
                        </tr>
                    </thead>
                    <?php
                        $i = 1;
                    foreach ($listUser as $user) {
                    ?>
                        <tr>
                            <td><?php echo $i++?></td>
                            <td><?php echo $user['name'] ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['username']; ?></td>
                            <td><?php echo $user['password']; ?></td>
                            <td class="wrapper">
                                <a href="../accounts/update_user.php?id=<?php echo $user['id'] ?>" class="btn btn-warning" target="_blank">SỬA</a>
                                <form action="./user_management.php" method="post" onsubmit="return confirm('Ban co muon xoa khong?')">
                                    <input type="hidden" name="delete-id" value="<?php echo $user['id'] ?>">
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