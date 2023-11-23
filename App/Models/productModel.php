<?php

trait ProductDB {
    public function addProduct($name, $sku, $description, $mrp, $sp, $imgs, $rating=NULL, $category=NULL, $collection=NULL, $flag=NULL) {
        $query = "INSERT INTO products (name, sku, description, MRP, SP, imgs, rating, category, collection, flag) VALUES (:name, :sku, :description, :mrp, :sp, :imgs, :rating, :category, :collection, :flag)";

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
            $stmt->bindParam(':collection', $collection);
            $stmt->bindParam(':flag', $flag);

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

    public function getProductsByCategory($category_id) {
        $query = "SELECT * FROM products WHERE category=:c_id";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":c_id", $category_id);

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

    public function getProductsByCollection($collection_id) {
        $query = "SELECT * FROM products WHERE collection=:c_id";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":c_id", $collection_id);

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

    public function getProductsByFlag($flag) {
        $query = "SELECT * FROM products WHERE flag=:flag";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":flag", $flag);

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

    public function getRelatedProducts($subject_id, $name, $category, $collection) {
        if ($category and $collection)
            $query = "SELECT * FROM products WHERE id!=:t_id AND (category=:category OR collection=:collection)";
        else {
            $query = "SELECT * FROM products WHERE id!=:t_id";
            // split name
            $name = explode(" ", $name);
            $holders = [];
            foreach($name as $part) {
                if (strlen($part) >= 3) {
                    $query .= " AND ";
                    $val = ':' . strtolower($part);
                    $part = '%' . $part . '%';
                    $holders[$val] = $part;
                    $query .= " name LIKE " . $val . " ";
                }
            }
        }

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':t_id', $subject_id);
            if ($category and $collection) {
                $stmt->bindParam(':category', $category);
                $stmt->bindParam(':collection', $collection);
            }
            else {
                foreach($holders as $key => $value) {
                    $stmt->bindParam($key, $value);
                }
            }

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