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
    public $nameType;
    public $photoURL;
    // connect db
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function displayunapprovPost()
    {
        $query = "SELECT * FROM baiviet,user,doanhmuc where isShow=0 and baiviet.idUser = user.idUser and baiviet.idType=doanhmuc.idType ORDER BY idPost DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function displayapprovPost()
    {
        $query = "SELECT *FROM baiviet,user,doanhmuc where isShow=1 and baiviet.idUser = user.idUser and baiviet.idType=doanhmuc.idType ORDER BY idPost DESC";
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
        // Thong bao cho nguoi dung ve bai da duyet
        $query1 = "INSERT INTO thongbaoduyetbai (user_id, post_id, messagefromAdmin, created_at,titlePost) 
        VALUES (:user_id,:post_id, 'Bài viết của bạn đã được duyệt', NOW(),:titlePost)";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->bindValue(':post_id', $this->idPost, PDO::PARAM_INT);
        $stmt1->bindValue(':user_id', $this->idUser, PDO::PARAM_INT);
        $stmt1->bindValue(':titlePost', $this->title, PDO::PARAM_STR);
        if ($stmt->execute() && $stmt1->execute()) {
            return true;
        } else {
            echo "Duyệt thất bại";
            return false;
        }
    }
    public function rejectPost()
    {
        $query = "UPDATE baiviet SET isShow=2,idStaffApprove=:idStaffApprove where idPost =:idPost";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':idPost', $this->idPost, PDO::PARAM_INT);
        $stmt->bindValue(':idStaffApprove', $this->idStaffApprove, PDO::PARAM_INT);


        // Thong bao cho nguoi dung ve bai da duyet
        $query1 = "INSERT INTO thongbaoduyetbai (user_id, post_id, messagefromAdmin, created_at,titlePost) 
        VALUES (:user_id,:post_id, 'Cảm ơn bạn đã đóng góp đồ dùng cho cộng đồng, tuy nhiên đồ dùng của bạn không phù hợp với tiêu chuẩn cộng đồng ', NOW(),:titlePost)";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->bindValue(':post_id', $this->idPost, PDO::PARAM_INT);
        $stmt1->bindValue(':user_id', $this->idUser, PDO::PARAM_INT);
        $stmt1->bindValue(':titlePost', $this->title, PDO::PARAM_STR);
        if ($stmt->execute() && $stmt1->execute()) {
            return true;
        } else {
            echo "Duyệt thất bại";
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
