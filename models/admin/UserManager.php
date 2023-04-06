<?php
class UserManager
{
    private $conn;

    //property
    public $idUser;
    public $userName;
    public $password;
    public $email;
    public $photoURL;
    public $name;
    public $phoneNumber;
    public $isBan;
    // connect db
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function displayInfor()
    {
        $query = "SELECT * FROM user ORDER BY idUser DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function banUser()
    {
        $query = "UPDATE user SET isBan=1 WHERE idUser=:idUser";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':idUser', $this->idUser, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error", $stmt->error;
            return false;
        }
    }
    public function unbanUser()
    {
        $query = "UPDATE user SET isBan=0 WHERE idUser=:idUser ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':idUser', $this->idUser, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error", $stmt->error;
            return false;
        }
    }
}
