<?php
require_once __DIR__ . "/../../vendor/autoload.php";


use sirJuni\Framework\View\VIEW;
use sirJuni\Framework\Components\Oauth;
use sirJuni\Framework\Middleware\Auth;
use sirJuni\Framework\Helper\HelperFuncs;

// use the Abrahm client for oauth.
use Abraham\TwitterOAuth\TwitterOAuth;


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

            $usernameOrEmail = $request->formData('usernameOrEmail');
            $password = $request->formData('password');

            // if both fields are set
            if ($usernameOrEmail and $password) {

                // check if username is given or email
                if (preg_match('/^[a-zA-Z0-9_]+$/', $usernameOrEmail)) {
                    $isEmail = 0;
                }
                else {
                    $isEmail = 1;
                }

                $passhash = hash("sha256", $password);

                // get the user from database
                $db = new DB();

                if ($isEmail)
                    $user = $db->getUser($usernameOrEmail);
                else
                    $user = $db->getUser(NULL, $usernameOrEmail);

                if ($user and $user['password'] == $passhash) {
                    Auth::login($user);
                    HelperFuncs::redirect(ROOT . "/");
                }
                else {
                    HelperFuncs::redirect(ROOT . "/login?error=Wrong email or password");
                }
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
        else if ($request->method() == "POST") {

            // get all the fields
            $username = $request->formData('username');
            $first_name = $request->formData('first_name');
            $last_name = $request->formData('last_name');
            $email = $request->formData('email');
            $password = $request->formData('password');
            $phone = $request->formData('phone');

            // this will be 1 if any validation fails
            $error = 0;

            // validate username
            if (!preg_match('/^[a-zA-Z0-9_]+$/', $username))
                $error = 1;
            
            if (!preg_match('/^[a-zA-Z]+$/', $first_name) and !preg_match('/^[a-zA-Z]+$/', $last_name))
                $error = 1;

            if (!preg_match('/^[a-zA-Z][a-zA-Z0-9\.\+]+@[a-zA-Z0-9]+\.[a-zA-Z]{,3}$', $email))
                $error = 1;
            
            if (!preg_match('/[a-zA-Z0-9\_@\!\|\\\$\^\&\*\%]+/', $password) and !preg_match('/^[0-9]{,10}$/', $phone))
                $error = 1;

            // if all the fields are set, add the user to the database
            if ($error) {

                // get a database instance
                $db = new DB();

                // get password hash
                $passhash = hash("sha256", $password);
                // add the user to db
                if ($db->addUser($username, $first_name, $last_name, $email, $passhash, $phone)) {

                    // successfully added
                    // redirect to home
                    
                    // get user from db
                    $user = $db->getUser($email);

                    if ($user) {
                        Auth::login($user);
                    }

                    HelperFuncs::redirect(ROOT . "/");
                    exit();
                }
                else {
                    HelperFuncs::redirect(ROOT . "/signup?error=This error was on our part. We are trying to fix it");
                }
            }
            else {
                // if a field is missing
                HelperFuncs::redirect(ROOT . "/signup?error=One or More fields are missing");
            }
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
require_once __DIR__ . "/../config/Xconfig.php";



class XOauthController {
    public function init($request) {
        $oauth = new TwitterOAuth(API_KEY, API_SECRET);

        $token = $oauth->oauth('oauth/request_token', ['oauth_callback' => CALLBACK_URL]);

        // store tokens in session
        if (session_status == PHP_SESSION_NONE)
            session_start();

        $_SESSION['oauth_token'] = $token['oauth_token'];
        $_SESSION['oauth_token_secret'] = $token['oauth_token_secret'];

        // get auth url
        $url = $oauth->url('oauth/authorize', ['auth_token' => $token['auth_token']]);

        // redirect
        HelperFuncs::redirect($url);
    }

    public function callback($request) {
        $oauth = new TwitterOAuth(API_KEY, API_SECRET);

        $access_token = $connection->oauth('oauth/access_token', array('oauth_verifier' => $_GET['oauth_verifier']));

        // Use the access token to make Twitter API requests
        $user = $connection->get('account/verify_credentials');

        var_dump($user);
    }
}

?>