<?php
session_start();
require_once('./config/database.php');

spl_autoload_register(function ($className){
    require_once("./app/models/$className.php");
});

    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }

    // action
    if(isset($_GET['action'])){
        $action = $_GET['action'];
    }
    else{
        $action = 'add';
    }

    if(isset($_GET['quantity'])){
        $quantity = $_GET['quantity'];
    }
    else{
        $quantity = 1;
    }

    if($quantity <= 0){
        $quantity = 1;
    }

    $productModel = new ProductModel();
    $product = $productModel->getProductsById($id);
    
    $item =  [
        'id' => $product['id'],
        'name' => $product['product_name'],
        'image' => $product['product_photo'],
        'price' => $product['product_price'],
        'quantity' => $quantity
    ];

    if($action == 'add'){
        if(isset($_SESSION['cart'][$id])){
            $_SESSION['cart'][$id]['quantity']+=1;
        }
        else{
            $_SESSION['cart'][$id] = $item;
        }
    }

    if($action == 'update'){
        $_SESSION['cart'][$id]['quantity'] = $quantity;
    }

    if($action == 'delete'){
        unset($_SESSION['cart'][$id]);
    }

    
    
    header('Location: view-cart.php');
?>