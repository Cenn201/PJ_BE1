<?php
    session_start();
    require_once('../config/database.php');
    spl_autoload_register(function($className){
        require_once("../app/models/$className.php");
    });

    $user = isset($_SESSION['user']) ? $_SESSION['user'] : [];

    if(isset($_POST['email'])){
        $userModel = new UserModel();
        $email = $_POST['email'];
        $old_pass = $_POST['old-pass'];
        $new_pass = $_POST['new-pass'];
        $re_pass = $_POST['re-pass'];
        $err = [];
        // Kiểm tra nếu người dùng chưa nhập vào form và kiểm tra logic
        if($re_pass == ''){
            $err['re_pass'] = 'Bạn chưa nhập lại mật khẩu mới';
        }

        if($email != $user['email']){
            $err['email'] = 'Email bạn nhập chưa chính xác';
            if($email == ''){
                $err['email'] = 'Bạn chưa nhập email';
            }
        }

        if(password_verify($old_pass, $user['password']) == false) {
            $err['old_pass'] = 'Mật khẩu cũ bạn nhập không chính xác';
            if($old_pass == ''){
                $err['old_pass'] = 'Bạn chưa nhập mật khẩu cũ';
            }
        }

        if($new_pass == ''){
            $err['new_pass'] = 'Bạn chưa nhập mật khẩu mới';
        }

        if($old_pass != null && $new_pass != null && $old_pass == $new_pass) {
            $err['err1'] = 'Mật khẩu mới không được giống mật khẩu cũ';
        }

        if($new_pass != $re_pass){
            $err['err2'] = 'Mật khẩu bạn nhập lại chưa chính xác';
        }
 
        if($email == $user['email'] && password_verify($old_pass, $user['password']) == true && $old_pass != $new_pass){
            $userModel->changePassword($new_pass, $email);
            echo 'Đổi mật khẩu thành công!';
            header('Location: logout.php');
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đổi mật khẩu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"></head>
    <style>
        .has-error{
            color: red;
        }
    </style>
    sc
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
    <form method="POST">
        <h2 style="padding: 0 0 20px 0; text-align: center">ĐỔI MẬT KHẨU</h2>
        <div class="mb-3">
            <label for="" class="form-label">Email</label>
            <input name="email" type="text" class="form-control" placeholder="Nhập email bạn đã dùng để đăng ký tài khoản">
            <div class="has-error">
                <span><?php echo isset($err['email']) ? $err['email'] : ''?></span>
            </div>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Mật khẩu cũ</label>
            <input name="old-pass" type="password" class="form-control">
            <div class="has-error">
                <span><?php echo isset($err['old_pass']) ? $err['old_pass'] : ''?></span>
            </div>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Mật khẩu mới</label>
            <input name="new-pass" type="password" class="form-control">
            <div class="has-error">
                <span><?php echo isset($err['new_pass']) ? $err['new_pass'] : ''?></span>
                <span><?php echo isset($err['err1']) ? $err['err1'] : ''?></span>
            </div>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Nhập lại mật khẩu mới</label>
            <input name="re-pass" type="password" class="form-control">
            <div class="has-error">
                <span><?php echo isset($err['re_pass']) ? $err['re_pass'] : ''?></span>
                <span><?php echo isset($err['err2']) ? $err['err2'] : ''?></span>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Xác nhận</button>
    </form>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script> 
</body>
</html>