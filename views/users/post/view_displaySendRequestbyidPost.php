<?php include('../layout/header.php'); ?>
<script src="//code.jquery.com/jquery.min.js"></script>

<!-- CSS của Images Grid -->
<script src="https://cdn.jsdelivr.net/gh/taras-d/images-grid/src/images-grid.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/taras-d/images-grid/src/images-grid.min.css" />
<?php

$token = $_SESSION['token'];
$idUser = $result['user']['idUser'];
$idPost = $_GET['idPost'];
$idNotice = $_GET['idNotice'];
$data = array(
    'idUser' => $idUser,
    'idPost' => $idPost,
    'idNotice' => $idNotice,
);
$json_data = json_encode($data);

$url = 'http://localhost:8000/website_openshare/controllers/users/post/getPostRequestByidPost.php';


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
            <p class="datanull">Không yêu cầu nào được gửi </p>
        </div>
        <?php
    } else {
        for ($i = 0; $i < count($data1); $i++) {
        ?>


            <div class="post-container">
                <div class="post-row">
                    <div class="user-profile">
                        <a href="../quanlytaikhoan/view_user.php?idUser=<?= $data1[$i]['idUser'] ?>"> <img src="<?= $data1[$i]['photoURL'] ?>" alt="" />
                        </a>
                        <div>
                            <a href="../quanlytaikhoan/view_user.php?idUser=<?= $data1[$i]['idUser'] ?>">
                                <p><?= $data1[$i]['name'] ?></p>
                            </a>
                            <span><?= $data1[$i]['postDate'] ?></span>
                        </div>
                        <div class="address">
                            <p><i class="fa-solid fa-location-dot"></i> <?= explode(",",  $data1[$i]['address'])[0] ?></p>
                        </div>
                        <div class="type">
                            <a href="../post/view_displayPostWithType.php?idType=<?= $data1[0]['idType'] ?>">
                                <p><?= $data1[$i]['nameType'] ?></p>
                            </a>
                        </div>
                        <div class=" status_post">
                            <p><?php if ($data1[$i]['status'] == 0) {
                                    echo "Đang yêu cầu";
                                } elseif ($data1[$i]['status'] == 1) {
                                    echo "Đã được duyệt";
                                } elseif ($data1[$i]['status'] == 2) {
                                    echo "Bị Từ chối";
                                } else if ($data1[$i]['status'] == 3) {
                                    echo "Đã nhận";
                                } else if ($data1[$i]['status'] == 4) {
                                    echo "Từ chối nhận";
                                }
                                ?></p>
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

                    <div class="post-profile-icon">

                        <div style="cursor:pointer">
                            <div data-bs-toggle="modal" data-bs-target="#request<?php echo $data1[$i]['idPost'] ?>"><img src="../assests/images/detail_request_icon.png"> <small> Chi tiết yêu cầu </small></div>

                            <div class=" modal fade" id="request<?php echo $data1[$i]['idPost'] ?>" tabindex="-1" aria-labelledby="Label_Edit" aria-hidden="true">
                                <div class="modal-dialog modal-lg ">
                                    <!-- modal-xl -->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="Label_Edit">Chi tiết yêu cầu</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">

                                            <div class="row mb-3">
                                                <label for="message" class="col-md-4 col-lg-3 col-form-label">Tin nhắn</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <textarea class="form-control" id="message" name="message" placeholder="Mô tả ..." rows="3" disabled><?= $data1[$i]['message'] ?></textarea>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="dateRequest" class="col-md-4 col-lg-3 col-form-label">Thời gian yêu cầu</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <textarea class="form-control" id="dateRequest" name="dateRequest" placeholder="Mô tả ..." rows="1" disabled><?= $data1[$i]['requestDate'] ?></textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>
                        <?php if ($data1[$i]['status'] == 1 || $data1[$i]['status'] == 3 || $data1[$i]['status'] == 4) : ?>
                            <div style="cursor:pointer; margin-left: 20px;">
                                <div data-bs-toggle="modal" data-bs-target="#response<?php echo $data1[$i]['idPost'] ?>"><img src="../assests/images/icon_response.png"> <small>Yêu cầu được phản hồi </small></div>

                                <div class=" modal fade" id="response<?php echo $data1[$i]['idPost'] ?>" tabindex="-1" aria-labelledby="Label_Edit" aria-hidden="true">
                                    <div class="modal-dialog modal-lg ">
                                        <!-- modal-xl -->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="Label_Edit">Yêu cầu phản hồi</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">

                                                <div class="row mb-3">
                                                    <label for="message" class="col-md-4 col-lg-3 col-form-label">Tin nhắn phản hồi</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <textarea class="form-control" id="message" name="message" rows="3" disabled><?= $data1[$i]['messageResponse'] ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="dateRequest" class="col-md-4 col-lg-3 col-form-label">Thời gian duyệt yêu cầu</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <textarea class="form-control" id="dateRequest" name="dateRequest" placeholder="Mô tả ..." rows="1" disabled><?= $data1[$i]['reviewDay'] ?></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                            </div>
                        <?php endif ?>
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