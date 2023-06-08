<?php
    class CartModel extends Model{
        public function getOderByUserId($id){
            $sql=parent::$connection->prepare('SELECT * FROM `oder` INNER JOIN `user` ON `oder`.`user_id` = `user`.`id` WHERE `oder`.`user_id` = ?');
            $sql->bind_param('i', $id);
            return parent::select($sql);
        }

        public function getOderAndUser(){
            $sql = parent::$connection->prepare('SELECT * FROM `oder` INNER JOIN `user` ON `oder`.`user_id` = `user`.`id`;');
            return parent::select($sql);
        }
    }
?>