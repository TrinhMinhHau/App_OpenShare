<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: PUT");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require __DIR__ . '/../../../configs/database.php';
$db_connection = new db();
$conn = $db_connection->connect();
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
$tendangnhap = $data->userName;
$email = $data->email;
$otp = $data->otp;
$fetch_user_by_userName = "SELECT * FROM `nhanvien` WHERE `userName`=? and email=? and otp = ?";
$query_stmt = $conn->prepare($fetch_user_by_userName);
$query_stmt->execute([$tendangnhap, $email, $otp]);
if ($query_stmt->rowCount() == 0) {
    $returnData = msg(0, 422, 'Mã OTP không đúng');
} else {
    $matkhaumoi = substr(md5(rand(0, 999999)), 0, 8);
    $matkhaumahoa = password_hash($matkhaumoi, PASSWORD_DEFAULT);
    $sql = "Update nhanvien SET password = ? where userName = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$matkhaumahoa, $tendangnhap]);
    $returnData = msg(1, 201, 'Reset mật khẩu thành công!', ['newPassword' => $matkhaumoi]);
}
echo json_encode($returnData);
