<?php
class ProductModel extends Model
{
    // Lấy danh sách sản phẩm
    public function getProducts()
    {
        $sql=parent::$connection->prepare('SELECT * FROM products');
        return parent::select($sql);
    }

    public function getProductsByPage($page, $perPage){
        $start = ($page - 1) * $perPage;
        $sql=parent::$connection->prepare('SELECT * FROM products LIMIT ?, ?');
        $sql->bind_param('ii',$start, $perPage);
        return parent::select($sql);
    }

    public function getTotalProduct(){
        $sql=parent::$connection->prepare('SELECT COUNT(id) AS total_product FROM `products`');
        return parent::select($sql)[0]['total_product'];
    }

    // Lấy sản phẩm theo ID
    public function getProductsById($id)
    {
        # code...
        $sql=parent::$connection->prepare('SELECT * FROM products WHERE id =?');
        $sql->bind_param('i',$id);
        return parent::select($sql)[0];
    }

    // Lấy sản phẩm theo nhiều ID
    public function getProductByIds($lstID){
        $msg = str_repeat('?, ', count($lstID) -1);
        $msg .= '?';

        $i = str_repeat('i', count($lstID));

        $sql = parent::$connection->prepare("SELECT * FROM products WHERE id IN($msg) ORDER BY FIELD(id, $msg)");
        $sql->bind_param($i . $i, ...$lstID, ...$lstID);
        return parent::select($sql);
    }

    // Lấy sản phẩm theo category_id
    public function getProductsByCategory($id)
    {
        $sql=parent::$connection->prepare('SELECT * 
        FROM `products_categories`  
        INNER JOIN products
        ON products_categories.product_id=products.id
        WHERE `category_id`=?');
        $sql->bind_param('i',$id);
        return parent::select($sql);
    }

    // Lấy sản phẩm theo keyword
    public function getSearchProduct($string)
    {
        $string ="%$string%";
        $sql=parent::$connection->prepare("SELECT * FROM `products`WHERE product_name LIKE ?");
        $sql->bind_param("s",$string);
        return parent::select($sql);
    }

    public function getSearchProductByProductCode($string){
        $string = "%$string%";
        $sql = parent::$connection->prepare("SELECT * FROM `products` WHERE product_code LIKE ?");
        $sql->bind_param("s", $string);
        return parent::select($sql);
    }

    // Thêm sản phẩm
    public function addProduct($productName, $productDescription, $productPrice, $productPhoto, $productCode, $productStatus){
        $sql = parent::$connection->prepare('INSERT INTO `products`(`product_name`, `product_description`, `product_price`, `product_photo`, `product_code`, `product_status`) VALUES(?,?,?,?,?,?)');     
        $sql->bind_param('ssisss', $productName, $productDescription, $productPrice, $productPhoto, $productCode, $productStatus);
        return $sql->execute();
    }
    
    // Cập nhật sản phẩm
    public function updateProduct($productName, $productDescription, $productPrice, $productPhoto, $productCode, $productStatus , $id){
        $sql = parent::$connection->prepare('UPDATE `products` SET `product_name`= ?, `product_description`= ?,`product_price`= ?, `product_photo`= ?, `product_code`= ?, `product_status` = ? WHERE `id` = ?');
        $sql->bind_param('ssisssi', $productName, $productDescription, $productPrice, $productPhoto, $productCode, $productStatus, $id);
        return $sql->execute();
    }

    // Xoá sản phẩm
    public function deleteProduct($id){
        $sql=parent::$connection->prepare('DELETE FROM `products` WHERE `id` = ?');
        $sql->bind_param('i', $id);
        return $sql->execute();
    }
    
    // Xem sản phẩm
    public function viewProduct($id){
        $sql = parent::$connection->prepare('UPDATE `products` SET `product_view` = `product_view` + 1 WHERE `id` = ?');
        $sql->bind_param('i', $id);
        return $sql->execute();
    }

    // Thích sản phẩm
    public function likeProductNoLogin($id){
        $sql=parent::$connection->prepare('UPDATE `products` SET `product_like` = `product_like` + 1 WHERE `id` =?');
        $sql->bind_param('i',  $id);
        return $sql->execute();
    }

    // đéo thích sản phẩm
    public function unlikeProductNoLogin($id){
        $sql=parent::$connection->prepare('UPDATE `products` SET `product_like` = `product_like` - 1 WHERE `id` =?');
        $sql->bind_param('i',  $id);
        return $sql->execute();
    }

    public function likeProductWithUser($productId, $userId){
        $sql = parent::$connection->prepare('INSERT INTO `products_users`(`product_id`, `user_id`) VALUES (?,?)');
        $sql->bind_param('i,i', $productId, $userId);
        
    }
}
