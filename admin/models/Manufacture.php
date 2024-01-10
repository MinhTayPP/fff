<?php
class Manufacture extends Model{
    //Viet phuong thuc lay ra tat ca san pham moi nhat
    function getAllManu(){
        $sql = parent::$connection->prepare("SELECT * FROM manufactures");
        return parent::select($sql); //return an array
    }

    public function getManuById($id)
    {
        $sql = parent::$connection->prepare("SELECT * FROM manufactures WHERE manu_id = ?");
        $sql->bind_param('i', $id);
        return parent::select($sql)[0];
    }

    public function updateManu($manu_name, $manu_image, $id)
    {
        $sql = parent::$connection->prepare("UPDATE manufactures SET `manu_name` = ?, `manu_image` = ? WHERE manu_id = ?");
        $sql->bind_param('ssi', $manu_name, $manu_image, $id);
        return $sql->execute();
    }
}