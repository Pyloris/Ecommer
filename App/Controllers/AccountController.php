<?php
require_once __DIR__ . "/../../vendor/autoload.php";

use sirJuni\Framework\View\VIEW;
use sirJuni\Framework\Middleware\Auth;

require_once __DIR__ . "/../Models/models.php";


class AccountController {

    public function show($request) {
        // get all of my orders
        $db = new DB();

        // for POST request
        if ($request->method() == "POST") {

            // get the param being updated
            $param = $request->formKeys();
            
            // check if param is a single field or array
            if (is_array($param)) {

                $valid_cols = ['username', 'first_name', 'last_name', 'email', 'password', 'phone'];
                $valid_addr_cols = ['street', 'country', 'pin', 'state', 'city'];

                $personalDetails = [];
                $addressDetails = [];
                
                // CHECK IF keys are valid columns
                foreach($param as $idx => $key) {
                    
                    // if key is in valid cols
                    if (in_array($key, $valid_cols)){
                        $personalDetails[$key] = $request->formData($key);
                    }
                    else if (in_array($key, $valid_addr_cols)){
                        $addressDetails[$key] = $request->formData($key);
                    }
                    else {
                        header("Location: " . ROOT . "/account?problem=wrong_keys_supplied $key.");
                        exit();
                    }
                }

                if (!empty($personalDetails) and !empty($addressDetails)) {
                    $updates_ok = $db->updateAddressDetails($addressDetails, $_SESSION['id']) and $db->updatePersonalDetails($personalDetails, $_SESSION['id']);
                }
                else if (!empty($personalDetails)) {
                    $updates_ok = $db->updatePersonalDetails($personalDetails, $_SESSION['id']);
                }
                else if (!empty($addressDetails)) {
                    $updates_ok = $db->updateAddressDetails($personalDetails, $_SESSION['id']);
                }

                // if updates happened
                if ($updates_ok) {
                    // update session
                    $user = $db->getUser($request->sessionData('email'), NULL);
                    Auth::login($user);

                    header("Location: " . ROOT . "/account");
                    exit(); 
                }

                header("Location: " . ROOT . "/account?problem=Failure in updating details");
            }

            header("Location: " . ROOT . "/account?singlekey=1");
        }

        else if ($request->method() == "GET") {

            // get all orders
            $orders = $db->getOrders($_SESSION['id']);

            // get all ordered items
            $items = [];
            foreach($orders as $order) {
                $items[] = $db->getOrderItems($order['id']);
            }
        
            $products = [];
            // get product details for each item
            foreach($items as $item) {
                foreach($item as $product) {
                    $products[] = $db->getProduct($product['product_id'], NULL);
                }
            }

            $context = [];
            $context["orders"] = $products;

            // get user details (address, pin etc)
            $context["user_details"] = $db->getUserDetails($_SESSION['id']);

            VIEW::init("user_profile.html", $context);
        }
    }
}

?>