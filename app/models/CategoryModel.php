<?php
class CategoryModel extends Model
{
    public function getAllCategories()
    {
        $sql=parent::$connection->prepare('SELECT * FROM categories');
        return parent::select($sql);
    }
    
    public function getCategoryById($id)
    {
        $sql=parent::$connection->prepare('SELECT * FROM categories WHERE id = ?');
        $sql->bind_param('i', $id);
        return parent::select($sql)[0];
    }

    public function addCategoryProduct($product_id, $category_id){
        $sql=parent::$connection->prepare('INSERT INTO `products_categories`(`product_id`, `category_id`) VALUES (?, ?)');
        $sql->bind_param('ii',$product_id, $category_id);
        return $sql->execute();
    }

    public function addCategory($category_name)
    {
        $sql = parent::$connection->prepare('INSERT INTO `categories`(`category_name`) VALUES(?)'); 
        $sql->bind_param('s', $category_name);
        return $sql->execute();
    }

    public function updateCategory($category_name, $id)
    {
        $sql=parent::$connection->prepare('UPDATE `categories` SET `category_name`= ? WHERE `id` = ?');
        $sql->bind_param('si', $category_name, $id);
        return $sql->execute();
    }

    public function deleteCategory($id)
    {
        $sql=parent::$connection->prepare('DELETE FROM `categories` WHERE `id` =?');
        $sql->bind_param('i', $id);
        return $sql->execute();
    }
}   
