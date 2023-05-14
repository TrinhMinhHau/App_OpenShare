<script src="//code.jquery.com/jquery.min.js"></script>

<!-- CSS của Images Grid -->
<script src="https://cdn.jsdelivr.net/gh/taras-d/images-grid/src/images-grid.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/taras-d/images-grid/src/images-grid.min.css" />
<?php

$token = $_SESSION['token'];
$idUser = $result['user']['idUser'];
$data = array(
    'idUser' => $idUser
);
$json_data = json_encode($data);

$url = 'http://localhost:8000/website_openshare/controllers/users/post/manegerRequest.php';


// Khởi tạo một cURL session
$curl = curl_init();

// Thiết lập các tùy chọn cho cURL session
curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_POSTFIELDS => $json_data,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        "Accept: application/json",
        "Authorization: Bearer {$token}",
    )
));

// Thực hiện yêu cầu cURL và lấy kết quả trả về
$response = curl_exec($curl);

// Kiểm tra nếu có lỗi xảy ra
if (curl_error($curl)) {
    echo 'Error: ' . curl_error($curl);
} else {
    // Xử lý kết quả trả về
    $data = json_decode($response, true);
    $data1 = $data ? $data['data'] : null;
}

// Đóng cURL session
curl_close($curl);
?>
<!--Profile Page-->

<div class="page" style="margin-top:20px;">

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="../TrangChu/index.php">Trang chủ</a></li>
        <li class="breadcrumb-item active">Lịch sử cho </li>
    </ol>

</div>
<div class="profile-details displayRequest">
    <div class="pd-left">
        <div class="pd-row">
            <img src="<?= $result['user']['photoURL'] ?>" alt="" class="pd-image" />
            <div>
                <h3><?= $result['user']['name'] ?></h3>
                <?php

                $token = $_SESSION['token'];
                $idUser = $result['user']['idUser'];
                $data = array(
                    'idUser' => $idUser
                );
                $json_data = json_encode($data);

                $url = 'http://localhost:8000/website_openshare/controllers/users/post/displaynumberItemGiveSuccess.php';


                // Khởi tạo một cURL session
                $curl = curl_init();

                // Thiết lập các tùy chọn cho cURL session
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $url,
                    CURLOPT_POSTFIELDS => $json_data,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        "Accept: application/json",
                        "Authorization: Bearer {$token}",
                    )
                ));

                // Thực hiện yêu cầu cURL và lấy kết quả trả về
                $response = curl_exec($curl);

                // Kiểm tra nếu có lỗi xảy ra
                if (curl_error($curl)) {
                    echo 'Error: ' . curl_error($curl);
                } else {
                    // Xử lý kết quả trả về
                    $data = json_decode($response, true);
                    $data5 = $data ? $data['data'] : null;
                }

                // Đóng cURL session
                curl_close($curl);
                ?>
                <p style="margin-left: 5px; font-size:15px;" class="text-bold">Đã Cho <span class="text-success"><?php if ($data5 == null) echo 0;
                                                                                                                    else echo $data5[0]['SoluongdochoTC'] ?></span></p>

            </div>
        </div>
    </div>

</div>


