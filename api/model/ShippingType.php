<?php
/**
 * contains properties and methods for "shipping_type" database queries.
 */

class ShippingType
{
    //db conn and table
    private $conn;
    private $table_name = "shipping_type";

    //object properties
    public $id;
    public $name;
    public $color;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function readAll(){
        $query = "SELECT id, name FROM ". $this->table_name;
        $result = mysqli_query($this->conn, $query);
        $res = array();
        while ($row = mysqli_fetch_assoc($result)) {
          $res[] = array("id" => $row['id'], "name" => $row['name']);
        }
        return $res;
    }

}
