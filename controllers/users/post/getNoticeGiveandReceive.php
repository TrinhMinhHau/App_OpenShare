<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require __DIR__ . '/../../../configs/database.php';

require __DIR__ . '../../../AuthMiddleWareUsers.php';
include('../../../models/users/post.php');

$db = new db();
$connect = $db->connect();
$headers = getallheaders();
$auth = new AuthUsers($connect, $headers);

// Validate the token
$auth_info = $auth->isValid();

if ($auth_info['success']) {
    $Item = new Post($connect);
    $display = $Item->getNoticeGiveandReceive();
    $num = $display->rowCount();

    if ($num > 0) {
        $question_array = [];
        $question_array['data'] = [];
        while ($row = $display->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $ManagerType_item = array(
                'idNotice' => $idNotice,
                'idPost' =>  $idPostRequest_N,
                'name' => $name,
                'title' => $title,
                'createAt_N' => $createAt_N,
                'idUser' => $idUser,
                'photoURL' => $photoURL,
                'status_accept_reject' => $status_accept_reject,
                'message_N' => $message_N,
                'idUserRequest_N' => $idUserRequest_N,
                'issen_N' => $issen_N,
            );
            array_push($question_array['data'], $ManagerType_item);
        }
        echo json_encode($question_array);
    }
} else {
    // Return error response if the token is invalid
    echo json_encode([
        'success' => false,
        'message' => 'Token request not found',
    ]);
}
