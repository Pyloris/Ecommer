<?php
require_once __DIR__ . "/../../vendor/autoload.php";

use sirJuni\Framework\Middleware\Middleware;
use sirJuni\Framework\Helper\HelperFuncs;


class PaymentFlow extends Middleware {

    public static $url = ROOT . "/cart";

    public static function set_fallback_route($route) {
        self::$url = ROOT . $route;
    }

    public static function fallback() {
        HelperFuncs::redirect(self::$url);
    }

    public static function handle($request) {
        if ($request->sessionData('payment_promise')) {
            // means user is coming from cart
            return TRUE;
        }
        else {
            return FALSE;
        }
    }
}