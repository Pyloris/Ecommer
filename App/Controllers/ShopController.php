<?php
require_once __DIR__ . "/../../vendor/autoload.php";

use sirJuni\Framework\View\VIEW;

require_once __DIR__ . "/../Models/models.php";




class ShopController {

    public function show($request) {
        $context = [];

        // get navbar and footer
        ob_start();
        include(VIEW::$path . "/navbar.html");
        $context['navbar'] = ob_get_clean();
        include(VIEW::$path . "/footer.html");
        $context['footer'] = ob_get_clean();

        $db = new DB();
        
        // if query param is set get product accordingly
        if ($request->queryData('category')) {
             $products = $db->getProductsByCategory($request->queryData('category'));
        } 
        else if ($request->queryData('collection')) {
            $products = $db->getProductsByCollection($request->queryData('collection'));
        }
        else {
            $products = $db->getProducts(['%']);
        }

        $context["products"] = $products;

        VIEW::init("shop.html", $context);
    }
}


?>