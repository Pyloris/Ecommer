<?php
require_once __DIR__ . "/../../vendor/autoload.php";

use sirJuni\Framework\View\VIEW;


class HomeController {
    public function show($request) {
        VIEW::init("home.html");
    }
}

?>