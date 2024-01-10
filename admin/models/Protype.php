<?php
class Protype extends Model{
    //Viet phuong thuc lay ra tat ca san pham moi nhat
    function getAllProtypes(){
        $sql = parent::$connection->prepare("SELECT * FROM protypes");
        return parent::select($sql); //return an array
    }

    public function getProtypeById($id)
    {
        $sql = parent::$connection->prepare("SELECT * FROM protypes WHERE type_id = ?");
        $sql->bind_param('i', $id);
        return parent::select($sql)[0];
    }

    public function updateProtype($type_name, $type_image, $id)
    {
        $sql = parent::$connection->prepare("UPDATE protypes SET `type_name` = ?, `type_image` = ? WHERE type_id = ?");
        $sql->bind_param('ssi', $type_name, $type_image, $id);
        return $sql->execute();
    }
}