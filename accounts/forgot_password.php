<?php
    require_once('../config/database.php');
    
    spl_autoload_register(function($className){
        require_once("../app/models/$className.php");
    });

    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $conn->set_charset('utf8mb4');
    $rand = rand(100000,999999);
    if(isset($_POST['email'])){
        $userModel = new UserModel();
        $email = $_POST['email'];
        $verification = $_POST['verification'];
        $password_default = '123456789';
        $err = [];
        $sql = "SELECT * FROM user WHERE email = '$email'";
        $query = mysqli_query($conn, $sql);
        $checkEmail = mysqli_num_rows($query);
        if($checkEmail == 1){
            $userModel->changePassword($password_default, $email);
            echo"Mật khẩu mới của bạn là: 123456789";
        }
        else{
            $err['email'] = 'Email bạn nhập chưa dùng để đăng ký tài khoản';
        }

        if($email == ''){
            $err['email'] = 'Bạn chưa nhập email';
        }

        if($verification == ''){
            $err['verification'] = 'Bạn chưa nhập mã xác nhận';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <style>
        .has-error{
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
    <form method="POST">
        <h2 style="padding: 0 0 20px 0; text-align: center">QUÊN MẬT KHẨU</h2>
        <div class="mb-3">
            <label for="" class="form-label">Email</label>
            <input name="email" type="text" class="form-control" placeholder="Nhập email bạn đã dùng để đăng ký tài khoản">
            <div class="has-error">
                <span><?php echo isset($err['email']) ? $err['email'] : ''?></span>
            </div>
        </div>
        <div class="mb-3">
            <p> Mã xác nhận: <?php echo $rand ?></p>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Nhập lại mã xác nhận</label>
            <input name="verification" type="text" class="form-control">
            <div class="has-error">
                <span><?php echo isset($err['verification']) ? $err['verification'] : ''?></span>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Xác nhận</button>
    </form>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script> 
</body>
</html>