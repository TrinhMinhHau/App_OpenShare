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

$url = 'http://localhost:8000/website_openshare/controllers/users/post/getRequest.php';


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
    <?php if (isset($_SESSION['give_Error'])) {
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['give_Error'];
            unset($_SESSION['give_Error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    } ?>
    <?php if (isset($_SESSION['give_success'])) {
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['give_success'];
            unset($_SESSION['give_success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    } ?>
    <?php if (isset($_SESSION['send_request_success'])) {
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['send_request_success'];
            unset($_SESSION['send_request_success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    } ?>
    <?php if (isset($_SESSION['status_delete_Request'])) {
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['status_delete_Request'];
            unset($_SESSION['status_delete_Request']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    } ?>
    <div class="page">

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../TrangChu/index.php">Trang chủ</a></li>
            <li class="breadcrumb-item active">Yêu cầu đã gửi</li>
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
                        <?php if ($data1[$i]['status'] == 0) : ?>
                            <i class="fas fa-ellipsis-v toggle<?= $i ?>" style="cursor:pointer"></i>
                            <div class="menu-child menu<?= $i ?>">
                                <ul class="child">
                                    <li>

                                        <form action="../post/view_deleteRequest.php" method="post" id="form_delete<?= $i ?>">
                                            <a href="#" onclick="document.getElementById('form_delete<?= $i ?>').submit()">Xoá yêu cầu</a>
                                            <input type="hidden" name="deleteRequest" value="<?= $data1[$i]['idRequest'] ?>">
                                        </form>

                                    </li>
                                </ul>
                            </div>
                            <script>
                                document.querySelector('.toggle<?= $i ?>').addEventListener('click', function() {
                                    document.querySelector('.menu<?= $i ?>').classList.toggle('active');
                                });
                            </script>
                        <?php endif ?>
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
                                                    <?php if ($data1[$i]['status'] === 1) : ?>
                                                        <div>
                                                            <label for="dateRequest" class="col-md-4 col-lg-3 col-form-label">Xác nhận hoàn tất</label>
                                                            <div id="reason-form_tc<?php echo $data1[$i]['idPost'] ?>" style="display: none;">
                                                                <form action="./view_detailsuccess.php" method="post">
                                                                    <div id="rating">
                                                                        <input type="radio" id="star5" name="rating" value="5" required />
                                                                        <label class="full" for="star5" title="Tuyệt vời - 5 sao"></label>
                                                                        <input type="radio" id="star4" name="rating" value="4" required />
                                                                        <label class="full" for="star4" title="tốt - 4 sao"></label>
                                                                        <input type="radio" id="star3" name="rating" value="3" required />
                                                                        <label class="full" for="star3" title="Sài được - 3 sao"></label>
                                                                        <input type="radio" id="star2" name="rating" value="2" required />
                                                                        <label class="full" for="star2" title="không tốt - 2 sao"></label>
                                                                        <input type="radio" id="star1" name="rating" value="1" required />
                                                                        <label class="full" for="star1" title="tệ - 1 sao"></label>
                                                                    </div>
                                                                    <div class=" media-body col-md-12 col-lg-12 mb-1">
                                                                        <textarea class="form-control" id="reason" name="reason" placeholder="Nhập phản hồi với người cho" rows="3" required></textarea>
                                                                    </div>
                                                                    <input type="hidden" name="idRequest" value="<?= $data1[$i]['idRequest'] ?>">
                                                                    <input type="hidden" name="idPost" value="<?= $data1[$i]['idPost'] ?>">
                                                                    <input type="hidden" name="idUserRequest" value="<?= $data1[$i]['idUserRequest']  ?>">
                                                                    <button type="submit" class="btn btn-success" name="Thanhcong">Thành công</button>
                                                                    <button type="button" class="btn btn-secondary" onclick="hideReasonForm_tc(<?php echo ($data1[$i]['idPost']) ?>)">Hủy</button>
                                                                </form>
                                                            </div>
                                                            <div id="reason-form_tb<?php echo $data1[$i]['idPost'] ?>" style="display: none;">
                                                                <form action="./view_detailerror.php" method="post">
                                                                    <div class=" media-body col-md-12 col-lg-12 mb-1">
                                                                        <textarea class="form-control" id="reason" name="reason" placeholder="Nhập phản hồi với người cho" rows="3" required></textarea>
                                                                    </div>
                                                                    <input type="hidden" name="idRequest" value="<?= $data1[$i]['idRequest'] ?>">
                                                                    <input type="hidden" name="idPost" value="<?= $data1[$i]['idPost'] ?>">
                                                                    <input type="hidden" name="idUserRequest" value="<?= $data1[$i]['idUserRequest']  ?>">
                                                                    <button type="submit" class="btn btn-danger" name="Tuchoi">Từ chối</button>
                                                                    <button type="button" class="btn btn-secondary" onclick="hideReasonForm_tb(<?php echo ($data1[$i]['idPost']) ?>)">Hủy</button>
                                                                </form>
                                                            </div>
                                                            <button type="submit" class="btn btn-success" id="thanhcong<?php echo ($data1[$i]['idPost']) ?>" onclick="showReasonForm_tc(<?php echo ($data1[$i]['idPost']) ?>)">Nhận đồ thành công</button>
                                                            <button type="submit" class="btn btn-danger" id="tuchoi<?php echo ($data1[$i]['idPost']) ?>" onclick="showReasonForm_tb(<?php echo ($data1[$i]['idPost']) ?>)">Nhận đồ thất bại </button>
                                                        </div>
                                                    <?php else : ?>
                                                        <div class="row mb-3">
                                                            <label for="message" class="col-md-4 col-lg-3 col-form-label">Tin nhắn xác nhận</label>
                                                            <div class="col-md-8 col-lg-9">
                                                                <textarea class="form-control" id="message" name="message" rows="3" disabled><?= $data1[$i]['messageAfterReceiveGood'] ?></textarea>
                                                            </div>
                                                        </div>
                                                        <?php if ($data1[$i]['status'] == 3) : ?>

                                                            <div class="row mb-3">
                                                                <label for="star" class="col-md-4 col-lg-3 col-form-label">Đánh giá của bạn:</label>
                                                                <div class="col-md-8 col-lg-9 mt-2">
                                                                    <?php if ($data1[$i]['ratingStar'] == 1) : ?>
                                                                        <i class="bi bi-star-fill text-warning"></i>
                                                                    <?php elseif ($data1[$i]['ratingStar'] == 2) : ?>
                                                                        <i class="bi bi-star-fill text-warning"></i>
                                                                        <i class="bi bi-star-fill text-warning"></i>
                                                                    <?php elseif ($data1[$i]['ratingStar'] == 3) : ?>
                                                                        <i class="bi bi-star-fill text-warning"></i>
                                                                        <i class="bi bi-star-fill text-warning"></i>
                                                                        <i class="bi bi-star-fill text-warning"></i>
                                                                    <?php elseif ($data1[$i]['ratingStar'] == 4) : ?>
                                                                        <i class="bi bi-star-fill text-warning"></i>
                                                                        <i class="bi bi-star-fill text-warning"></i>
                                                                        <i class="bi bi-star-fill text-warning"></i>
                                                                        <i class="bi bi-star-fill text-warning"></i>
                                                                    <?php elseif ($data1[$i]['ratingStar'] == 5) : ?>
                                                                        <i class="bi bi-star-fill text-warning"></i>
                                                                        <i class="bi bi-star-fill text-warning"></i>
                                                                        <i class="bi bi-star-fill text-warning"></i>
                                                                        <i class="bi bi-star-fill text-warning"></i>
                                                                        <i class="bi bi-star-fill text-warning"></i>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>

                                                    <?php endif ?>
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
<script>
    function showReasonForm_tb(idPost) {
        document.getElementById("reason-form_tb" + idPost).style.display = "block";
        document.getElementById("thanhcong" + idPost).style.display = "none";
        document.getElementById("tuchoi" + idPost).style.display = "none";
    }

    function hideReasonForm_tb(idPost) {
        document.getElementById("reason-form_tb" + idPost).style.display = "none";
        document.getElementById("thanhcong" + idPost).style.display = "inline-block";
        document.getElementById("tuchoi" + idPost).style.display = "inline-block";
    }
</script>
<script>
    function showReasonForm_tc(idPost) {
        document.getElementById("reason-form_tc" + idPost).style.display = "block";
        document.getElementById("thanhcong" + idPost).style.display = "none";
        document.getElementById("tuchoi" + idPost).style.display = "none";
    }

    function hideReasonForm_tc(idPost) {
        document.getElementById("reason-form_tc" + idPost).style.display = "none";
        document.getElementById("thanhcong" + idPost).style.display = "inline-block";
        document.getElementById("tuchoi" + idPost).style.display = "inline-block";
    }
</script>
<?php include('../layout/footer.php'); ?>
<script src="../assests/handle_address.js"></script>