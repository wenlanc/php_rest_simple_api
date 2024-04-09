<?php
  require_once 'base.php';
  require_once dirname(dirname(__FILE__)) . "/model/Orders.php";
  require_once dirname(dirname(__FILE__)) . "/model/OrderItems.php";
  require_once dirname(dirname(__FILE__)) . "/model/Quantity.php";

  class OrderController extends BASE
  {
    /**
     * Endpoint of an Adding Orders
     */
    public function orders($args){
      if ($this->method == 'POST') {
        if(!$this->checkToken()){
          return array("error" => "User not authorized!");
        }
        try {
          $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : "";
          if(empty($user_id)){
            return array("error" => "User not authorized!");
          }
          $status = isset($_POST['status']) ? $_POST['status'] : "";
          $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : "";
          $city = isset($_POST['city']) ? $_POST['city'] : "";
          $address = isset($_POST['address']) ? $_POST['address'] : "";
          $phone = isset($_POST['phone']) ? $_POST['phone'] : "";
          $phone2 = isset($_POST['phone2']) ? $_POST['phone2'] : "";
          $amount = isset($_POST['amount']) ? $_POST['amount'] : 0;
          $shipping_cost = isset($_POST['shipping_cost']) ? $_POST['shipping_cost'] : 0;
          $shipping_type = isset($_POST['shipping_type']) ? $_POST['shipping_type'] : "";
          $shipping_id = isset($_POST['shipping_id']) ? $_POST['shipping_id'] : "1";
          $delivery_channel = isset($_POST['delivery_channel']) ? $_POST['delivery_channel'] : "";
          $weight = isset($_POST['weight']) ? $_POST['weight'] : 1;
          $comment = isset($_POST['comment']) ? $_POST['comment'] : "";

          if(empty($_POST['numbers']) || empty($_POST['numbers']) || empty($_POST['numbers'])){
            return array("error" => "Select one more product!");
          }

          $numbers = json_decode($_POST['numbers']);
          $names = json_decode($_POST['names']);
          $quantities = json_decode($_POST['quantities']);

          if(!is_array($numbers) || !is_array($names) || !is_array($quantities)){
            return array("error" => "Product informations must be array!");
          }
          $quantityModel = new Quantity();
          foreach($quantities as $index => $quantity){
            $result = $quantityModel->update($numbers[$index], $quantity);
            if(!$result){
              return array("error" => "Can't find this product id(".$numbers[$index].") from product list");
            }
          }

          $order = new Orders();
          $order_id = $order->insert($status, $user_id, $fullname, $city, $address, $phone, $phone2, $amount,
              $shipping_cost, $shipping_type, $shipping_id, $delivery_channel, $weight, $comment);
          if($order_id == -1)
            return array("error" => "Not added this order!");
            
          $orderItems = new OrderItems();
          for ($i = 0; $i < count($names); $i++) {
            $orderItems->insert($user_id, $order_id, $quantities[$i], $numbers[$i], $names[$i]);
          }
          return array("result" => "Order added successfully!");
        } catch (Exception $e) {
          return array("error" => "Not added this order!");
        }
      }
    }
  }

?>