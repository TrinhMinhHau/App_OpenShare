<?php
class EmployeeManager
{
    private $conn;

    //property
    public $idStaff;
    public $userName;
    public $password;
    public $email;
    public $photoURL;
    public $address;
    public $name;
    public $idRole;
    public $phoneNumber;
    public $isBan;
    // connect db
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function displayInfor()
    {
        $query = "SELECT * FROM nhanvien where idRole=0  ORDER BY idStaff DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function banEmployee()
    {
        $query = "UPDATE nhanvien SET isBan=1 WHERE idStaff=:idStaff";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':idStaff', $this->idStaff, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error", $stmt->error;
            return false;
        }
    }
    public function UnbanEmployee()
    {
        $query = "UPDATE nhanvien SET isBan=0 WHERE idStaff=:idStaff";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':idStaff', $this->idStaff, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error", $stmt->error;
            return false;
        }
    }
}
