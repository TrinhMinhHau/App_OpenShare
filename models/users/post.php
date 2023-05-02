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
    public $statusPost;
    public $name;
    public $photoURL;
    public $nameType;
    public $id_Userget;
    public $message;
    public $idRequest;
    public $soluongdocho;
    public $reviewDay;
    public $messageResponse;
    public $SoluongdochoTC;
    // public $offset;
    // public $limit;
    // connect db
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function loadMoreApi()
    {
        $offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
        $limit = isset($_GET['limit']) ? $_GET['limit'] : 5;
        // Thiết lập các tham số cho truy vấn
        $query = "SELECT * FROM `baiviet`,user,doanhmuc where isShow=1 and soluongdocho>0 and user.idUser = baiviet.idUser and baiviet.idType=doanhmuc.idType order by baiviet.idPost desc LIMIT $limit OFFSET $offset";
        $stmt = $this->conn->prepare($query);
        // $stmt->bindValue(':limit', $this->limit, PDO::PARAM_INT);
        // $stmt->bindValue(':offset', $this->offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }
    public function numberItemGiveSuccess()
    {
        $query = "SELECT count('idPost') as SoluongdochoTC
        FROM baiviet bv
        INNER JOIN yeucau yc ON bv.idPost = yc.idPost
        WHERE bv.idUser =:idUser and yc.status=3";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':idUser', $this->idUser, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function displayTop10()
    {
        $query = "SELECT bv.idUser, COUNT(bv.idPost) as SoluongdochoTC, u.name,u.photoURL 
        FROM baiviet bv 
        INNER JOIN yeucau yc ON bv.idPost = yc.idPost
        INNER JOIN user u ON bv.idUser = u.idUser
        WHERE yc.status = 3 
        GROUP BY bv.idUser
        LIMIT 10";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function displayRequest()
    {
        $query = "SELECT yc.idRequest, yc.idPost, yc.idUserRequest, yc.message, yc.requestDate,yc.status,
            p.title, p.description, p.postDate, p.address, p.photos, p.idType,u.name,d.nameType,u.photoURL,yc.messageResponse,yc.reviewDay
            FROM yeucau yc 
            JOIN baiviet p ON yc.idPost = p.idPost
            JOIN user u ON u.idUser= p.idUser
            JOIN doanhmuc d ON d.idType = p.idType
            WHERE yc.idUserRequest =:idUser
            ORDER BY yc.idRequest desc ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':idUser', $this->idUser, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function displayManegerRequest()
    {
        $query = "SELECT yc.idRequest, yc.idPost, yc.idUserRequest, yc.message, yc.idUserRequest, yc.requestDate, yc.status,
        p.title, p.description, p.postDate, p.address, p.photos, p.idType,u.name,d.nameType,u.photoURL
        FROM yeucau yc
        JOIN baiviet p ON yc.idPost = p.idPost
        JOIN user u ON u.idUser= yc.idUserRequest
        JOIN doanhmuc d ON d.idType = p.idType
        WHERE p.idUser =:idUser
        ORDER BY yc.idRequest desc";
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
        $stmt->bindValue(':description', $this->description, PDO::PARAM_STR);
        $stmt->bindValue(':address', $this->address, PDO::PARAM_STR);
        $stmt->bindValue(':photos', $this->photos, PDO::PARAM_STR);
        $stmt->bindValue(':idType', $this->idType, PDO::PARAM_INT);
        $stmt->bindValue(':idUser', $this->idUser, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error", $stmt->error;
            return false;
        }
    }

    public function requestPost()
    {
        $check_requestPost = "SELECT idUserRequest,idPost FROM `yeucau` WHERE  `idUserRequest`=:idUserRequest and `idPost`=:idPost";
        $check_requestPost_stmt = $this->conn->prepare($check_requestPost);
        $check_requestPost_stmt->bindValue(':idUserRequest', $this->idUserRequest, PDO::PARAM_INT);
        $check_requestPost_stmt->bindValue(':idPost', $this->idPost, PDO::PARAM_INT);
        $check_requestPost_stmt->execute();

        if ($check_requestPost_stmt->rowCount()) :
            echo "Người dùng này đã yêu cầu";
        else :
            $query = "INSERT INTO `yeucau` SET idUserRequest=:idUserRequest,idPost=:idPost,message=:message";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':idPost', $this->idPost, PDO::PARAM_INT);
            $stmt->bindValue(':idUserRequest', $this->idUserRequest, PDO::PARAM_INT);
            $stmt->bindValue(':message', $this->message, PDO::PARAM_STR);
        endif;
        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error", $stmt->error;
            echo $stmt->error;
            return false;
        }
    }
    public function search()
    {

        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        $query = "SELECT * FROM `baiviet`, user, doanhmuc
        WHERE isShow=1 
        AND soluongdocho>0 
        AND user.idUser = baiviet.idUser 
        AND baiviet.idType=doanhmuc.idType 
        AND (baiviet.address LIKE :keyword OR doanhmuc.nameType LIKE :keyword OR baiviet.description LIKE :keyword)
        ORDER BY baiviet.idPost DESC
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':keyword', '%' . $keyword  . '%', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt;
    }
    public function search_Type()
    {
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        $idType = isset($_GET['idType']) ? $_GET['idType'] : 7;
        $query = "SELECT * FROM `baiviet`, user, doanhmuc
        WHERE isShow=1 
        AND soluongdocho>0 
        AND user.idUser = baiviet.idUser 
        AND baiviet.idType=doanhmuc.idType and doanhmuc.idType=:idType 
        AND (baiviet.address LIKE :keyword OR doanhmuc.nameType LIKE :keyword OR baiviet.description LIKE :keyword)
        ORDER BY baiviet.idPost DESC
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':idType', $idType, PDO::PARAM_INT);

        $stmt->bindValue(':keyword', '%' . $keyword  . '%', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt;
    }
    public function search_page()
    {

        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        $offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
        $limit = isset($_GET['limit']) ? $_GET['limit'] : 5;
        $query = "SELECT * FROM `baiviet`, user, doanhmuc
        WHERE isShow=1 
        AND soluongdocho>0 
        AND user.idUser = baiviet.idUser 
        AND baiviet.idType=doanhmuc.idType 
        AND (baiviet.address LIKE :keyword OR doanhmuc.nameType LIKE :keyword OR baiviet.description LIKE :keyword)
        ORDER BY baiviet.idPost DESC LIMIT $limit OFFSET $offset
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':keyword', '%' . $keyword  . '%', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt;
    }
    public function displayItem()
    {
        $query = "SELECT * FROM `baiviet`,user,doanhmuc where isShow=1 and soluongdocho>0 and user.idUser = baiviet.idUser and baiviet.idType=doanhmuc.idType order by baiviet.idPost desc";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function displayPostbyType()
    {
        $query = "SELECT * FROM `baiviet`,user,doanhmuc where  isShow=1 and soluongdocho>0 and user.idUser = baiviet.idUser and baiviet.idType=doanhmuc.idType and doanhmuc.idType=:idType order by baiviet.idPost desc";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':idType', $this->idType, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }
    public function displayPostbyidUser()
    {
        $query = "SELECT * FROM `baiviet`,user,doanhmuc where user.idUser = baiviet.idUser and baiviet.idType=doanhmuc.idType and baiviet.idUser =:id_Userget  order by baiviet.idPost desc";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id_Userget', $this->id_Userget, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }
    public function displayItemWithType()
    {
        $query = "SELECT * FROM `baiviet` where idType=:idType";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':idType', $this->idType, PDO::PARAM_INT);

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

    public function deleteRequest()
    {
        $query_2 = "DELETE FROM yeucau WHERE idRequest=:idRequest";
        $stmt2 = $this->conn->prepare($query_2);
        $stmt2->bindParam(':idRequest', $this->idRequest, PDO::PARAM_INT);

        if ($stmt2->execute()) {
            return true;
        } else {
            echo "Xóa thất bại";
            return false;
        }
    }
}
