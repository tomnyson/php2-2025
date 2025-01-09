<?php 
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    class Product{

        private $id;
        private $name;
        private $price;

        public function __construct($id, $name, $price){
            $this->id = $id;
            $this->name = $name;
            $this->price = $price;
        }
        public function xuatThongTin(){
            echo 'id: '. $this->id.'<br>';
            echo 'name: '. $this->name.'<br>';
            echo 'price: '. $this->price.'<br>';
        }
        public function getPrice(){
            return $this->price;
        }
        public function getId(){
            return $this->id;
        }
        public function getName(){
            return $this->name;
        }
        public function setName ($name) {
            $this->name =  $name ; 
        }
        public function setId ($id){
            $this->id = $id ; 
        }
        public function setPrice ($price){
            if(!is_numberic($price) || $price <0 ){
                    $this->price = 0;
            }else{
                $this->price = $price;
            }
        }
    }
    // $apple = new Product (1,'ao',200);
    // $apple-> xuatThongTin();
    /**
     * so ghe
     
     * so khung
     * so may
     * bien so
     * mau
     * hang
     * 
     */
    
    class CarProduct extends Product {
    private $soghe;
    private $somay;
    private $sokhung;
    private $bienso;
    private $hang;
    private $mau;
    
    public function __construct($id, $name, $price, $soghe, $somay, $sokhung, $hang, $mau){
        parent::__construct($id, $name, $price);
        $this->soghe= $soghe;
        $this->somay= $somay;
        $this->sokhung = $sokhung;
        $this->hang= $hang;
        $this->mau= $mau;
    } 
    }
    


    /**
     * hang
     * mau
     * kich_co
     * chat lieu
     */

    class ClotherProduct extends Product  {
    private $hang;
    private $mau;
    private $kichco;
    private $chatlieu
    }
?>