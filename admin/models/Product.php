<?php
class Product extends Model{
    //Viet phuong thuc lay ra tat ca san pham moi nhat
    // function getAllProducts($page, $perpage){
    //     $start = ($page - 1) * $perpage;
    //     $sql = parent::$connection->prepare("SELECT * FROM products,manufactures,protypes 
    //     WHERE products.manu_id = manufactures.manu_id
    //     AND products.type_id = protypes.type_id
    //     ORDER BY id DESC
    //     LIMIT ?, ?");
    //     $sql->bind_param('ii', $start, $perpage);
    //     return parent::select($sql); //return an array
    // }
    function getAllProducts(){
        $sql = parent::$connection->prepare("SELECT * FROM products,manufactures,protypes 
        WHERE products.manu_id = manufactures.manu_id
        AND products.type_id = protypes.type_id
        ORDER BY id DESC");
        return parent::select($sql); //return an array
    }

    function getTotalAllProducts(){
        $sql = parent::$connection->prepare("SELECT count(products.id) as total_product FROM products,manufactures,protypes 
        WHERE products.manu_id = manufactures.manu_id
        AND products.type_id = protypes.type_id
        ORDER BY id DESC");
        return parent::select($sql)[0]['total_product']; //return an array
    }
    
    public function insertProduct($name, $manu_id, $type_id, $description, $price, $feature, $pro_image)
    {
        $sql = parent::$connection->prepare("INSERT INTO `products`
        (`name`, `manu_id`, `type_id`, `description`, `price`, `feature`, `pro_image`) VALUES(?, ?, ?, ?, ?, ?, ?)");
        $sql->bind_param('siisiis', $name, $manu_id, $type_id, $description, $price, $feature, $pro_image);
        return $sql->execute();
    }

    function getTotalFindProducts($findName){
        $sql = parent::$connection->prepare("SELECT count(products.id) as total_product FROM products,manufactures,protypes 
        WHERE products.manu_id = manufactures.manu_id
        AND products.type_id = protypes.type_id
        AND products.name LIKE ?
        ORDER BY id DESC");
        $findName = "%$findName%";
        $sql->bind_param('s', $findName);
        return parent::select($sql)[0]['total_product']; //return an array
    }

    function getFindProducts($page, $perpage, $findName){
        $start = ($page - 1) * $perpage;
        $sql = parent::$connection->prepare("SELECT * FROM products,manufactures,protypes 
        WHERE products.manu_id = manufactures.manu_id
        AND products.type_id = protypes.type_id
        AND products.name LIKE ?
        ORDER BY id DESC LIMIT ?, ?");
        $findName = "%$findName%";
        $sql->bind_param('sii', $findName, $start, $perpage);
        return parent::select($sql); //return an array
    }
}