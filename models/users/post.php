<?php
class Post
{
    private $conn;

    //property
    public $title;
    public $description;
    public $address;
    public $photos;
    public $idUser;
    public $idType;


    // connect db
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function addItem()
    {
            $query = "INSERT INTO `baiviet` SET title=:title,description=:description,address=:address,photos=:photos,idType=:idType,idUser=:idUser";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':title', $this->title, PDO::PARAM_STR);
            $stmt->bindValue(':description',$this->description, PDO::PARAM_STR);
            $stmt->bindValue(':address',$this->address, PDO::PARAM_STR);
            $stmt->bindValue(':photos', $this->photos, PDO::PARAM_STR);
            $stmt->bindValue(':idType',$this->idType, PDO::PARAM_INT);
            $stmt->bindValue(':idUser', $this->idUser, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return true;
            } else {
                echo "Error", $stmt->error;
                return false;
            }
    }
    public function displayItem()
    {
        $query = "SELECT * FROM `baiviet`";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}

