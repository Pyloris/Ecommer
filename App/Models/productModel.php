<?php

trait ProductDB {
    public function addProduct($name, $sku, $description, $mrp, $sp, $imgs, $rating=NULL, $category=NULL) {
        $query = "INSERT INTO products (name, sku, description, MRP, SP, imgs, rating, category) VALUES (:name, :sku, :description, :mrp, :sp, :imgs, :rating, :category)";

        try {
            $stmt = $this->db->prepare($query);

            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':sku', $sku, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':mrp', $mrp);
            $stmt->bindParam(':sp', $sp);
            $stmt->bindParam(':imgs', $imgs);
            $stmt->bindParam(':rating', $rating);
            $stmt->bindParam(':category', $category);

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

    public function getProducts($keywords) {
        $query = "SELECT * FROM products WHERE ";

        foreach ($keywords as $word) {
            $query .= " name like '%$word%'";
            if ($word != end($keywords))
                $query .= " OR ";
        }

        try {
            $stmt = $this->db->query($query);

            return $stmt->fetchAll();
        }
        catch (PDOException $e) {
            echo($e->getMessage());
        }
    }

    public function getProduct($id=NULL, $name=NULL) {
        if (!$id) 
            $query = "SELECT * FROM products WHERE name=:name";
        else 
            $query = "SELECT * FROM products WHERE id=:id";

        try {
            $stmt = $this->db->prepare($query);
            if (!$id)
                $stmt->bindParam(":name", $name);
            else
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
}

?>