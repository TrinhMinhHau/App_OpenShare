<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');
require __DIR__ . '/../../../configs/database.php';

require __DIR__ . '../../../AuthMiddleWare.php';
include('../../../models/admin/UserManager.php');

$db = new db();
$connect = $db->connect();
$User = new UserManager($connect);
$headers = getallheaders();
$auth = new Auth($connect, $headers);
// Validate the token
$auth_info = $auth->isValid();

// If the token is valid
if ($auth_info['success']) {
    $data = json_decode(file_get_contents("php://input"));
    $User->idUser = $data->idUser;


    if ($User->banUser()) {
        echo json_encode(array('message', 'Cấm tài khoản thành công'));
    } else {
        echo json_encode(array('message', 'Cấm tài khoản thất bại'));
    }
} else {
    // Return error response if the token is invalid
    echo json_encode([
        'success' => false,
        'message' => 'Token request not found',
    ]);
}
