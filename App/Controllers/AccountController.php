<?php
require_once __DIR__ . "/../../vendor/autoload.php";

use sirJuni\Framework\View\VIEW;

require_once __DIR__ . "/../Models/models.php";


class AccountController {

    public function show($request) {

        // get all of my orders
        $db = new DB();

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

        VIEW::init("user_profile.html", $context);
    }
}

?>