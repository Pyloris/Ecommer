<?php

require_once __DIR__ . "/../../vendor/autoload.php";


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
        if ($request->sessionData('validate_OTP')) {

            // get the phone number from the session
            $email = $request->sessionData('email');
            $username = $request->sessionData('username');

            // generate random 4 digit number
            $random = rand(1000, 9999);

            // start mail server
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host = "smtp.google.com";
            $mail->SMTPAuth = true;

            $mail->Username = "fashionsanta@gmail.com";
            $mail->Password = APP_PASSWORD;
            $mail->Port = 465;
            $mail->SMTPSecure = 'ssl';

            // sender info
            $mail->setFrom("fashionsanta@gmail.com", "ECOMMER");

            // reciever
            $mail->addAddress($email, $username);

            $mail->isHTML(true);

            $expiry = time() + 120;  // 2 minute valid
            // bind the token and email
            if ($db->addOTPWithEmail($email, $random, $expiry)) {

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
                    
                    // render verification page
                    VIEW::init("otp.html", ["email" => $email]);
                }
            }
            else {
                HelperFuncs::redirect(ROOT . "/signup?error=DB error");
            }
        }
        else {
            echo("INVALID SESSION, SIGNUP AGAIN");
        }
    }

    public function verify_otp($request) {

        
    }
}

?>