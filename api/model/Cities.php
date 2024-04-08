<?php
/**
 * contains properties and methods for "cities" database queries.
 */

class Cities
{
    //db conn and table
    private $conn;
    private $table_name = "cities";

    //object properties
    public $id;
    public $name;
    public $name_en;
    public $shipping_cost;
    public $status;
    public $position;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function readAll(){
        $query = "SELECT id, name_en, name FROM ". $this->table_name;
        $result = mysqli_query($this->conn, $query);
        $res = array();
        while ($row = mysqli_fetch_assoc($result)) {
          $res[] = array("id" =>$row['id'], "name" => $row['name'], "name_en" => $row['name_en']);
        }
        return $res;
    }
}
