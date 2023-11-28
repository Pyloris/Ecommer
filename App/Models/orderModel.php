<?php

trait OrderDB {

    public function addToCart($user_id, $product_id) {
        $query = "INSERT INTO cart VALUES (:u_id, :p_id)";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":u_id", $user_id);
            $stmt->bindParam(":p_id", $product_id);

            if ($stmt->execute()) {
                return TRUE;
            }
            else {
                return FALSE;
            }
        }
        catch (PDOException $e) {
            echo($e->getMessage());
        }
    }


    public function addToBuyNowCart($user_id, $product_id) {
        $query = "INSERT INTO buynow_cart VALUES (:u_id, :p_id)";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":u_id", $user_id);
            $stmt->bindParam(":p_id", $product_id);

            if ($stmt->execute()) {
                return TRUE;
            }
            else {
                return FALSE;
            }
        }
        catch (PDOException $e) {
            echo($e->getMessage());
        }

    }


    public function getBuyNowCartItem($user_id) {
        $query = "SELECT * FROM buynow_cart WHERE user_id=:u_id";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":u_id", $user_id);

            if ($stmt->execute()) {
                return $stmt->fetchAll(); 
            }
            else {
                return FALSE;
            }
        }
        catch (PDOException $e) {
            echo($e->getMessage());
        }
    }

    public function cleanBuyNowCart($user_id) {
        $query = "DELETE FROM buynow_cart WHERE user_id=:u_id";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":u_id", $user_id);

            if ($stmt->execute()) {
                return TRUE;
            }
            else {
                return FALSE;
            }
        }
        catch (PDOException $e) {
            echo($e->getMessage());
        }

    }

    public function getCartItems($user_id) {
        $query = "SELECT product_id FROM cart WHERE user_id=:u_id";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":u_id", $user_id);

            if ($stmt->execute()) {
                return $stmt->fetchAll();
            }
            else {
                return FALSE;
            }
        }
        catch (PDOException $e) {
            echo($e->getMessage());
        } 
    }

    public function removeCartItem($user_id, $product_id) {
        $query = "DELETE FROM cart WHERE user_id=:u_id and product_id=:p_id";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":u_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":p_id", $product_id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return TRUE;
            }
            else {
                return FALSE;
            }
        }
        catch (PDOException $e) {
            echo($e->getMessage());
        } 
    }

    public function storeOrder($customer_id, $id, $total_price, $payment_status="PENDING", $order_status="CREATED") {

        $query = "INSERT INTO orders (customer_id, id, total_price, payment_status, order_status) VALUES (:cid, :id, :total_price, :p_s, :o_s)";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":cid", $customer_id);
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":total_price", $total_price);
            $stmt->bindParam(":p_s", $payment_status);
            $stmt->bindParam(":o_s", $order_status);

            if ($stmt->execute()) {
                return TRUE;
            }
            else {
                return FALSE;
            }
        }
        catch (PDOException $e) {
            echo($e);
        }
    }

    public function storeOrderItem($order_id, $product_id) {
        $query = "INSERT INTO order_items (order_id, product_id) values (:o_id, :p_id)";

        try {
            $stmt = $this->db->prepare($query);

            $stmt->bindParam(":o_id", $order_id);
            $stmt->bindParam(":p_id", $product_id);

            if ($stmt->execute()) {
                return TRUE;
            }
            else {
                return FALSE;
            }
        }
        catch (PDOException $e) {
            echo($e);
        }
    }


    public function getOrders($user_id) {
        $query = "SELECT * FROM orders WHERE customer_id=:u_id";

        try {
            $stmt = $this->db->prepare($query);

            $stmt->bindParam(":u_id", $user_id);

            if ($stmt->execute()) {
                return $stmt->fetchAll();
            }
            else {
                return FALSE;
            }
        }
        catch (PDOException $e) {
            echo($e);
        }
    }

    public function getOrderItems($order_id) {
        $query = "SELECT * FROM order_items WHERE order_id=:o_id";

        try {
            $stmt = $this->db->prepare($query);

            $stmt->bindParam(":o_id", $order_id);

            if ($stmt->execute()) {
                return $stmt->fetchAll();
            }
            else {
                return FALSE;
            }
        }
        catch (PDOException $e) {
            echo($e);
        }

    }

    public function removeOrder($order_id) { 
        $query = "DELETE FROM orders WHERE id=:o_id";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":o_id", $order_id);

            if ($stmt->execute()) {
                return TRUE;
            }
            else {
                return FALSE;
            }
        }
        catch (PDOException $e) {
            echo($e->getMessage());
        } 
    }

    public function removePendingOrders($user_id) {
        $query = "DELETE FROM orders WHERE customer_id=:customer_id AND payment_status=:stat";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":customer_id", $user_id);
            $status = "PENDING";
            $stmt->bindParam(":stat", $status);

            if ($stmt->execute()) {
                return TRUE;
            }
            else {
                return FALSE;
            }
        }
        catch (PDOException $e) {
            echo($e->getMessage());
        } 

    }

    public function updatePaymentStatus($order_id, $status) {

        $query = "UPDATE orders SET payment_status=:p_status WHERE id=:o_id";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":o_id", $order_id);
            $stmt->bindParam(":p_status", $status);

            if ($stmt->execute() and $stmt->rowCount() > 0) {
                return TRUE;
            }
            else {
                return FALSE;
            }
        }
        catch (PDOException $e) {
            echo($e->getMessage());
        } 

    }

    public function updateOrderStatus($order_id, $status) {
        $query = "UPDATE orders SET order_status=:o_status WHERE id=:o_id";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":o_id", $order_id);
            $stmt->bindParam(":o_status", $status);

            if ($stmt->execute() and $stmt->rowCount() > 0) {
                return TRUE;
            }
            else {
                return FALSE;
            }
        }
        catch (PDOException $e) {
            echo($e->getMessage());
        } 

    }
}

?>