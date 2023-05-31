<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: PUT");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require __DIR__ . '/../../../configs/database.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../../vendor/PHPMailer/src/Exception.php';
require '../../../vendor/PHPMailer/src/PHPMailer.php';
require '../../../vendor/PHPMailer/src/SMTP.php';
$mail = new PHPMailer(true);
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
$fetch_user_by_userName = "SELECT * FROM `nhanvien` WHERE `userName`=? and email=?";
$query_stmt = $conn->prepare($fetch_user_by_userName);
$query_stmt->execute([$tendangnhap, $email]);
if ($query_stmt->rowCount() == 0) {
    $returnData = msg(0, 422, 'Tên đăng nhập hoặc email không trùng khớp với cơ sở dữ liệu của chúng tôi');
} else {
    $matkhaumoi = substr(md5(rand(0, 999999)), 0, 8);
    $matkhaumahoa = password_hash($matkhaumoi, PASSWORD_DEFAULT);
    $sql = "Update nhanvien SET password = ? where userName = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$matkhaumahoa, $tendangnhap]);
    try {
        //Server settings
        $mail->SMTPDebug = 0;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers

        $mail->SMTPAuth = true;
        // Enable SMTP authentication
        $mail->Username = 'tmhaunct2001@gmail.com';                 // SMTP username
        $mail->Password = 'ooakwovagpxsevav';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('tmhaunct2001@gmail.com', "OpenShareApp");
        $mail->addAddress($email, $tendangnhap);     // Add a recipient              // Name is optional
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = "Mail Reset Password From Open Share";
        $mail->Body    = "Mật khẩu mới của bạn là:" . $matkhaumoi;
        $mail->send();
        $returnData = msg(1, 201, 'Reset mật khẩu thành công!');
    } catch (Exception $e) {
        $returnData = msg(0, 500, 'Error: ' . $mail->ErrorInfo);
    }
}
echo json_encode($returnData);
