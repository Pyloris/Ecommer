<?php

// this trait contains methods to get
// all the properties of the products
// so that we can make adding product from admin page
// easy
trait adminDB {
    
    public function getCategories() {
        $query = "SELECT * FROM categories";

        try {
            $stmt = $this->db->query($query);
            if ($stmt) {
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

    public function getFlags() {
        $query = "SELECT * FROM flags";

        try {
            $stmt = $this->db->query($query);
            if ($stmt) {
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

}

?>