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
        $success_message = 'refuse successfully.';
        $error_message = 'Failed to .refuse';
        $method_error_message = 'Method not allowed.';
        //Check api has token

        // check if request method is PUT
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {

            // get request body as JSON
            $request_body = json_decode(file_get_contents('php://input'), true);

            // extract request parameters
            $idRequest = $request_body['idRequest'];
            $message = $request_body['message'];


            var_dump($request_body);

            $update_query = "UPDATE yeucau SET status=1 WHERE idRequest=:idRequest ";
            $update_stmt = $conn->prepare($update_query);

            // bind parameters to statement

            //$query2 = "UPDATE yeucau SET status = 2 WHERE idRequest <> :idRequest and idPost = :idPost";

            //$query2_stmt = $conn->prepare($query2);


            $query3 = "UPDATE baiviet SET statusPost = 1 WHERE idPost IN (
              SELECT idPost
              FROM yeucau
              WHERE idRequest =:idRequest
            )";
            $query3_stmt = $conn->prepare($query3);


            $query4 = "INSERT INTO `chitietyeucau` SET idRequest=:idRequest,message=:message";

            $query4_stmt = $conn->prepare($query4);

            // $query2_stmt->bindValue(':idRequest', $idRequest, PDO::PARAM_INT);
            $query3_stmt->bindValue(':idRequest', $idRequest, PDO::PARAM_INT);
            $update_stmt->bindValue(':idRequest', $idRequest, PDO::PARAM_INT);
            $query4_stmt->bindValue(':idRequest', $idRequest, PDO::PARAM_INT);
            $query4_stmt->bindValue(':message', $message, PDO::PARAM_STR);


            // execute statement
            if ($update_stmt->execute() && $query3_stmt->execute() && $query4_stmt->execute()) {
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
} catch (\Throwable $th) {
    throw $th;
}
