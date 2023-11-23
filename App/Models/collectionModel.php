<?php

trait collectionDB {

    public function getCollection($id) {
        $query = "SELECT * FROM collections WHERE id=:id";

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
            echo($e->getMessage());
        }

    }

    public function getCollections($limit = NULL) {
        if ($limit == NULL)
            $limit = 4;
        $query = "SELECT * FROM collections LIMIT :limit";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);

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
}

?>