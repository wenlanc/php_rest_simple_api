<?php
/**
*contains properties and methods for "product" database queries.
 */

class Product
{
    //Db connection and table
    private $conn;
    private $table_name = 'products';

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
        //select products by user id
        $query = "SELECT number, name FROM ". $this->table_name ." WHERE company_id='".$user_id."'";
        $result = mysqli_query($this->conn, $query);

        $res = array();
        while ($row = mysqli_fetch_assoc($result)) {
          $res[] = array("number" => $row['number'], "name" => $row['name']);
        }
        return $res;
    }

}
