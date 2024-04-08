<?php
  require_once 'base.php';
  require_once dirname(dirname(__FILE__)) . "/model/Quantity.php";

  class QuantityController extends BASE
  {
    public function quantities(){
      if(!$this->checkToken()){
        return array("error" => "User not authorized!");
      }
      if ($this->method == 'GET') {
        global $conn;
        $user_id = $_GET['user_id'];
        $model = new Quantity($conn);
        $result = $model->read($user_id);
        return $result;
      }
    }
  }

?>