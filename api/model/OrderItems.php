<?php
/**
 * contains properties and methods for "order_items" database queries.
 */

class OrderItems
{
    //db conn and table
    private $conn;
    private $table_name = "order_items";

    //object properties
    public $id;
    public $company_id;
    public $order_id;
    public $quantity;
    public $number;
    public $name;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function insert($company_id, $order_id, $quantity, $number, $name){
        //query insert
        $query = "INSERT INTO ". $this->table_name . "(company_id, order_id, quantity, number, name) 
        VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        //sanitize
        $this->company_id=$company_id;
        $this->order_id=$order_id;
        $this->quantity=$quantity;
        $this->number=$number;
        $this->name=htmlspecialchars(strip_tags($name));

        $stmt->bind_Param('sssss', $this->company_id, $this->order_id, $this->quantity, $this->number, $this->name);

        //execute
        if($stmt->execute()){
            return mysqli_insert_id($this->conn);
        }

        return -1;
    }

}
