<?php include('../layout/header.php'); ?>
<script src="//code.jquery.com/jquery.min.js"></script>

<!-- CSS của Images Grid -->
<script src="https://cdn.jsdelivr.net/gh/taras-d/images-grid/src/images-grid.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/taras-d/images-grid/src/images-grid.min.css" />
<?php

$token = $_SESSION['token'];
$idUser = $_GET['idUser'];
$data = array(
    'id_Userget' => $idUser
);
$json_data = json_encode($data);

$url = 'http://localhost:8000/website_openshare/controllers/users/post/displayPostbyidUser.php';


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
<div class="profile-container">
    <div class="profile-details">
        <div class="pd-left">
            <div class="pd-row">
                <img src="<?= $data1[0]['photoURL'] ?>" alt="" class="pd-image" />
                <div>
                    <h3><?= $data1[0]['name']  ?></h3>
                    <?php

                    $token = $_SESSION['token'];
                    $idUser = $_GET['idUser'];
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
                    <p style="margin-left: 5px; font-size:15px">Đã Cho <span class="text-success"><?php if ($data5 == null) echo 0;
                                                                                                    else echo $data5[0]['SoluongdochoTC'] ?></span></p>

                </div>
            </div>
        </div>
    </div>

    <div class="profile-info">
        <div class="info-col">
            <div class="profile-intro">
                <div class="update-info">
                    <h3>Thông tin cơ bản</h3>
                </div>
                <hr />
                <ul>
                    <li>
                        <img src="../assests/images/email-icon2.png" alt="" /> <?php if ($result['user']['email'] == null) echo "Chưa cập nhật";
                                                                                else echo $result['user']['email'] ?>
                    </li>
                    <li>
                        <img src="../assests/images/icon-phone.png" alt="" /><?php if ($result['user']['phoneNumber'] == null) echo "Chưa cập nhật";
                                                                                else echo $result['user']['phoneNumber'] ?>
                    </li>
                </ul>
                <hr />
                <div class="update-info">
                    <h3>Địa chỉ</h3>
                    <!-- <button type="button" class="btn btn-primary btn-sm address_user" data-bs-toggle="modal" data-bs-target="#them">
                        Thêm
                    </button> -->
                </div>
                <hr />
                <ul>
                    <?php

                    $token = $_SESSION['token'];
                    $idUser = $result['user']['idUser'];
                    $data = array(
                        'idUser' => $idUser
                    );
                    $json_data = json_encode($data);

                    $url = 'http://localhost:8000/website_openshare/controllers/users/address/get.php';


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
                        $data2 = $data ? $data['data'] : null;
                    }

                    // Đóng cURL session
                    curl_close($curl);
                    ?>

                    <?php
                    if ($data2 == null) { ?>
                        <li>
                            <img src="../assests/images/profile-location.png" alt="" />Chưa cập nhật
                        </li>
                        <?php } else {

                        for ($i = 0; $i < count($data2); $i++) { ?>
                            <li>
                                <img src="../assests/images/profile-location.png" alt="" /><?= $data2[$i]['address'] ?>

                            </li>
                    <?php }
                    } ?>
                </ul>
            </div>
        </div>
        <div class="post-col">

            <?php
            if ($data1 == null) {
            ?>
                <div class="post-container">
                    <p class="datanull">Không có bài đăng nào </p>
                </div>
                <?php
            } else {
                for ($i = 0; $i < count($data1); $i++) {
                ?>


                    <div class="post-container">
                        <div class="post-row">
                            <div class="user-profile">
                                <a href="#"> <img src="<?= $data1[$i]['photoURL'] ?>" alt="" />
                                </a>
                                <div>
                                    <a href="#">
                                        <p><?= $data1[$i]['name'] ?></p>
                                    </a>
                                    <span><?= $data1[$i]['postDate'] ?></span>
                                </div>
                                <div class="address">
                                    <p><i class="fa-solid fa-location-dot"></i> <?= explode(",",  $data1[$i]['address'])[0] ?></p>
                                </div>
                                <div class="type">
                                    <a href="#">
                                        <p><?= $data1[$i]['nameType'] ?></p>
                                    </a>
                                </div>
                                <div class="status_post">
                                    <p><?php if ($data1[$i]['isShow'] == 0) {
                                            echo "Đang đợi duyệt";
                                        } elseif ($data1[$i]['isShow'] == 1 && $data1[$i]['soluongdocho'] > 0) {
                                            echo "Đang cho";
                                        } elseif ($data1[$i]['isShow'] == 1 && $data1[$i]['soluongdocho'] == 0) {
                                            echo "Cho thành công";
                                        } else if ($data1[$i]['isShow'] == 2) {
                                            echo "Bị từ chối";
                                        }
                                        ?></p>
                                </div>
                            </div>
                            <?php if ($data1[$i]['isShow'] == 0) : ?>
                                <i class="fas fa-ellipsis-v toggle<?= $i ?>" style="cursor:pointer"></i>
                                <div class="menu-child menu<?= $i ?>">
                                    <ul class="child">
                                        <li>
                                            <form action="../post/view_deletePost.php" method="post" id="form_delete<?= $i ?>">
                                                <a href="#" onclick="document.getElementById('form_delete<?= $i ?>').submit()">Xoá bài cho</a>
                                                <input type="hidden" name="deletePost" value="<?= $data1[$i]['idPost'] ?>">
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                                <script>
                                    document.querySelector('.toggle<?= $i ?>').addEventListener('click', function() {
                                        document.querySelector('.menu<?= $i ?>').classList.toggle('active');
                                    });
                                </script>
                            <?php endif; ?>
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
                        <div class="post-row">
                            <div class="activity-icons">
                                <div>
                                    <img src="../assests/images/like-blue.png" alt="" />
                                    120
                                </div>
                                <div>
                                    <img src="../assests/images/comments.png" alt="" />
                                    45
                                </div>
                                <div>
                                    <img src="../assests/images/share.png" alt="" />
                                    20
                                </div>
                            </div>
                            <div class="post-profile-icon">
                                <img src="../assests/images/profile-pic.png" alt="" />
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

                <?php } ?>
            <?php } ?>
        </div>
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
<?php include('../layout/footer.php'); ?>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
<script src="../assests/handle_address.js"></script>