<?php
require_once __DIR__ . "/../../vendor/autoload.php";

use sirJuni\Framework\View\VIEW;

require_once __DIR__ . "/../Models/models.php";

class HomeController {
    public function show($request) {

        $db = new DB();

        // grab all the products
        $products = $db->getProducts(['%']);

        VIEW::init("store/index.html", ['products' => $products]);
    }

}

?>