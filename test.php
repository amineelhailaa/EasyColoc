<?php



class Product {
    static public $id=0;
    private $name;
    private $price;
    public function __construct($name,$price){
        $this->name = $name;
        $this->price = $price;
        self::$id++;
    }

    //getters
    public function getName(){
        return $this->name;
    }
    public function getPrice(){
        return $this->price;
    }


    public function getPriceFloor(){ //1.99
        return $this->price."$";
    }

    static  function getId(){
        return self::$id;
    }


    //setters
    public function setName($name){
        $this->name = $name;

}

public function setPrice($price){
        $this->price = $price;
}


}







$product1 = new Product('mouse',10);
$product2 = new Product('keyboard',10);

echo Product::getId();

echo "asdfa";
