<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: PUT");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require __DIR__ . '/../../../configs/database.php';

require __DIR__ . '../../../AuthMiddleWareUsers.php';
$db_connection = new db();
$conn = $db_connection->connect();
$headers = getallheaders();
$auth = new AuthUsers($conn, $headers);

// Validate the token
$auth_info = $auth->isValid();

// If the token is valid
if ($auth_info['success']) {
    // Get the user information from the token
    //$user = $auth_info['user'];
    function msg($success, $status, $message, $extra = [])
    {
        return array_merge([
            'success' => $success,
            'status' => $status,
            'message' => $message
        ], $extra);
    }

    $data = json_decode(file_get_contents("php://input"));
    $returnData = [];
    $id = trim($data->id);
    $new_password = isset($data->new_password) ? trim($data->new_password) : '';
    $old_password = trim($data->old_password);
    try {

        $fetch_user_by_email = "SELECT * FROM `user` WHERE `idUser`=:id";
        $query_stmt = $conn->prepare($fetch_user_by_email);
        $query_stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $query_stmt->execute();

        // IF THE USER IS FOUNDED BY EMAIL
        if ($query_stmt->rowCount()) {
            $row = $query_stmt->fetch(PDO::FETCH_ASSOC);
            $check_password = password_verify($old_password, $row['password']);
            // VERIFYING THE PASSWORD (IS CORRECT OR NOT?)
            // IF PASSWORD IS CORRECT THEN SEND THE LOGIN TOKEN
            if ($check_password) {
                $query = "UPDATE user SET password=:password WHERE idUser=:id";
                $stmt = $conn->prepare($query);
                $stmt->bindValue(':password', password_hash($new_password, PASSWORD_DEFAULT), PDO::PARAM_STR);
                $stmt->bindValue(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                $returnData = msg(1, 201, 'Đổi mật khẩu thành công!');
            } else {
                $returnData = msg(0, 422, 'Mật khẩu hiện tại không chính xác!');
            }
        } else {
            $returnData = msg(0, 422, 'User not found');
        }
    } catch (PDOException $e) {
        $returnData = msg(0, 500, 'Error: ' . $e->getMessage());
    }
    echo json_encode($returnData);
} else {
    // Return error response if the token is invalid
    echo json_encode([
        'success' => false,
        'message' => 'Token request not found',
    ]);
}
