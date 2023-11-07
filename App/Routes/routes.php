<?php
require_once __DIR__ . "/../../vendor/autoload.php";


use sirJuni\Framework\Handler\Router;
use sirJuni\Framework\Middleware\Auth;


// load all the controllers
require_once __DIR__ . "/../Controllers/authController.php";
require_once __DIR__ . "/../Controllers/homeController.php";


// set the fallback route for Auth middleware
Auth::set_fallback_route(ROOT."/login");

/*
    ROUTES WHICH HANDLE AUTHENTICATION
*/
Router::add_route(["GET", "POST"], ROOT."/login", [AuthController::class, 'login']);
Router::add_route(["GET", "POST"], ROOT . "/signup", [AuthController::class, 'signup']);
Router::add_route("GET", ROOT . "/logout", [AuthController::class, 'logout']);

// handle Oauth google
Router::add_route("GET", ROOT."/oauth/google", [GoogleOauthController::class, 'init']);
Router::add_route("GET", ROOT."/oauth/google/callback", [GoogleOauthController::class, 'callback']);

// handle oauth facebook
// Router::add_route("GET", ROOT . "/oauth/facebook", [FacebookOauthController::class, 'init']);
// Router::add_route("GET", ROOT . "/oauth/facebook/callback", [FacebookOauthController::class, 'callback']);

// handle oauth X
// Router::add_route("GET", ROOT . "/oauth/X", [XOauthController::class, 'init']);
// Router::add_route("GET", ROOT . "/oauth/X/callback", [XOauthController::class, 'callback']);


/*
    ROUTES WHICH HANDLE THE HOME PAGE
*/
Router::add_route("GET", ROOT."/", [HomeController::class, 'show'])->middleware(Auth::class);
?>