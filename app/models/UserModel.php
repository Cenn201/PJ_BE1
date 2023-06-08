<?php
class UserModel extends Model{
    public function register($name, $email, $username, $password){
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = parent::$connection->prepare('INSERT INTO `user`(`name`, `email`, `username`, `password`) VALUES (?, ?, ?, ?)');
        $sql->bind_param('ssss', $name, $email, $username, $password);
        return $sql->execute();
    }

    public function changePassword($password, $email){
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = parent::$connection->prepare('UPDATE `user` SET `password` = ? WHERE `email` = ?');
        $sql->bind_param('ss', $password, $email);
        return $sql->execute();
    }

    public function getListUser(){
        $sql = parent::$connection->prepare('SELECT * FROM `user` WHERE `username` != "admin"');
        return parent::select($sql);
    }

    public function getUserById($id){
        $sql = parent::$connection->prepare('SELECT * FROM `user` WHERE `id` = ?');
        $sql->bind_param('i', $id);
        return parent::select($sql)[0];
    }

    public function updateUser($name, $email, $id){
        $sql = parent::$connection->prepare('UPDATE `user` SET `name` = ?, `email` = ?  WHERE `id` = ?');
        $sql->bind_param('ssi', $name, $email, $id);
        return $sql->execute();
    }

    public function deleteUser($id){
        $sql = parent::$connection->prepare('DELETE FROM `user` WHERE `id` = ?');
        $sql->bind_param('i', $id);
        return $sql->execute();
    }
}
?>