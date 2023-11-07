<?php
require_once __DIR__ . "/../../vendor/autoload.php";

use sirJuni\Framework\Model\Database;

// import all the traits
require_once __DIR__ . "/userModel.php";
require_once __DIR__ . "/productModel.php";

class DB extends Database {
    // use the traits
    use UserDB;
    use ProductDB;

    public function __construct() {
        $this->dbConnect();
    }
}