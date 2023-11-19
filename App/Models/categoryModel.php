<?php


trait categoryDB {

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
}

?>