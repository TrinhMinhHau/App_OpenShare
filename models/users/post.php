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
    public $idPost;
    public $idUserRequest;
    public $postDate;
    public $requestDate;


    // connect db
    public function __construct($db)
    {
        $this->conn = $db;
    }

  

    public function displayRequest()
    {
            $query = "SELECT yc.idRequest, yc.idPost, yc.idUserRequest, yc.message, yc.requestDate,yc.status,
            p.title, p.description, p.postDate, p.address, p.photos, p.idType
            FROM yeucau yc 
            JOIN baiviet p ON yc.idPost = p.idPost 
            WHERE yc.idUserRequest =:idUser";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':idUser', $this->idUser, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function displayManegerRequest()
    {
        $query = "SELECT yc.idRequest, yc.idPost, yc.idUserRequest, yc.message, yc.idUserRequest, yc.requestDate, yc.status,
        p.title, p.description, p.postDate, p.address, p.photos, p.idType
        FROM yeucau yc
        JOIN baiviet p ON yc.idPost = p.idPost
        WHERE p.idUser =:idUser";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':idUser', $this->idUser, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
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

      public function requestPost() {
        $query = "INSERT INTO `yeucau` SET idUserRequest=:idUserRequest,idPost=:idPost";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':idPost',$this->idPost, PDO::PARAM_INT);
        $stmt->bindValue(':idUserRequest', $this->idUserRequest, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error", $stmt->error;
            echo $stmt->error;
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

    public function deleteItem()
    {
        $query_2 = "DELETE FROM baiviet WHERE idPost=:idPost";
        $stmt2 = $this->conn->prepare($query_2);
        $stmt2->bindParam(':idPost', $this->idPost, PDO::PARAM_INT);

        if ($stmt2->execute()) {
            return true;
        } else {
            echo "Xóa thất bại";
            return false;
        }
    }
}

