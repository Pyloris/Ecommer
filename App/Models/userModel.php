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
    }
}

?>