<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

require __DIR__ . '/../../../configs/database.php';

require __DIR__ . '../../../AuthMiddleWare.php';
include('../../../models/admin/ItemManager.php');

$db = new db();
$connect = $db->connect();
$headers = getallheaders();
$auth = new Auth($connect, $headers);

// Validate the token
$auth_info = $auth->isValid();

// If the token is valid
if ($auth_info['success']) {
    $deleteItem = new ItemManager($connect);

    $data = json_decode(file_get_contents("php://input"));
    $deleteItem->idType = $data->idType;

    if ($deleteItem->deleteItem()) {
        echo json_encode(array('message', 'TypeItem is Deleted'));
    } else {
        echo json_encode(array('message', 'TypeItem is Not Deleted'));
    }
} else {
    // Return error response if the token is invalid
    echo json_encode([
        'success' => false,
        'message' => 'Token request not found',
    ]);
}
