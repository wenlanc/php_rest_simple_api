<?php
  require_once 'base.php';
  require_once dirname(dirname(__FILE__)) . "/model/ShippingType.php";
  
  class ShippingController extends BASE
  {
    public function shippingtypes(){
      if ($this->method == 'GET') {
        global $conn;
        $model = new ShippingType($conn);
        $result = $model->readAll();
        return $result;
      }
    }
  }

?>