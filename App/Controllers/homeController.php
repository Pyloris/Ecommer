<?php
require_once __DIR__ . "/../../vendor/autoload.php";

use sirJuni\Framework\View\VIEW;

require_once __DIR__ . "/../Models/models.php";

class HomeController {
    public function show($request) {

        $context = [];

        // get footer and navbar
        ob_start();
        include(VIEW::$path . "/navbar.html");
        $context["navbar"] = ob_get_clean();
        include(VIEW::$path . "/footer.html");
        $context["footer"] = ob_get_clean();

        $db = new DB();

        // grab all the products
        $context["products"] = $db->getProducts(['%']);
        
        $context["categories"] = $db->getCategories();

        VIEW::init("home.html", $context);
    }

}

?>