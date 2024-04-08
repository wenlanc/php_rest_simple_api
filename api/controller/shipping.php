<?php
  require_once 'base.php';
  require_once dirname(dirname(__FILE__)) . "/model/ShippingType.php";
  
  class ShippingController extends BASE
  {
    public function shippingtypes(){
      if ($this->method == 'GET') {
        $model = new ShippingType();
        $result = $model->readAll();
        return $result;
      }
    }
  }

?>