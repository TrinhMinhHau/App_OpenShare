<?php
class ItemManager
{
    private $conn;

    //property
    public $idType;
    public $nameType;

    // connect db
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function displayItem()
    {
        $query = "SELECT * FROM doanhmuc ORDER BY idType DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function addItem()
    {
        $check_nameType = "SELECT `nameType` FROM `doanhmuc` WHERE  `nameType`=:nameType";
        $check_nameType_stmt = $this->conn->prepare($check_nameType);
        $check_nameType_stmt->bindValue(':nameType', $this->nameType, PDO::PARAM_STR);
        $check_nameType_stmt->execute();

        if ($check_nameType_stmt->rowCount()) :
            echo "Tên loại danh mục này đã tồn tại";
        else :
            $query = "INSERT INTO `doanhmuc`SET nameType=:nameType";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':nameType', $this->nameType, PDO::PARAM_STR);
            if ($stmt->execute()) {
                return true;
            } else {
                echo "Error", $stmt->error;
                return false;
            }
        endif;
    }
    public function deleteItem()
    {
        // Delete Baiviet
        $query_1 = "DELETE FROM baiviet WHERE idType=:idType";
        $stmt1 = $this->conn->prepare($query_1);

        //Bind value
        $stmt1->bindParam(':idType', $this->idType, PDO::PARAM_INT);

        // Delete Loaibaiviet
        $query_2 = "DELETE FROM doanhmuc WHERE idType=:idType";
        $stmt2 = $this->conn->prepare($query_2);

        //Bind value
        $stmt2->bindParam(':idType', $this->idType, PDO::PARAM_INT);

        if ($stmt1->execute() && $stmt2->execute()) {
            return true;
        } else {
            echo "Xóa thất bại";
            return false;
        }
    }
}
