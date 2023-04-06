<?php
class Post
{
    private $conn;

    //property
    public $title;
    public $description;
    public $address;
    public $photos;

    // connect db
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function addItem()
    {
            $query = "INSERT INTO baiviet SET title=:title,description=:description,address=:address,photos=:photos";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':title', $this->title, PDO::PARAM_STR);
            $stmt->bindValue(':description',$this->description, PDO::PARAM_STR);
            $stmt->bindValue(':address',$this->address, PDO::PARAM_STR);
            $stmt->bindValue(':photos', $this->photos, PDO::PARAM_STR);

            if ($stmt->execute()) {
                return true;
            } else {
                echo "Error", $stmt->error;
                return false;
            }
    }
}