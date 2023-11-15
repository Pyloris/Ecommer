<?php

trait stockDB {
    public function setStock($id, $stock) {
        $query = "INSERT INTO stock (product_id, items) values (:id, :items)";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":items", $stock);

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

    public function getStock($id) {
        $query = "SELECT items FROM stock where product_id=:id";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id", $id);

            if ($stmt->execute()) {
                return $stmt->fetch();
            }
            else {
                return FALSE;
            }
        }
        catch (PDOException $e) {
            return FALSE;
        }

    }
}

?>