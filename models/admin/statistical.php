<?php
class statistical
{
    private $conn;

    //property
    public $count;
    public $nameType;
    // connect db
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function displayTypefromPost()
    {
        $query = "SELECT doanhmuc.nameType, COUNT(*) AS count
        FROM baiviet
        JOIN doanhmuc ON baiviet.idType = doanhmuc.idType
        where baiviet.isShow = 1
        GROUP BY doanhmuc.nameType";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function displayAccountUser()
    {
        $query = "SELECT 
        CAST(YEAR(CreateAt) as char(4)) as year,
        MONTH(CreateAt) as month,
        COUNT(*) as countUser
        FROM user
        GROUP BY CAST(YEAR(CreateAt) as char(4)), MONTH(CreateAt)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function sumofUser()
    {
        $query = "SELECT 
        count(idUser) as countUser
        FROM user";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function sumofPost()
    {
        $query = "SELECT COUNT(idPost) as TongSoluongbaicho FROM `baiviet` WHERE isShow=1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function sumofItemSuccess()
    {
        $query = "SELECT COUNT(idRequest) as Soluongdochothanhcong FROM `yeucau` WHERE status=3";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
