<?php

// a trait to store methods related to User
trait UserDB {
    public function addUser($username, $first_name, $last_name, $email, $password, $phone) {
        
        // build the query
        $query = "INSERT INTO users (username, first_name, last_name, email, password, phone) VALUES (:username, :fname, :lname, :email, :pass, :phone)";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":fname", $first_name);
            $stmt->bindParam(":lname", $last_name);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":pass", $password);
            $stmt->bindParam(":phone", $phone);

            if ($stmt->execute()) {
                return TRUE;
            }
            else {
                return FALSE;
            }
        }
        catch (PDOException $e) {
            return FALSE;
        }
    }

    public function addAddress($id, $street='', $city='', $pin='', $state='', $country='') {
        $query = "INSERT INTO user_details (id, street, city, pin, state, country) VALUES (:id, :street, :city, :pin, :state, :country)";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":street", $street);
            $stmt->bindParam(":city", $city);
            $stmt->bindParam(":pin", $pin);
            $stmt->bindParam(":state", $state);
            $stmt->bindParam(":country", $country);

            if ($stmt->execute()) {
                return TRUE;
            }
            else {
                return FALSE;
            }
        }
        catch (PDOException $e) {
            return FALSE;
        }
    }

    public function getUser($email=NULL, $username=NULL) {
        if ($email) {
            $query = "SELECT * FROM users WHERE email=:email";
        }
        else if ($username) {
            $query = "SELECT * FROM users WHERE username=:username";
        }

        try {
            $stmt = $this->db->prepare($query);
            
            if ($email) {
                $stmt->bindParam(":email", $email);
            }
            else if ($username) {
                $stmt->bindParam(":username", $username);
            }

            if ($stmt->execute()) {
                $user = $stmt->fetch();
                return $user;
            }
            else {
                return NULL;
            }
        }
        catch (PDOException $e) {
            return NULL;
        }
    }

    public function changePassword($new_pass, $email=NULL, $password=NULL) {
        //
        ;
    }


    public function getUserDetails($user_id) {
        $query = "SELECT * FROM user_details WHERE id=:u_id";

        try {
            $stmt = $this->db->prepare($query);
            
            $stmt->bindParam(":u_id", $user_id);

            if ($stmt->execute()) {
                $user = $stmt->fetch();
                return $user;
            }
            else {
                return NULL;
            }
        }
        catch (PDOException $e) {
            return NULL;
        }
 
    }

    public function updateAddressDetails($details, $id) {

        $query = "UPDATE user_details SET ";

        foreach($details as $col => $val) {
            $query .= "$col=:$col";
            $key_arr = array_keys($details);
            if (end($key_arr) != $col)
                $query .= ", ";
        }

        // where clause
        $query .= " WHERE id=:id";

        try {
            $stmt = $this->db->prepare($query);
           
            foreach($details as $col => $val) {
                // $bindVal = $val;
                $stmt->bindValue(":".$col, $val, PDO::PARAM_STR);
            }

            $stmt->bindParam(":id", $id, PDO::PARAM_INT);

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

    public function updatePersonalDetails($details, $id) {
        $query = "UPDATE users SET ";
        foreach($details as $col => $val) {
            $query .= "$col=:$col";
            $key_arr = array_keys($details);
            if (end($key_arr) != $col) {
                $query .= ' ,';
            }
        }

        // where clause
        $query .= " WHERE id=:id";

        try {
            $stmt = $this->db->prepare($query);
           
            foreach($details as $col => $val) {
                // $bindVal = $val;
                $stmt->bindValue(":".$col, $val, PDO::PARAM_STR);
            }
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);

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
}

?>