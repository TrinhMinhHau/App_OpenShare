<?php include('../layout/header.php'); ?>
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
<div class="profile-container1">

    <?php if (isset($_SESSION['requestApprove_success'])) {
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['requestApprove_success'];
            unset($_SESSION['requestApprove_success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    } ?>
    <?php if (isset($_SESSION['requestApprove_error'])) {
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['requestApprove_error'];
            unset($_SESSION['requestApprove_error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    } ?>
    <?php if (isset($_SESSION['requestRefuse_success'])) {
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['requestRefuse_success'];
            unset($_SESSION['requestRefuse_success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    } ?>

    <div class="page">

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../TrangChu/index.php">Trang chủ</a></li>
            <li class="breadcrumb-item active">Yêu cầu đã nhận </li>
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
                <p class="datanull">Không yêu cầu nào được nhận </p>
            </div>
            <?php
        } else {
            $currentIdPost = null;
            for ($i = 0; $i < count($data1); $i++) { ?>
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
                        <?php

                        $token = $_SESSION['token'];
                        $idPost = $data1[$i]['idPost'];
                        $data = array(
                            'idPost' => $idPost
                        );
                        $json_data = json_encode($data);

                        $url = 'http://localhost:8000/website_openshare/controllers/users/post/getNumberRequestByidPost.php';


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
                            $data9 = $data ? $data['data'] : null;
                        }

                        // Đóng cURL session
                        curl_close($curl);
                        ?>
                        <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample<?= $data1[$i]['idPost'] ?>" aria-expanded="false" aria-controls="collapseExample">
                            Xem các yêu cầu <span>(<?= $data9[0]['soyeucau'] ?>)</span>
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

                        <div style="margin: 10px 0;">
                            <span>Yêu cầu được gửi đến:</span><span class="text-primary"> <?= $data1[$i]['message'] ?></span> <br />
                            <?php if ($data1[$i]['messageResponse']) : ?> <span>Phản hồi của bạn: </span><span class="text-primary"><?= $data1[$i]['messageResponse'] ?></span>
                            <?php endif; ?><br />
                            <?php if ($data1[$i]['messageAfterReceiveGood']) : ?> <span>Phản hồi từ người xin: </span><span class="text-primary"><?= $data1[$i]['messageAfterReceiveGood'] ?></span>
                            <?php endif; ?>

                        </div>
                        <?php if ($data1[$i]['status'] == 0) : ?>
                            <div>
                                <button class=" btn btn-primary" data-bs-toggle="modal" data-bs-target="#dongy<?= $data1[$i]['idRequest'] ?>">Đồng ý</button>

                                <div class="modal fade" id="dongy<?= $data1[$i]['idRequest'] ?>" tabindex="-1" aria-labelledby="Label_Edit" aria-hidden="true">
                                    <div class="modal-dialog modal-lg ">
                                        <!-- modal-xl -->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="Label_Edit">Đồng ý yêu cầu</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="../post/view_acceptRequest.php" method="post">
                                                <div class="modal-body">
                                                    <input type="hidden" name="idRequest" value="<?= $data1[$i]['idRequest'] ?>">
                                                    <input type="hidden" name="idPost" value="<?= $data1[$i]['idPost'] ?>">
                                                    <input type="hidden" name="idUserRequest" value="<?= $data1[$i]['idUserRequest']  ?>">
                                                    <div class="row mb-3">
                                                        <label for="message" class="col-md-4 col-lg-3 col-form-label">Tin nhắn</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <textarea class="form-control" id="message" name="message" placeholder="Nhập tin nhắn cho người yêu cầu ..." rows="3" required></textarea>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                    <button type="submit" name="acceptRequest" class="btn btn-primary">Đồng ý</button>
                                                </div>
                                            </form>


                                        </div>

                                    </div>
                                </div>
                                <button class=" btn btn-danger" data-bs-toggle="modal" data-bs-target="#tuchoi<?= $data1[$i]['idUserRequest'] ?>">Từ chối</button>

                                <div class="modal fade" id="tuchoi<?= $data1[$i]['idUserRequest'] ?>" tabindex="-1" aria-labelledby="Label_Edit" aria-hidden="true">
                                    <div class="modal-dialog modal-lg ">
                                        <!-- modal-xl -->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="Label_Edit">Từ chối yêu cầu</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="../post/view_refuseRequest.php" method="post">
                                                <div class="modal-body">
                                                    <input type="hidden" name="idRequest" value="<?= $data1[$i]['idRequest'] ?>">
                                                    <input type="hidden" name="idPost" value="<?= $data1[$i]['idPost'] ?>">
                                                    <input type="hidden" name="idUserRequest" value="<?= $data1[$i]['idUserRequest']  ?>">
                                                    <div class="form-group">
                                                        <label>Bạn có chắc chắn từ chối yêu cầu này hay không?</label>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                    <button type="submit" name="refuseRequest" class="btn btn-danger">Từ chối</button>
                                                </div>
                                            </form>


                                        </div>

                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
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
<script src="../assests/handle_address.js"></script>