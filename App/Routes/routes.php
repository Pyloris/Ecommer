<?php
require_once __DIR__ . "/../../vendor/autoload.php";


use sirJuni\Framework\Handler\Router;
use sirJuni\Framework\Middleware\Auth;


// load all the controllers
require_once __DIR__ . "/../Controllers/authController.php";
require_once __DIR__ . "/../Controllers/OAuthController.php";
require_once __DIR__ . "/../Controllers/homeController.php";
require_once __DIR__ . "/../Controllers/EmailOTPController.php";
require_once __DIR__ . "/../Controllers/AdminController.php";
require_once __DIR__ . "/../Controllers/OrderController.php";
require_once __DIR__ . "/../Controllers/RZPWebhookController.php";
require_once __DIR__ . "/../Controllers/ProductController.php";
require_once __DIR__ . "/../Controllers/ShopController.php";



// bring in custom middleware
require_once __DIR__ . "/../Middleware/PaymentFlow.php";


// set the fallback route for Auth middleware
Auth::set_fallback_route(ROOT."/login");

/*
    ROUTES WHICH HANDLE AUTHENTICATION
*/
// this route returns whether username exists or not
Router::add_route("POST", ROOT . "/checkValidUserName", [AuthController::class, 'checkValidUserName']);

Router::add_route(["GET", "POST"], ROOT."/login", [AuthController::class, 'login']);
Router::add_route(["GET", "POST"], ROOT . "/signup", [AuthController::class, 'signup']);
Router::add_route("GET", ROOT . "/logout", [AuthController::class, 'logout']);

// handle Oauth google
Router::add_route("GET", ROOT."/oauth/google", [GoogleOauthController::class, 'init']);
Router::add_route("GET", ROOT."/oauth/google/callback", [GoogleOauthController::class, 'callback']);

// handle email OTP validation
Router::add_route("GET", ROOT."/signup/otp", [EmailOTPController::class, 'send_otp']);
Router::add_route(["GET", "POST"], ROOT."/signup/verify", [EmailOTPController::class, 'verify_otp']);


// handle shop
Router::add_route("GET", ROOT . "/shop", [ShopController::class, 'show']);



// handle ADmin routes
Router::add_route("GET", ROOT . "/admin", [AdminController::class, 'show'])->middleware(Auth::class);
Router::add_route(["GET", "POST"], ROOT . "/admin/add_product", ['AdminController'::class, 'addProduct'])->middleware(Auth::class);



// razorpay webhook handler
Router::add_route("POST", ROOT . "/rzp_webhook", [RZPWebhookController::class, 'handle']);


// handle oauth facebook
// Router::add_route("GET", ROOT . "/oauth/facebook", [FacebookOauthController::class, 'init']);
// Router::add_route("GET", ROOT . "/oauth/facebook/callback", [FacebookOauthController::class, 'callback']);

// handle oauth X
// Router::add_route("GET", ROOT . "/oauth/X", [XOauthController::class, 'init']);
// Router::add_route("GET", ROOT . "/oauth/X/callback", [XOauthController::class, 'callback']);


// handle routes for products
Router::add_route("GET", ROOT . "/product", [ProductController::class, 'show']);


/*
    ROUTES WHICH HANDLE THE HOME PAGE
*/
Router::add_route("GET", ROOT."/", [HomeController::class, 'show']);
Router::add_route(["GET", "POST"], ROOT. "/cart", [OrderController::class, 'cartHandler'])->middleware(Auth::class);
Router::add_route("GET", ROOT. "/store/payment", [OrderController::class, 'createOrder'])->middleware(Auth::class)->middleware(PaymentFlow::class);
?> 