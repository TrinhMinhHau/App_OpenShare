<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require __DIR__ . '/../../../configs/database.php';
require __DIR__ . '/../../../configs/jwtHandler.php';


function msg($success, $status, $message, $extra = [])
{
    return array_merge([
        'success' => $success,
        'status' => $status,
        'message' => $message
    ], $extra);
}

$db_connection = new db();
$conn = $db_connection->connect();

$data = json_decode(file_get_contents("php://input"));
$returnData = [];

// IF REQUEST METHOD IS NOT EQUAL TO POST
if ($_SERVER["REQUEST_METHOD"] != "POST") :
    $returnData = msg(0, 404, 'Page Not Found!');

// CHECKING EMPTY FIELDS
elseif (
    !isset($data->userName)
    || !isset($data->password)
    || empty(trim($data->userName))
    || empty(trim($data->password))
) :

    $fields = ['fields' => ['userName', 'password']];
    $returnData = msg(0, 422, 'Vui lòng điền tất cả các trường!', $fields);

// IF THERE ARE NO EMPTY FIELDS THEN-
else :
    $userName = trim($data->userName);
    $password = trim($data->password);

    // CHECKING THE EMAIL FORMAT (IF INVALID FORMAT)
    if (strlen($userName) < 6) :
        $returnData = msg(0, 422, 'Tài khoản không được nhỏ hơn 6 ký tự!');

    // IF PASSWORD IS LESS THAN 8 THE SHOW THE ERROR
    elseif (strlen($password) < 8) :
        $returnData = msg(0, 422, 'Mật khẩu phải lớn hơn 7 ký tự!');

    // THE USER IS ABLE TO PERFORM THE LOGIN ACTION
    else :
        try {

            $fetch_user_by_userName = "SELECT * FROM `user` WHERE `userName`=:userName";
            $query_stmt = $conn->prepare($fetch_user_by_userName);
            $query_stmt->bindValue(':userName', $userName, PDO::PARAM_STR);
            $query_stmt->execute();

            // IF THE USER IS FOUNDED BY EMAIL
            if ($query_stmt->rowCount()) :
                $row = $query_stmt->fetch(PDO::FETCH_ASSOC);
                $check_password = password_verify($password, $row['password']);
                $checkBan = $row['isBan'];

                // VERIFYING THE PASSWORD (IS CORRECT OR NOT?)
                // IF PASSWORD IS CORRECT THEN SEND THE LOGIN TOKEN
                if ($checkBan == 1) :
                    $returnData = msg(0, 422, 'Tài khoản đã bị khóa!');
                else :
                    if ($check_password) :

                        $jwt = new JwtHandler();
                        $token = $jwt->jwtEncodeData(
                            'http://localhost/App_OpenShare/',
                            array("user_id" => $row['idUser'])
                        );

                        $returnData = [
                            'success' => 1,
                            'message' => 'Bạn đã đăng nhập thành công.',
                            'token' => $token
                        ];

                    // IF INVALID PASSWORD
                    else :
                        $returnData = msg(0, 422, 'Password không đúng!');
                    endif;
                endif;

            // IF THE USER IS NOT FOUNDED BY EMAIL THEN SHOW THE FOLLOWING ERROR
            else :
                $returnData = msg(0, 422, 'Tên đăng nhập không đúng!');
            endif;
        } catch (PDOException $e) {
            $returnData = msg(0, 500, $e->getMessage());
        }

    endif;

endif;

echo json_encode($returnData);
