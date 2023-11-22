<?php
require_once __DIR__ . "/../../vendor/autoload.php";

use sirJuni\Framework\Model\Database;

// import all the traits
require_once __DIR__ . "/userModel.php";
require_once __DIR__ . "/productModel.php";
require_once __DIR__ . "/stockModel.php";
require_once __DIR__ . "/orderModel.php";
require_once __DIR__ . "/adminModel.php";


class DB extends Database {
    // use the traits
    use UserDB;
    use ProductDB;
    use stockDB;
    use OrderDB;
    use adminDB;

    public function __construct() {
        $this->dbConnect();
    }
}