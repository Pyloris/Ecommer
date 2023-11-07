<?php
require_once __DIR__ . "/../../vendor/autoload.php";


use sirJuni\Framework\View\VIEW;
use sirJuni\Framework\Components\Oauth;
use sirJuni\Framework\Middleware\Auth;
use sirJuni\Framework\Helper\HelperFuncs;


// import models
require_once __DIR__ . "/../Models/models.php";



/*
    THIS CLASS (CONTROLLER) HANDLES USER AUTHENTICATION
*/
class AuthController {
    public function login($request) {
        if ($request->method() == "GET")
            VIEW::init("login.html");

        else if ($request->method() == "POST"){

            $email = $request->formData('email');
            $password = $request->formData('password');

            // if both fields are set
            if ($email and $password) {

                $passhash = hash("sha256", $password);


                // get the user from database
                HelperFuncs::redirect(ROOT . "/");
            }
            else {
                // redirect to login with message
                HelperFuncs::redirect(ROOT . "/login?error=Missing Fields");
            }
        }
    
    }

    public function signup($request) {
        if ($request->method() == "GET") {
            VIEW::init("signup.html");
        } 
    }

    public function logout($request) {
        Auth::logout();
        HelperFuncs::redirect(ROOT . "/login");
    }
}



/*
    THIS CLASS IS RESPONSIBLE FOR HANDLING GOOGLE OAUTH
*/
class GoogleOauthController {

    public function init($request) {
        $oauth = new Oauth(__DIR__ . '/secret.json', "https://shoaibwani.serveo.net" . ROOT . "/oauth/google/callback", ['userinfo.email', 'userinfo.profile']);
    }

    public function callback($request) {
        $oauth = new Oauth(__DIR__ . '/secret.json', "https://shoaibwani.serveo.net" . ROOT . "/oauth/google/callback", ['userinfo.email', 'userinfo.profile']);

        $user = $oauth->getUserInfo();
        if ($user) {
            Auth::login($user);
            HelperFuncs::redirect(ROOT . "/");
        }
        else {
            HelperFuncs::redirect(ROOT . "/login");
        }
    }
}


/*
    THIS CONTROLLER IS REPONSIBLE FOR FACEBOOK OAUTH
*/
class FacebookOauthController {
    public function init($request) {
        //
    }

    public function callback($request) {
        //
    }
}


/*
    THIS CONTROLLER IS RESPONSIBLE FOR X OAUTH
*/
class XOauthController {
    public function init($request) {
        //
    }

    public function callback($request) {
        //
    }
}

?>