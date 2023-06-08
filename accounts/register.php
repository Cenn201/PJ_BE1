<?php
    require_once ('../config/database.php');

    spl_autoload_register(function($className){
        require_once ("../app/models/$className.php");
    });
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $conn->set_charset('utf8mb4');
    $err = [];

    if(isset($_POST['username'])){
        $userModel = new UserModel();
        $name = $_POST['name'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $rPassword = $_POST['re-password'];
        $sql = "SELECT * FROM user WHERE email = '$email' AND username = '$username'";
        $querry = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($querry);
        if(empty($name)){
            $err['name'] = 'Bạn chưa nhập tên người dùng';
        }

        if($user != null){
            if($email == $user['email']){
                $err['email'] = 'Email bạn nhập đã được sử dụng để đăng ký';
            }
        }

        if(empty($email)){
            $err['email'] = 'Bạn chưa nhập email';
        }

        if($user != null){
            if($username == $user['username']){
                $err['username'] = 'Tên tài khoản bạn nhập đã được sử dụng để đăng ký';
            }
        }
        if(empty($username)){
            $err['username'] = 'Bạn chưa nhập tên tài khoản';
        }

        if(empty($password)){
            $err['password'] = 'Bạn chưa nhập mật khẩu';
        }
        if(empty($rPassword)){
            $err['rPassword'] = 'Bạn chưa nhập lại mật khẩu';
        }
        if($password != $rPassword){
            $err['err'] = 'Mật khẩu nhập lại không đúng';
        }
        
        if(empty($err)){
            if($userModel->register($name, $email, $username, $password)){
                sleep(3);
                header('Location: ./login.php');
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
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
    <form method="POST">
        <h2 style="padding: 0 0 20px 0; text-align: center">ĐĂNG KÝ</h2>

        <div class="mb-3">
            <label for="" class="form-label">Tên người dùng</label>
            <input name="name" type="text" class="form-control">
            <div class="has-error">
                <span><?php echo isset($err['name']) ? $err['name'] : ''?></span>
            </div>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Email</label>
            <input name="email" type="text" class="form-control">
            <div class="has-error">
                <span><?php echo isset($err['email']) ? $err['email'] : ''?></span>
            </div>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Tài khoản</label>
            <input name="username" type="text" class="form-control">
            <div class="has-error">
                <span><?php echo isset($err['username']) ? $err['username'] : ''?></span>
            </div>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Mật khẩu</label>
            <input name="password" type="password" class="form-control">
            <div class="has-error">
                <span><?php echo isset($err['password']) ? $err['password'] : ''?></span>
            </div>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Nhập lại mật khẩu</label>
            <input name="re-password" type="password" class="form-control">
            <div class="has-error">
                <span><?php echo isset($err['rPassword']) ? $err['rPassword'] : ''?></span>
            </div>
            <div class="has-error">
                <span><?php echo isset($err['err']) ? $err['err'] : ''?></span>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Đăng ký</button>
    </form>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script> 
</body>
</html>