<?php
class Model
{
    //Bước 2: Tạo connection
    public static $connection = null;
    public function __construct()
    {
        //$this//tro toi thuc the thuc su
        //self//thuoc tinh static thi dung self
        if(!self::$connection)
        {
            self::$connection=new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            self::$connection->set_charset('utf8mb4');
        }
        return self::$connection;
    }
    
    //Thuc thi cau select va xu li ket qua
    public function select($sql)
    {
        $item=[]; //chua ket qua tra ve
        $sql->execute();//thu thi cau sql
        $item=$sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $item;
    }
}
?>