<div class="post-col displayRequest">

    <?php
    if ($data1 == null) {
    ?>
        <div class="post-container">
            <p class="datanull">Chưa có yêu cầu nào được gửi đến bạn !!! </p>
        </div>
        <?php
    } else {
        $currentIdPost = null;
        $dem = 0;
        for ($i = 0; $i < count($data1); $i++) { ?>
            <?php if ($data1[$i]['status'] === 3) : ?>
                <?php $dem++; ?>
                <?php if ($data1[$i]['idPost'] !== $currentIdPost) : ?>
                    <div class="post-container">
                        <div class="post-row">
                            <div class="user-profile">
                                <a href="../quanlytaikhoan/view_profile.php"> <img src=" <?= $result['user']['photoURL'] ?>" alt="" />
                                </a>
                                <div>
                                    <a href="../quanlytaikhoan/view_profile.php">
                                        <p><?= $result['user']['name'] ?></p>
                                    </a>
                                    <span><?= $data1[$i]['postDate'] ?></span>
                                </div>
                                <div class="address">
                                    <p><i class="fa-solid fa-location-dot"></i> <?= explode(",",  $data1[$i]['address'])[0] ?></p>
                                </div>
                                <div class="type">
                                    <a href=" ../post/view_displayPostWithType.php?idType=<?= $data1[$i]['idType'] ?>">
                                        <p><?= $data1[$i]['nameType'] ?></p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <p class="post-text">
                            <?= $data1[$i]['description'] ?>
                        </p>
                        <div id="post-image<?php echo $i ?>">
                            <?php
                            if ($data1[$i]['photos'] == null) {
                            } else {
                                $arr_img = [];
                                for ($j = 0; $j < count(json_decode($data1[$i]['photos'])); $j++) {
                                    array_push($arr_img, json_decode($data1[$i]['photos'])[$j]);
                                }
                            }
                            // var_dump($arr_img);
                            ?>
                        </div>
                        <hr>
                        <div class="post-row">


                        </div>
                    </div>
                    <?php $currentIdPost = $data1[$i]['idPost']; ?>
                    <p>

                        <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample<?= $data1[$i]['idPost'] ?>" aria-expanded="false" aria-controls="collapseExample">
                            Xem các yêu cầu thành công
                        </a>
                    </p>
                <?php endif; ?>

                <div class="collapse" id="collapseExample<?= $data1[$i]['idPost'] ?>" style="margin-bottom: 5px;">
                    <div class="card card-body">
                        <div class=" profile-request">
                            <div class="user-profile">
                                <a href="../quanlytaikhoan/view_user.php?idUser=<?= $data1[$i]['idUserRequest'] ?>"> <img src="<?= $data1[$i]['photoURL'] ?>" alt="" />
                                </a>
                                <div>
                                    <a href="../quanlytaikhoan/view_user.php?idUser=<?= $data1[$i]['idUserRequest'] ?>">
                                        <p><?= $data1[$i]['name'] ?></p>
                                    </a>
                                    <span><?= $data1[$i]['requestDate'] ?></span>
                                </div>
                            </div>
                            <div class="status_post">
                                <p><?php if ($data1[$i]['status'] == 0) {
                                        echo "Đang đợi";
                                    } elseif ($data1[$i]['status'] == 1) {
                                        echo "Đã duyệt";
                                    } elseif ($data1[$i]['status'] == 2) {
                                        echo "Từ chối";
                                    } else if ($data1[$i]['status'] == 3) {
                                        echo "Đã cho thành công";
                                    } else if ($data1[$i]['status'] == 4) {
                                        echo "Đã cho thất bại";
                                    }
                                    ?></p>
                            </div>
                        </div>

                        <div style="margin-bottom: 5px;">
                            <span><?= $data1[$i]['message'] ?></span>
                        </div>
                    </div>
                </div>


                <script>
                    $(document).ready(function() {
                        $("#post-image<?php echo $i ?>").imagesGrid({
                            images: <?= json_encode($arr_img) ?>,
                            align: false,
                            cells: 4,
                            nextOnClick: true,
                            showViewAll: "more",
                            getViewAllText: function() {},
                            onGridRendered: $.noop,
                            onGridItemRendered: $.noop,
                            onGridLoaded: $.noop,
                            onGridImageLoaded: $.noop,
                            onModalOpen: $.noop,
                            onModalClose: $.noop,
                            onModalImageClick: $.noop,
                            onModalImageUpdate: $.noop,
                        });
                    });
                </script>
            <?php endif; ?>
        <?php } ?>
        <?php if ($dem == 0) : ?>
            <div class="post-container">
                <p class="datanull">Chưa có yêu cầu nào được gửi đến bạn !!! </p>
            </div>
        <?php endif ?>
    <?php } ?>
</div>
<?php include('../post/view_post.php') ?>
</div>
<script>
    imgInpEl = document.getElementById('fileToUpload');
    imgEL = document.getElementById('img');

    imgInpEl.onchange = evt => {
        const [file] = imgInpEl.files
        if (file) {
            imgEL.src = URL.createObjectURL(file)
        }
    }
</script>
<script src="../assests/handle_address.js"></script>