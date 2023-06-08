<?php
require_once('../config/database.php');
//autoloadding
spl_autoload_register(function ($className) {
    require_once("../app/models/$className.php");
});

$categoryModel = new CategoryModel();
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $categoryItem = $categoryModel->getCategoryById($id);
}
else{
    echo "Bạn vui lòng đăng nhập dưới quyền admin để thực hiện các thao tác này";
    die();
}

if(isset($_POST['name'])){
    $name = $_POST['name'];
    $err = [];
    if(empty($name)){
        $err['name'] = 'Bạn chưa nhập tên danh mục';
    }

    if(empty($err)){
        $categoryModel->updateCategory($name, $id);
        echo "Cập nhật danh mục thành công";
    }
    else{
        echo "Cập nhật danh mục không thành công";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAONANAS - Sửa danh mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="./public/css/main.css">
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
      <a class="navbar-brand" style="font-size: 2rem; text-decoration: none;" href="../index.php">BAONANAS</a>
    </a>
  </div>
</nav>
<div class="container">
    <h2 style="padding: 0 0 20px 0; text-align:center">CẬP NHẬT DANH MỤC NIÊM YẾT</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Tên danh mục</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $categoryItem['category_name']; ?>">
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