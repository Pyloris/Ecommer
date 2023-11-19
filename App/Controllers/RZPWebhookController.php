<?php
require_once __DIR__ . "/../../vendor/autoload.php";

require_once __DIR__ . "/../Models/models.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class RZPWebhookController {
    public function handle($request) {

        $data = file_get_contents("php://input");

        $json_data = json_decode($data);
        
        // set up db connection
        $db = new DB();

        // set up php mailer
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

        $mail->isHTML(true);


        $user_email = $json_data->payload->payment->entity->email;
        $order_id = $json_data->payload->payment->entity->order_id;
        $event = $json_data->event;

        // if order.paid
        // or payment failed
        // send an email to the user
        if ($event == "payment.failed") {

            // remove order from database
            $db->removeOrder($order_id);

            $mail->addAddress($user_email, "USER");

            $mail->Subject = "Order Payment Failed";
            $mail->Body = <<<DOC
            <h2>The payment for the order <em>$order_id</em> has Failed</h2>
            <p>Please, reorder and complete the payment for purchase.</p>
            DOC;

            try {
                $mail->send();
            }
            catch (Exception) {
                echo("EXCEPTION");
            }
        }
        else if ($event == "order.paid") {

            // change payment status to done
            // order status to PROcessing
            $status = "DONE";
            $db->updatePaymentStatus($order_id, $status);
            
            $status = "PROCESSING";
            $db->updateOrderStatus($order_id, $status);

            // get all the items ordered.
            // send email for order being placed.
            $ordered_items = $db->getOrderItems($order_id);

            // prepare context for the message
            $context = [];

            foreach($ordered_items as $item) {
                // get product
                $product = $db->getProduct($item['product_id']);

                $context[] = $product['name'];
            }

            // join the product names together.
            $product_names = implode(", ", $context);


            $mail->addAddress($user_email, "USER");

            // prepare the mail
            $mail->Subject = "ORDER SUCCESSFULL";

            $mail->Body =<<<DOC
            <p><strong>Thank You</strong> for ordering $product_names</p>
            <p> The order will be delivered within a week. You can track your order once
            it has been dispatched. You will recieve the tracking ID in 1 to 2 working days.</p>
            <h3>Happy Shopping</h3>
            DOC;

            try {
                $mail->send();
            }
            catch (Exception) {
                echo("could not send mail");
            }
        }
    }
}

?>