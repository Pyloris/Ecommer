<?php

require_once __DIR__ . "/../Models/models.php";

function cleanDB() {
    // if user is logged, only then perform cleanup
    if (!isset($_SESSION['id']))
        exit();


    $db = new DB();

    // clean pending orders
    $db->removePendingOrders($_SESSION['id']);

    // clean the buynow_cart
    $db->cleanBuyNowCart($_SESSION['id']);
}

?>