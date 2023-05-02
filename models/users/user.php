<?php
class Post
{
    private $conn;

    //property
    public $userName;
    public $email;
    public $photoURL;
    public $name;
    public $phoneNumber;
    public $idUser;
    // connect db
    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function getUserById()
    {
        $query = "SELECT *
        FROM user 
        WHERE idUser =:idUser";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':idUser', $this->idUser, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }
}
