<?php
// set headers to allow cross-origin resource sharing (CORS)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: PUT");
header("Content-Type: application/json; charset=UTF-8");
require __DIR__ . '/../../../configs/database.php';
require __DIR__ . '../../../AuthMiddleWareUsers.php';
$headers = getallheaders();
$db_connection = new db();
$conn = $db_connection->connect();
$auth = new AuthUsers($conn, $headers);
$auth_info = $auth->isValid();

try {
    //code...
    if ($auth_info['success']) {
        $user = $auth_info['user'];

        // define response messages
        $success_message = 'accept successfully';
        $error_message = 'Failed to accept';
        $method_error_message = 'Method not allowed.';
        //Check api has token

        // check if request method is PUT
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {

            // get request body as JSON
            $request_body = json_decode(file_get_contents('php://input'), true);

            // extract request parameters
            $idRequest = $request_body['idRequest'];
            $message = $request_body['message'];
            $idUserRequest = $request_body['idUserRequest'];
            $idPost = $request_body['idPost'];



            $check_sl = "SELECT soluongdocho FROM baiviet WHERE idPost IN (
                SELECT idPost
                FROM yeucau
                WHERE idRequest =:idRequest)";
            $check_sl_stmt = $conn->prepare($check_sl);
            $check_sl_stmt->bindValue(':idRequest', $idRequest, PDO::PARAM_INT);
            $check_sl_stmt->execute();
            $row = $check_sl_stmt->fetch(PDO::FETCH_ASSOC);
            $soluongdocho = $row['soluongdocho'];
            if ($soluongdocho <= 0) :
                echo json_encode(array('message', $error_message));
            else :
                $update_query = "UPDATE yeucau SET status=1,messageResponse=:message,reviewDay=now() WHERE idRequest=:idRequest ";
                $update_stmt = $conn->prepare($update_query);

                // bind parameters to statement

                //$query2 = "UPDATE yeucau SET status = 2 WHERE idRequest <> :idRequest and idPost = :idPost";

                //$query2_stmt = $conn->prepare($query2);


                // $query3 = "UPDATE baiviet SET statusPost = 1 WHERE idPost IN (
                //   SELECT idPost
                //   FROM yeucau
                //   WHERE idRequest =:idRequest
                // )";
                // $query3_stmt = $conn->prepare($query3);



                $query3 = "UPDATE baiviet SET soluongdocho = soluongdocho- 1 WHERE idPost IN (
              SELECT idPost
              FROM yeucau
              WHERE idRequest =:idRequest
            )";
                $query3_stmt = $conn->prepare($query3);

                // $query4 = "INSERT INTO `chitietyeucau` SET idRequest=:idRequest,message=:message";

                // $query4_stmt = $conn->prepare($query4);

                // // $query2_stmt->bindValue(':idRequest', $idRequest, PDO::PARAM_INT);
                $query3_stmt->bindValue(':idRequest', $idRequest, PDO::PARAM_INT);
                $update_stmt->bindValue(':idRequest', $idRequest, PDO::PARAM_INT);
                // $query4_stmt->bindValue(':idRequest', $idRequest, PDO::PARAM_INT);
                $update_stmt->bindValue(':message', $message, PDO::PARAM_STR);

                // chèn vào bảng thông báo.
                $query1 = "INSERT INTO `thongbaochonhan` SET idPostRequest_N=:idPost,idUserRequest_N=:idUserRequest, message_N='đã được chấp nhận',status_accept_reject = 1";
                $stmt1 = $conn->prepare($query1);
                $stmt1->bindValue(':idPost', $idPost, PDO::PARAM_INT);
                $stmt1->bindValue(':idUserRequest', $idUserRequest, PDO::PARAM_INT);


                // execute statement
                if ($update_stmt->execute() && $query3_stmt->execute() & $stmt1->execute()) {
                    echo json_encode(array('message', $success_message));
                } else {
                    echo json_encode(array('message', $error_message));
                }
            endif;
        } else {
            // return 405 Method Not Allowed for non-PUT requests
            echo json_encode(array('message', $method_error_message));
        }
    } else {
        // Return error response if the token is invalid
        echo json_encode([
            'success' => false,
            'message' => 'Token request not found',
        ]);
    }
} catch (\Throwable $th) {
    throw $th;
}
