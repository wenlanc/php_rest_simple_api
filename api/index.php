<?php
    if(empty($_REQUEST['request'])) {
        echo 'Hey! You just got 404\'D. Did you just come up with that url by your own?';
        return header("HTTP/1.1 404 Not Found");
    }

    // Requests from the same server don't have a HTTP_ORIGIN header
    if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
        $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
    }

    require_once "utils/db.php";
    require_once "utils/route.php";

    try {
        $request = $_REQUEST['request'];

        $strArray = explode('/', $request);
        switch($strArray[1]) {
            case 'login':
            case 'register':
                $API = new UserController($request);
                echo $API->processAPI();
                break;

            case 'cities':
                $API = new CityController($request);
                echo $API->processAPI();
                break;
    
            case 'shippingtypes':
                $API = new ShippingController($request);
                echo $API->processAPI();
                break;

            case 'products':
                $API = new ProductController($request);
                echo $API->processAPI();
                break;

            case 'quantities':
                $API = new QuantityController($request);
                echo $API->processAPI();
                break;

            case 'orders':
                $API = new OrderController($request);
                echo $API->processAPI();
                break;

            default:
                header("HTTP/1.1 404 Not Found");
                return json_encode("No route found!");
        }
    } catch (Exception $e) {
        echo json_encode(array('error' => $e->getMessage()));
    }
?>