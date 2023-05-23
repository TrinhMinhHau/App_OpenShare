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

if ($auth_info['success']) {
    $user = $auth_info['user'];

    // define response messages
    $success_message = 'refuse successfully.';
    $error_message = 'Failed to .refuse';
    $method_error_message = 'Method not allowed.';
    //Check api has token

    // check if request method is PUT
    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {

        // get request body as JSON
        $request_body = json_decode(file_get_contents('php://input'), true);

        // extract request parameters
        // $idChiTietYC = $request_body['idChiTietYC'];
        $idRequest = $request_body['idRequest'];
        $messageAfterReceiveGood = $request_body['messageAfterReceiveGood'];
        $idUserRequest = $request_body['idUserRequest'];
        $idPost = $request_body['idPost'];
        var_dump($request_body);
        // decode image data from base64
        // $image = base64_decode($image_data);

        // create image MIME type based on file extension
        // $image_mime = "data:image/" . strtolower(pathinfo($image_data, PATHINFO_EXTENSION)) . ";base64," . $image_data;

        // update user record in database
        // $update_query = "UPDATE chitietyeucau SET status=2 WHERE idChiTietYC=:idChiTietYC";
        // $update_stmt = $conn->prepare($update_query);

        // $query3="UPDATE baiviet SET statusPost = 0 WHERE idPost IN (SELECT idPost FROM chitietyeucau WHERE idRequest =:idRequest)";
        //  $query3_stmt = $conn->prepare($query3);

        // bind parameters to statement

        // $update_stmt->bindValue(':idChiTietYC', $idChiTietYC, PDO::PARAM_INT);
        $query3 = "UPDATE baiviet SET soluongdocho = soluongdocho+ 1 WHERE idPost IN (
            SELECT idPost
            FROM yeucau
            WHERE idRequest =:idRequest
          )";
        $query3_stmt = $conn->prepare($query3);
        $query3_stmt->bindValue(':idRequest', $idRequest, PDO::PARAM_INT);

        $update_query = "UPDATE yeucau SET status=4,messageAfterReceiveGood=:messageAfterReceiveGood,successDay=now() WHERE idRequest=:idRequest ";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bindValue(':idRequest', $idRequest, PDO::PARAM_INT);
        $update_stmt->bindValue(':messageAfterReceiveGood', $messageAfterReceiveGood, PDO::PARAM_STR);

        // chèn vào bảng thông báo.
        $query1 = "INSERT INTO `thongbaochonhan` SET idPostRequest_N=:idPost,idUserRequest_N=:idUserRequest,status_accept_reject = 3";
        $stmt1 = $conn->prepare($query1);
        $stmt1->bindValue(':idPost', $idPost, PDO::PARAM_INT);
        $stmt1->bindValue(':idUserRequest', $idUserRequest, PDO::PARAM_INT);
        // execute statement
        if ($update_stmt->execute() && $query3_stmt->execute() && $stmt1->execute()) {
            http_response_code(200);
            echo json_encode(['message' => $success_message]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => $error_message]);
        }
    } else {
        // return 405 Method Not Allowed for non-PUT requests
        http_response_code(405);
        echo json_encode(['error' => $method_error_message]);
    }
} else {
    // Return error response if the token is invalid
    echo json_encode([
        'success' => false,
        'message' => 'Token request not found',
    ]);
}
