<?php
/**
*contains properties and methods for "product" database queries.
 */

class Quantity
{
    //Db connection and table
    private $conn;
    private $table_name = 'quantity';

    //Object properties
    public $id;
    public $date;
    public $company_id;
    public $number;
    public $name;

    //Constructor with db conn
    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function read($user_id){
        $query = "SELECT number, qty FROM ". $this->table_name ." WHERE company_id='".$user_id."'";
        $result = mysqli_query($this->conn, $query);
        $res = array();
        while ($row = mysqli_fetch_assoc($result)) {
          $res[] = array("number" => $row['number'], "qty" => $row['qty']);
        }
        return $res;
    }

    public function readOneWithNumber($number){
        $query = "SELECT * FROM ". $this->table_name ." WHERE number='".$number."'";
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_assoc($result);
        if(empty($row))
            return false;
        return true;
    }

    public function update($number, $quantity){
        if(!$this->readOneWithNumber($number)){
            return false;
        }
        $query = "UPDATE quantity SET qty = qty - '$quantity' WHERE number = '".$number."'";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }

}
