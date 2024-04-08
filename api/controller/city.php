<?php
  require_once 'base.php';
  require_once "model/Cities.php";
  
  class CityController extends BASE
  {
    /**
     * Endpoint of an Cities
     * @method GET
     * @return lists of cities with id, name_en, name
     */
    public function cities(){
      if($this->method == 'GET') {
        $model = new Cities();
        $result = $model->readAll();
        return $result;
      }
    }
  }
?>