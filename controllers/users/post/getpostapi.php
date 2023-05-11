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
    // $data = json_decode(file_get_contents("php://input"));
    // $Item->offset = $data->offset;
    // $Item->limit = $data->limit;
    $display = $Item->loadMoreApi();
    $num = $display->rowCount();

    if ($num > 0) {
        $question_array = [];
        $question_array['data'] = [];
        while ($row = $display->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $ManagerType_item = array(
                'idPost' =>  $idPost,
                'title' => $title,
                'description' => $description,
                'isShow' => $isShow,
                'postDate' => $postDate,
                'address' => $address,
                'idStaffApprove' => $idStaffApprove,
                'photos' => $photos,
                'idUser' => $idUser,
                'idType' => $idType,
                'name' => $name,
                'photoURL' => $photoURL,
                'nameType' => $nameType,
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
