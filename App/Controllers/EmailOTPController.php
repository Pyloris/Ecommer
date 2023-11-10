<?php

require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/../Helpers/functions.php";

use sirJuni\Framework\View\VIEW;
use sirJuni\Framework\Middleware\Auth;
use sirJuni\Framework\Helper\HelperFuncs;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// import models
require_once __DIR__ . "/../Models/models.php";

class EmailOTPController {

    public function send_otp($request) {

        // the provided info will be in session
        // if the verified_email = True in session after this
        // it will be entered into the database
        // otherwise shows error and sends back to signup

        // check if validate OTP is set
        // echo($request->sessionData('validate_OTP'));
        try{ 
            if ($request->sessionData('validate_OTP')) {

                // get the phone number from the session
                $email = $request->sessionData('email');
                $username = $request->sessionData('username');

                // generate random 4 digit number
                $random = rand(1000, 9999);

                // start mail server
                $mail = new PHPMailer(true);

                $mail->isSMTP();
                $mail->Host = "smtp.gmail.com";
                $mail->SMTPAuth = true;

                $mail->Username = "fashionsantahere@gmail.com";
                $mail->Password = APP_PASSWORD;
                $mail->Port = 465;
                $mail->SMTPSecure = 'ssl';

                $mail->Timeout = 60;

                // sender info
                $mail->setFrom("fashionsanta@gmail.com", "ECOMMER");

                // reciever
                $mail->addAddress($email, $username);

                $mail->isHTML(true);

                $expiry = time() + 120;  // 2 minute valid
                
                // store otp in session
                if (session_status() == PHP_SESSION_NONE)
                    session_start(); 
                $_SESSION['otp'] = $random;
                $_SESSION['expiry'] = $expiry;
                $_SESSION['count'] = 0;
                session_write_close();

                // add message body
                $mail->Subject = "OTP for Email verification";
                
                $mail->Body = <<<DOC
                <h2> OTP </h2>
                <h5> Below is the OTP for Email verification </h5>
                <h3> $random </h3>
                <p> This OTP is valid for 2 minutes. </p>
                DOC;

                // send the email
                if (!$mail->send()) {
                    HelperFuncs::redirect(ROOT . "/signup?error=Could not send email. Trying to fix");
                    exit();
                }
                else {
                    $mail->smtpClose();
                    // render verification page
                    VIEW::init("otp.html", ["email" => $email]);
                    exit();
                }
            }
            else {
                session_destroy();
                unset_session(array_keys($_SESSION));
                session_write_close();
                HelperFuncs::redirect(ROOT . "/signup?error=session was invalid");
            }
        }
        catch (Exception $e) {
            VIEW::init("status.html", ['message' => $e->getMessage()]);
        }
    }

    
    public function verify_otp($request) {

        $n1 = (int) $request->formData('n1');
        $n2 = (int) $request->formData('n2');
        $n3 = (int) $request->formData('n3');
        $n4 = (int) $request->formData('n4');

        $sum = $n1 + $n2 + $n3 + $n4;
        // check if they are all numbers and defined
        if (!preg_match('/^[0-9]{1,2}$/', "$sum")) {
            echo("Please provides numbers as input");
        }

        $otp = $n1 * 1000 + $n2 * 100 + $n3 * 10 + $n4;

        // get the email from the session
        $email = $request->sessionData('email');

        if ($request->sessionData('otp')) {
            // check if OTP is expired
            $expiry = (float) $request->sessionData('expiry');

            if (time() > $expiry or $request->sessionData('count') == 3) {
                // unset the OTP
                session_destroy();
                unset_session($request->sessionKeys());
                session_write_close();

                HelperFuncs::redirect(ROOT . "/signup?error=otp expired or max tries exceeded");
                exit();
            }
            else {
                
                // check if OTP is valid
                if ($otp == (int) $request->sessionData('otp')) {
                    unset_session(['otp', 'expiry', 'count']);
                    // set the session variable
                    // verified_with_otp = TRUE;
                    $_SESSION['verified_with_otp'] = TRUE;
                    session_write_close();
                    // redirect to register
                    HelperFuncs::redirect(ROOT . "/signup");
                }
                else {
                    if ($request->sessionData('count')){
                        $_SESSION['count'] += 1;
                    }
                    HelperFuncs::redirect(ROOT . "/signup/verify?error=wrong otp {$request->sessionData('count')} tries remain");
                }
            }
        }
        else {
            unset_session($request->sessionKeys());
            HelperFuncs::redirect(ROOT . "/signup"); 
        }
    }
}

?>