<?php
    session_start();
    require_once ('../config/database.php');

    spl_autoload_register(function($className){
        require_once ("../app/models/$className.php");
    });

    // viết connection trong file vì gọi connection ngoài bị lỗi
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $connection->set_charset('utf8mb4');

    if(isset($_POST['username'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $err = [];
        // kiểm tra xem có username trong database hay không?
        $sql = "SELECT * FROM user WHERE username = '$username'";
        $querry = mysqli_query($connection, $sql);
        $data = mysqli_fetch_assoc($querry); // dữ liệu của row 
        $checkUsername = mysqli_num_rows($querry); // kiểm tra xem row username có trong database hay không nếu có trả về 1 không có trả về 0
        
        if($checkUsername == 1){
            $checkPass = password_verify($password, $data['password']);
            if($checkPass == true){
                // lưu vào session 
                $_SESSION['user'] = $data; // tạo session user
                if(isset($_GET['action'])){ 
                    $action = $_GET['action'];
                    header('Location: '. '../'.$action.'.php');
                }else{
                    header('Location: ../index.php');
                }
            }
            else{
                $err['password'] = 'Sai mật khẩu';
            }
        }
        else{
            $err['username'] = 'Tài khoản không tồn tại';
            if($username == ''){
                $err['username'] ='Bạn chưa nhập tài khoản';
            }
        }
        if($password == ''){
            $err['password'] = 'Bạn chưa nhập mật khẩu';
        }
        if($username == 'admin'){
            header('Location: ../management_shop.php');
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <style>
        .item-link{
            color: black;
            text-decoration: none;
        }

        .item-link:hover{
            color: #f15e2c;
        }

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
        <h2 style="padding: 0 0 20px 0; text-align: center">ĐĂNG NHẬP</h2>
        <div class="mb-3">
            <label for="" class="form-label">Tài khoản</label>
            <input name="username" type="text" class="form-control" id="exampleInputEmail1">
            <div class="has-error">
                <span><?php echo isset($err['username']) ? $err['username'] : ''?></span>
            </div>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Mật khẩu</label>
            <input name="password" type="password" class="form-control" id="exampleInputPassword1">
            <div class="has-error">
                <span><?php echo isset($err['password']) ? $err['password'] : ''?></span>
            </div>
        </div>
        <div class="mb-3" style="float: right;">
            <a class="item-link" href="./forgot_password.php">Quên mật khẩu</a>
        </div>
        <div class="mb-3" >
            <span>Bạn chưa có tài khoản? </span> <a class="item-link" href="./register.php"> Đăng ký</a>
        </div>
        <button type="submit" class="btn btn-primary">Đăng nhập</button>
    </form>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script> 
</body>
</html>