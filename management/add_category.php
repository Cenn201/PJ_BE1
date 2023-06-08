<?php
require_once('../config/database.php');
//autoloadding
spl_autoload_register(function ($className) {
    require_once("../app/models/$className.php");
});

$categoryModel = new CategoryModel();

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$conn->set_charset('utf8mb4');
if(isset($_POST['name'])){
    $name = $_POST['name'];
    $err = [];

    if(empty($name)){
        $err['name'] = 'Bạn chưa nhập tên danh mục';
    }


    if(!empty($name)){
        $sql = "SELECT * FROM categories WHERE category_name = '$name'";
        $query = mysqli_query($conn, $sql);
        $checkName = mysqli_num_rows($query);
        if($checkName == 1){
            $err['name'] = 'Tên danh mục này hiện đã có, vui lòng đặt tên danh mục khác';
        }
    }

    if(empty($err)){
        $categoryModel->addCategory($name);
        echo "Thêm danh mục mới thành công";
    }
    else{
        echo "Thêm danh mục mới không thành công";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAONANAS - Thêm danh mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="./public/css/main.css">
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
      <img src="	https://ananas.vn/wp-content/themes/ananas/fe-assets/images/svg/Logo_Ananas_Header.svg" alt="logo" class="img-fluid" style="margin-right: 20px;">
      <a class="navbar-brand" style="font-size: 2rem;" href="../index.php">BAONANAS</a>
    </a>
  </div>
</nav>
<div class="container">
    <h2 style="padding: 0 0 20px 0; text-align: center">THÊM DANH MỤC NIÊM YẾT</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Tên danh mục</label>
            <input type="text" class="form-control" id="name" name="name">
            <div class="has-error">
                <span><?php echo isset($err['name']) ? $err['name'] : ''?></span>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Xác nhận</button>
  </div>
</form>
    </div>
</body>
</html>