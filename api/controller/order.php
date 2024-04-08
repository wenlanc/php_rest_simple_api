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
          $user_id = $_POST['user_id'];
          $status = $_POST['status'];
          $fullname = $_POST['fullname'];
          $city = $_POST['city'];
          $address = $_POST['address'];
          $phone = $_POST['phone'];
          $phone2 = $_POST['phone2'];
          $amount = $_POST['amount'];
          $shipping_cost = $_POST['shipping_cost'];
          $shipping_type = empty($_POST['shipping_type']) ? "1": $_POST['shipping_type'];
          $shipping_id = $_POST['shipping_id'];
          $delivery_channel = $_POST['delivery_channel'];
          $weight = empty($_POST['weight']) ? 1 :$_POST['weight'];
          $comment = $_POST['comment'];

          $numbers = $_POST['numbers'];
          $names = $_POST['names'];
          $quantities = $_POST['quantities'];

          $quantityModel = new Quantity();
          foreach($quantities as $index => $quantity){
            $quantityModel->update($numbers[$index], $quantity);
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