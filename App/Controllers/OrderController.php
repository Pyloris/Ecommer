<?php
require_once __DIR__ . "/../../vendor/autoload.php";

use sirJuni\Framework\View\VIEW;
use sirJuni\Framework\Helper\HelperFuncs;
use sirJuni\Framework\Components\PaymentGateway;


require_once __DIR__ . "/../Models/models.php";


class OrderController {
    public function cartHandler($request) {
        // perform cleanup
        require_once __DIR__ . "/../Helpers/dbCleanup.php";
        cleanDB();

        $context = [];


        $db = new DB();
        ob_start();
        include(VIEW::$path . "/navbar.html");
        $context['navbar'] = ob_get_clean();

        ob_start();
        include(VIEW::$path . "/footer.html");
        $context['footer'] = ob_get_clean(); 
        
        
        $_SESSION['payment_promise'] = TRUE;


        if ($request->method() == "GET") {

            // grab all the products
            $product_ids = $db->getCartItems($_SESSION['id']);

            $products = [];
            // grab products
            // $id is a row ['product_id' => id]
            foreach ($product_ids as $id) {
                $products[] = $db->getProduct($id['product_id']);
            }

            $context["products"] = $products;
    
            // get all the categories
            $context["categories"] = $db->getCategories(); 

            VIEW::init("store/your_cart.html", $context);
        }

        else if ($request->method() == "POST") {

            if (!$request->formData('product_id')) {
                HelperFuncs::redirect(ROOT . "/?error=no product id provided");
                exit();
            }

            // add the product to the cart
            if ($request->formData('action') == "addToCart" and $db->addToCart($_SESSION['id'], $request->formData('product_id'))) {
                HelperFuncs::redirect(ROOT . "/product?id=" . $request->formData('product_id'));
            }
            else if ($request->formData('action') == "buyNow" and $db->addToBuyNowCart($_SESSION['id'], $request->formData('product_id'))) {
                // add the product to buynow_cart
                HelperFuncs::redirect(ROOT . "/store/payment?action=buyNow");
            }
        }
    }

    public function deleteCart($request) {
        if (!$request->formData('product_id')) {
            HelperFuncs::redirect(ROOT . "/cart");
            exit();
        }

        $product_id = $request->formData('product_id');

        // check if it is an integer
        if (preg_match("/^[0-9]+$/", $product_id)) {

            // remove this product from the cart
            $db = new DB();

            if ($db->removeCartItem($_SESSION['id'], $product_id)) {
                echo(" success");
            }
            else {
                echo("failure");
            }
            exit();
        }
        else {
            echo("wrong product id");
        }
    }


    public function createOrder($request) {
        $context = [];

        ob_start();
        include(VIEW::$path . "/navbar.html");
        $context['navbar'] = ob_get_clean();

        ob_start();
        include(VIEW::$path . "/footer.html");
        $context['footer'] = ob_get_clean();

        // unset the payment promise
        unset($_SESSION['payment_promise']);

        $gateway = new PaymentGateway(RZP_ID, RZP_SECRET);

        // create an order in orders table
        // store items in order_items table
        $db = new DB();

        // get all the necessary order data
        // an order is always generated from the cart items
        if ($request->queryData('action') == "buyNow")
            $items = $db->getBuyNowCartItem($_SESSION['id']);
        else
            $items = $db->getCartItems($_SESSION['id']);

        $amount = 0.0;
        $products = [];

        
        foreach($items as $item) {
            $product = $db->getProduct($item['product_id']);
            $products[] = $product;
            $amount += (float) $product['SP'];
        }

        $context["products"] = $products;

        $order_data = [
            'amount' => strval($amount) . '00', // in paise
            'currency' => "INR"
        ];

        // before creating another order, remove the pending orders from current user
        // $db->removePendingOrders($_SESSION['id']);
        
        // create an order with the details given
        $order = $gateway->order($order_data);

        // get the order id and store it in the SESSION
        $_SESSION['order_id'] = $order['id'];

        // insert the order into the database
        $db->storeOrder($_SESSION['id'], $order['id'], $amount);

        // insert order items
        foreach($items as $item) {
            $db->storeOrderItem($order['id'], $item['product_id']);
        }

        // SCRIPT CONTEXT 
        $data = [
            'API_KEY' => RZP_ID,
            'price' => $order['amount'],
            'COMPANY_NAME' => COMPANY_NAME,
            'COMPANY_LOGO_URL' => COMPANY_LOGO_URL,
            'order_id' => $order['id'],
            'success_callback_url' => SUCCESS_CALLBK,
            'username' => $_SESSION['first_name'] . ' ' . $_SESSION['last_name'],
            'email' => $_SESSION['email'],
            'phone' => $_SESSION['phone'],
            'failure_callback_url' => FAILURE_CALLBK
        ];

        $context["code"] = $gateway->getIntegrationCode($data);

        // get user details (address, pin etc)
        $context["user_details"] = $db->getUserDetails($_SESSION['id']);
    
        // view the payment page
        VIEW::init("payment_gateway.html", $context);
    }


    public function payment_success($request) {
        VIEW::init("order_confirm.html");
    }

    public function payment_failure($request) {
        VIEW::init("payment_fail.html");
    }
}

?>