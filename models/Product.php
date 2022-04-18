<?php

class Product{
    private $conn;
    private $table = 'products';

    public $id;
    public $product_name;
    public $quantities;
    public $price;
    public $category;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = 'Select 
                id,
                product_name,
                quantities,
                price,
                category
              FROM
                ' . $this->table . ' 
              ORDER BY
                id ASC';

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' 
            SET 
                product_name = :product_name, 
                quantities = :quantities, 
                price = :price, 
                category = :category';

        $stmt = $this->conn->prepare($query);

        $this->product_name = htmlspecialchars(strip_tags($this->product_name));
        $this->quantities = htmlspecialchars(strip_tags($this->quantities));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->category = htmlspecialchars(strip_tags($this->category));

        $stmt->bindParam(':product_name', $this->product_name, PDO::PARAM_STR);
        $stmt->bindParam(':quantities', $this->quantities, PDO::PARAM_INT);
        $stmt->bindParam(':price', $this->price, PDO::PARAM_INT);
        $stmt->bindParam(':category', $this->category, PDO::PARAM_STR);

        if($stmt->execute()){
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;

    }

    public function update() {
        $query = 'UPDATE ' . $this->table . ' 
            SET 
                product_name = :product_name, 
                quantities = :quantities, 
                price = :price, 
                category = :category 
            WHERE
                id = :id
            ';

        $stmt = $this->conn->prepare($query);

        $this->product_name = htmlspecialchars(strip_tags($this->product_name));
        $this->quantities = htmlspecialchars(strip_tags($this->quantities));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':product_name', $this->product_name, PDO::PARAM_STR);
        $stmt->bindParam(':quantities', $this->quantities, PDO::PARAM_INT);
        $stmt->bindParam(':price', $this->price, PDO::PARAM_INT);
        $stmt->bindParam(':category', $this->category, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        if($stmt->execute()){
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;

    }

    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars((strip_tags($this->id)));

        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        if($stmt->execute()){
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }
}