<?php
require_once __DIR__ . "/../../vendor/autoload.php";


use sirJuni\Framework\View\VIEW;
use sirJuni\Framework\Middleware\Auth;
use sirJuni\Framework\Helper\HelperFuncs;


// import models
require_once __DIR__ . "/../Models/models.php";


/*
    THIS CLASS (CONTROLLER) HANDLES USER AUTHENTICATION
*/
class AuthController {

    // this method returns where a given username
    // is already in the database or not
    public function checkValidUserName($request) {
        $username = $request->formData('username');

        if ($username == '')
            $resp = [
                'isValid' => 'NO'
            ];
        
        else
            $db = new DB();
            // check if there is one in the database
            if ($db->getUser(NULL, $username)) {
                $resp = [
                    'isValid' => 'NO'
                ];
            }
            else {
                $resp = [
                    'isValid' => 'YES'
                ];
            }

        header("Content-Type: application/json");
        echo json_encode($resp);
    }
    
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
        
        if ($request->method() == "POST" or $request->sessionData('verified_with_otp')) {

            // get all the fields
            $username = $request->method() == "GET" ? $request->sessionData('username') : $request->formData('username');
            $first_name = $request->method() == "GET" ? $request->sessionData('first_name') : $request->formData('first_name');
            $last_name = $request->method() == "GET" ? $request->sessionData('last_name') : $request->formData('last_name');
            $email = $request->method() == "GET" ? $request->sessionData('email') : $request->formData('email');
            $password = $request->method() == "GET" ? $request->sessionData('password') : $request->formData('password');
            $phone = $request->method() == "GET" ? $request->sessionData('phone') : $request->formData('phone');

            // this will be non zero if any validation fails
            $error = 0;

            // validate username
            if (!preg_match('/^[a-zA-Z0-9_]{5,}$/', $username))
                $error = 1;
            
            if (!preg_match('/^[a-zA-Z]+$/', $first_name) and !preg_match('/^[a-zA-Z]+$/', $last_name))
                $error = 2;

            if (!preg_match('/^[a-zA-Z][a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-zA-Z]{0,4}$/', $email))
                $error = 3;
            
            if (!preg_match('/[a-zA-Z0-9\_@\!\|\\\$\^\&\*\%]{8,}/', $password) and !preg_match('/^[0-9]{0,10}$/', $phone))
                $error = 4;

            // if all the fields are set, add the user to the database
            if (!$error) {

                // get a database instance
                $db = new DB();

                // get password hash
                $passhash = hash("sha256", $password);

                // check if username is duplicate
                if ($db->getUser(NULL, $username)) {
                    HelperFuncs::redirect(ROOT . "/signup?error=An account with this username already exists");
                    exit();
                }
                else if ($db->getUser($email)) {
                    HelperFuncs::redirect(ROOT . "/signup/?error=An account with this email already exists!");
                    exit();
                }

                // add the user to db
                if ($request->sessionData('verified_with_otp')) {

                    // successfully added
                    // redirect to home
                    if ($db->addUser($username, $first_name, $last_name, $email, $passhash, $phone)) {
                    
                        // get user from db
                        $user = $db->getUser($email);

                        if ($user) {
                            Auth::login($user);
                        }

                        HelperFuncs::redirect(ROOT . "/");
                        exit();
                    }
                    else {
                        HelperFuncs::redirect(ROOT . "/signup?error=Could not create your account. try again");
                        exit();
                    }
                }
                else {

                    // send user to the otp verification page
                    // set the data in the session
                    session_start();
                    $_SESSION['email'] = $email;
                    $_SESSION['username'] = $username;
                    $_SESSION['first_name'] = $first_name;
                    $_SESSION['last_name'] = $last_name;
                    $_SESSION['password'] = $password;
                    $_SESSION['phone'] = $phone;

                    // send user to otp validation
                    $_SESSION['validate_OTP'] = TRUE;
                    session_write_close();

                    HelperFuncs::redirect(ROOT . "/signup/otp");
                    exit();
                }
            }
            else {
                // if a field is missing
                HelperFuncs::redirect(ROOT . "/signup?error=adhere to format&code=$error");
            }
        }
        else if ($request->method() == "GET") {
            VIEW::init("signup.html");
        }
    }

    public function logout($request) {
        Auth::logout();
        HelperFuncs::redirect(ROOT . "/login");
    }
}


?>