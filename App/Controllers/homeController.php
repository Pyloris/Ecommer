<?php
require_once __DIR__ . "/../../vendor/autoload.php";

use sirJuni\Framework\View\VIEW;

require_once __DIR__ . "/../Models/models.php";

class HomeController {
    public function show($request) {

        $context = []; 

        ob_start();
        include(VIEW::$path . "/navbar.html");
        $context["navbar"] = ob_get_clean();

        ob_start();
        include(VIEW::$path . "/footer.html");
        $context["footer"] = ob_get_clean();

        $db = new DB();

        // grab all the products
        $context["products"] = $db->getProducts(['%']);
        
        $context["categories"] = $db->getCategories();

        $context['collections'] = $db->getCollections(8);

        VIEW::init("home.html", $context);
    }

}

?>