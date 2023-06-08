<?php
require_once('./config/database.php');
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $conn->set_charset('utf8mb4');
    $msg = '';
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $sql = "SELECT * FROM `oder` WHERE `oder_id` = '$id';";
        $querry = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($querry);
        if($data['status'] == 0){
            $sql = "UPDATE `oder` SET `status`='4' WHERE `oder_id` = '$id';";
            $querry = mysqli_query($conn, $sql);
            $msg =  "Huỷ đơn hàng thành công!";
        }
        else{
            $msg = "Huỷ đơn hàng không thành công, vui lòng liên hệ hotline 19008668 để được hỗ trợ";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Huỷ đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>
<body>
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
        <div class="msg" style="padding: 20px; background-color: #fff; border-radius: 10px;">
            <h4 style="text-align: center;"><?php echo $msg ?></h4>
        </div>
        <a href="./order.php" style="float:right; margin-top: 10px" class="btn btn-success">QUAY LẠI</a>
    </div>
</body>
</html>