<?php
/**
 * contains properties and methods for "clients" database queries.
 */

class Clients
{
    //db conn and table
    private $conn;
    private $table_name = "clients";

    //object properties
    public $id;
    public $status;
    public $date;
    public $company;
    public $email;
    public $phone;
    public $idnumber;
    public $password;
    public $finances;
    public $edit_product_name;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function insert($status, $company, $email, $phone, $idnumber, $password, $finances, $edit_product_name){
        //query insert
        $query = "INSERT INTO ". $this->table_name . "(status, date, company, email, phone, idnumber, password,
        finances, edit_product_name) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        //sanitize
        $this->status=htmlspecialchars(strip_tags($status));
        $this->date=date("Y-m-d H:i:s");
        $this->company=htmlspecialchars(strip_tags($company));
        $this->email=$email;
        $this->phone=$phone;
        $this->idnumber=$idnumber;
        $this->password=$password;
        $this->finances=$finances;
        $this->edit_product_name=$edit_product_name;

        $stmt->bind_Param('sssssssss', $this->status, $this->date, $this->company, $this->email, $this->phone,
         $this->idnumber, $this->password, $this->finances, $this->edit_product_name);

        //execute
        if($stmt->execute()){
            return mysqli_insert_id($this->conn);
        }

        return -1;
    }

    public function readOne($idnumber){

        //query select
        $query = "SELECT id, password FROM ". $this->table_name . " WHERE idnumber = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_Param('s', $idnumber);

        //execute query
        if($stmt->execute()){
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row;
            }
        }
        return -1;
    }

}
