<?php
session_start();
$token = $_SESSION['token'];
$name = $_POST['name'];

$password = $_POST['password'];
$userName = $_POST['userName'];
$url = 'http://localhost:8000/website_openshare/controllers/admin/staff/register.php';
$data = array(
    'name' => $name,

    'password' => $password,
    'userName' => $userName,
);

$options = array(
    CURLOPT_URL => $url,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => array(
        'Access-Control-Allow-Origin: *',
        'Access-Control-Allow-Methods: POST',
        'Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With',
        "Accept: application/json",
        "Authorization: Bearer {$token}",
    )
);

$curl = curl_init();
curl_setopt_array($curl, $options);
$response = curl_exec($curl);
curl_close($curl);
if ($response) {
    $result = json_decode($response, true);
}

if ($result["status"] == 422) {
?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert"> <?= $result["message"]; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
} else {
    //    
?>
    <div class="alert alert-success alert-dismissible fade show " id='dl' role="alert"> <?= "Tạo tài khoản thành công" ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}

?>