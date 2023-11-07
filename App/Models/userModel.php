<?php

// a trait to store methods related to User
trait UserDB {
    public function addUser($username, $first_name, $last_name, $email, $password, $phone) {
        //
    }

    public function getUser($email=NULL, $username=NULL) {
        //
    }

    public function changePassword($new_pass, $email=NULL, $password=NULL) {
        //
    }
}

?>