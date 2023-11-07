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
            // add user to the db
            $db = new DB();

            $username = explode(' ', $user['username'])[0];
            $email = $user['email'];

            // usernames can be duplicate as names on google account
            // are not unique
            if ($db->getUser(NULL, $username) and !($db->getUser($email))) {

                // chars to select from
                $chars = "ABCD_abcd0123456789EFGHIJK_what__nope";

                // create a random username
                for ($i = 0; $i < 4; $i++)
                    $username .= $chars[rand(0, strlen($chars)-1)];

                // add it to db
                if ($db->addUser($username, '', '', $email, '', '')) {
                    // grab the user and log in
                    $user = $db->getUser($email);
                    Auth::login($user);

                    HelperFuncs::redirect(ROOT . "/");
                    exit();
                }
            }

            // check if user already exists in the database
            if ($db->getUser($email)) {

                // login the user
                $user = $db->getUser($email);
                Auth::login($user);

                HelperFuncs::redirect(ROOT . "/");
                exit();
            }

            // otherwise add the user to database
            else if ($db->addUser($username, '', '', $email, '', '')) {

                // grab the user and log in
                $user = $db->getUser($email);
                Auth::login($user);

                HelperFuncs::redirect(ROOT . "/");
                exit();
            }
            else
                HelperFuncs::redirect(ROOT . "/login?error=39");
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
// require_once __DIR__ . "/../config/Xconfig.php";
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