<?php
session_start();
require_once('../config/database.php');
// autoloading
spl_autoload_register(function ($className) {
    require_once("../app/models/$className.php");
});

$customer = isset($_SESSION['user']) ? $_SESSION['user'] : [];
$userModel = new UserModel();
$id = isset($_GET['id']) ? $_GET['id'] : $customer['id'];
$user = $userModel->getUserById($id);
if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $err = [];

    if ($name == '') {
        $err['name'] = 'Bạn chưa nhập tên người dùng';
    }

    if ($email == '') {
        $err['email'] = 'Bạn chưa nhập email';
    }

    if ($err == null) {
        $userModel->updateUser($name, $email, $id);
        echo 'Cập nhật thông tin thành công';
    } else {
        echo 'Cập nhật thông tin không thành công';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật thông tin tài khoản</title>
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
                <a class="navbar-brand" style="font-size: 2rem;" href="../index.php">BAONANAS</a>
            </a>
        </div>
    </nav>
    <div class="container">
        <h2 style="padding: 0 0 20px 0; text-align: center;">CẬP NHẬT THÔNG TIN TÀI KHOẢN</h2>
        <form action="./update_user.php?id=<?php echo $user['id'] ?>" method="POST">
            <div class="mb-3">
                <label class="form-label">Họ và tên</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $user['name'] ?>">
                <div class="has-error">
                    <span><?php echo isset($err['name']) ? $err['name'] : '' ?></span>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="<?php echo $user['email'] ?>">
                <div class="has-error">
                    <span><?php echo isset($err['email']) ? $err['email'] : '' ?></span>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>
</body>

</html>