<?php
/**
 * contains properties and methods for "orders" database queries.
 */

class Orders
{
    //db conn and table
    private $conn;
    private $table_name = "orders";

    //object properties
    public $id;
    public $status;
    public $date;
    public $company_id;
    public $fullname;
    public $city;
    public $address;
    public $phone;
    public $phone2;
    public $amount;
    public $shipping_cost;
    public $shipping_type = '1';
    public $shipping_id;
    public $delivery_channel;
    public $weight = 1;
    public $comment;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function insert($status, $company_id, $fullname, $city, $address, $phone, $phone2, $amount,
      $shipping_cost, $shipping_type, $shipping_id, $delivery_channel, $weight, $comment){
        //query insert
        $query = "INSERT INTO ". $this->table_name . "(status, date, company_id, fullname, city, address, phone,
        phone2, amount, shipping_cost, shipping_type, shipping_id, delivery_channel, weight, comment) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        //sanitize
        $this->status=htmlspecialchars(strip_tags($status));
        $this->date=date("Y-m-d H:i:s");
        $this->company_id=$company_id;
        $this->fullname=htmlspecialchars(strip_tags($fullname));
        $this->city=htmlspecialchars(strip_tags($city));
        $this->address=htmlspecialchars(strip_tags($address));
        $this->phone=$phone;
        $this->phone2=$phone2;
        $this->amount=$amount;
        $this->shipping_cost=$shipping_cost;
        $this->shipping_type=$shipping_type;
        $this->shipping_id=$shipping_id;
        $this->delivery_channel=$delivery_channel;
        $this->weight=$weight;
        $this->comment=htmlspecialchars(strip_tags($comment));

        $stmt->bind_Param('ssssssssiisssis', $this->status, $this->date, $this->company_id, $this->fullname,
         $this->city, $this->address, $this->phone, $this->phone2, $this->amount, $this->shipping_cost,
         $this->shipping_type, $this->shipping_id, $this->delivery_channel, $this->weight, $this->comment);

        //execute
        if($stmt->execute()){
            return mysqli_insert_id($this->conn);
        }

        return -1;
    }

}
