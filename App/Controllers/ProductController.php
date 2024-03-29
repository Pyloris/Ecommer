<?php
require_once __DIR__ . "/../../vendor/autoload.php";

use sirJuni\Framework\View\VIEW;
use sirJuni\Framework\Helper\HelperFuncs;

require_once __DIR__ . "/../Models/models.php";



class ProductController {

    public function show($request) {

        // get footer and navbar
        $context = [];
        ob_start();
        include(VIEW::$path . "/navbar.html");
        $context["navbar"] = ob_get_clean();

        ob_start();
        include(VIEW::$path . "/footer.html");
        $context["footer"] = ob_get_clean();

        // get the product id
        $id = $request->queryData('id');

        // if id is not set, redirect to home
        if (!$id) {
            HelperFuncs::redirect(ROOT . "/");
            exit();
        }

        $db = new DB();
        
        // get the product details
        $product = $db->getProduct($id, NULL);

        // get similar products based on category, collection and flag
        $similarProducts = [];
        $similarProducts[] = $db->getRelatedProducts($product['id'], $product['name'], $product['category'], $product['collection']);

        $context['product'] = $product;
        $context['similar_products'] = $similarProducts;
        $context['collection'] = $db->getCollection($product['collection']);
        if (!$context['collection'])
            $context['collection'] = ['name' => ''];


        VIEW::init("product_details.html", $context);
    }
}


?>