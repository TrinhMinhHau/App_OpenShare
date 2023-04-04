<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require __DIR__ . '/../../../configs/database.php';

require __DIR__ . '../../../AuthMiddleWare.php';
include('../../../models/admin/EmployeeManager.php');

$db = new db();
$connect = $db->connect();
$headers = getallheaders();
$auth = new Auth($connect, $headers);

// Validate the token
$auth_info = $auth->isValid();

// If the token is valid
if ($auth_info['success']) {
    $Employee = new EmployeeManager($connect);
    $display = $Employee->displayInfor();
    $num = $display->rowCount();

    if ($num > 0) {
        $question_array = [];
        $question_array['data'] = [];
        while ($row = $display->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $ManagerEmployee_item = array(
                'idStaff' =>  $idStaff,
                'userName' => $userName,
                // 'password' => $password,
                'email' => $email,
                'photoURL' => $photoURL,
                'address' => $address,
                'name' => $name,
                // 'idRole' => $idRole,
                'phoneNumber' => $phoneNumber,
                'isBan' => $isBan,

            );
            array_push($question_array['data'], $ManagerEmployee_item);
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
