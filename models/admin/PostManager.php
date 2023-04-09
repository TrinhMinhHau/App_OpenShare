<?php
class PostManager
{
    private $conn;

    //property
    public $idPost;
    public $title;
    public $description;
    public $isShow;
    public $postDate;
    public $address;
    public $idStaffApprove;
    public $photos;
    public $idUser;
    public $idType;
    public $name;
    // connect db
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function displayunapprovPost()
    {
        $query = "SELECT *FROM baiviet,user where isShow=0 and baiviet.idUser = user.idUser ORDER BY idPost DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function displayapprovPost()
    {
        $query = "SELECT *FROM baiviet,user where isShow=1 and baiviet.idUser = user.idUser ORDER BY idPost DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function approvPost()
    {
        $query = "UPDATE baiviet SET isShow=1,idStaffApprove=:idStaffApprove where idPost =:idPost";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':idPost', $this->idPost, PDO::PARAM_INT);
        $stmt->bindValue(':idStaffApprove', $this->idStaffApprove, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error", $stmt->error;
            return false;
        }
    }
    public function rejectPost()
    {
        $query = "UPDATE baiviet SET isShow=2,idStaffApprove=:idStaffApprove where idPost =:idPost";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':idPost', $this->idPost, PDO::PARAM_INT);
        $stmt->bindValue(':idStaffApprove', $this->idStaffApprove, PDO::PARAM_INT);



        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error", $stmt->error;
            return false;
        }
    }
    public function deletePost()
    {
        // Delete Baiviet
        $query_1 = "DELETE FROM baiviet WHERE idPost=:idPost";
        $stmt1 = $this->conn->prepare($query_1);

        //Bind value
        $stmt1->bindValue(':idPost', $this->idPost, PDO::PARAM_INT);

        // Delete Loaibaiviet


        if ($stmt1->execute()) {
            return true;
        } else {
            echo "Xóa thất bại";
            return false;
        }
    }
}
