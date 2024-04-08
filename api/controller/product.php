<?php
    require_once 'base.php';
    require_once dirname(dirname(__FILE__)) . "/model/Product.php";

    class ProductController extends BASE
    {
        /**
         * Endpoint of an Products
         */
        protected function products($args, $file) {
            if(!$this->checkToken()){
                return array("error" => "User not authorized!");
            }

            if ($this->method == 'GET') {
                $user_id = $_GET['user_id'];
                $model = new Product();
                $result = $model->read($user_id);
                return $result;
            }
        }
     }
?>