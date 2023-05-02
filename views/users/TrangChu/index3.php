<?php include('../layout/header.php'); ?>

<!-- Thư viện jQuery -->
<script src="//code.jquery.com/jquery.min.js"></script>
<!-- CSS của Images Grid -->
<script src="https://cdn.jsdelivr.net/gh/taras-d/images-grid/src/images-grid.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/taras-d/images-grid/src/images-grid.min.css" />
<?php

$token = $_SESSION['token'];
$url = 'http://localhost:8000/website_openshare/controllers/users/post/get.php';

// Khởi tạo một cURL session
$curl = curl_init();

// Thiết lập các tùy chọn cho cURL session
curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
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
<div class="container1">
    <!-- left-sidebar -->
    <div class="left-sidebar">
        <div class="imp-links">
            <a href="../quanlytaikhoan/view_profile.php"><img src="<?= $result['user']['photoURL'] ?>" alt="" style="border-radius: 50%" /><?= $result['user']['name'] ?></a>
            <a href="../post/view_displaySendRequest.php"><img src="../assests/images/hand3-removebg-preview.png" alt="" />Yêu cầu đã gửi</a>
            <a href="../post/view_displayReceiveRequest.php"><img src="../assests/images/Acceptrequest_icon.png" alt="" />Yêu cầu đã nhận</a>
            <a href="#"><img src="../assests/images/group.png" alt="" />Group</a>
            <a href="#"><img src="../assests/images/marketplace.png" alt="" />Marketplace</a>
            <a href="#"><img src="../assests/images/watch.png" alt="" />Watch</a>
            <a href="#">See More</a>
        </div>
        <div class="shortcut-links">
            <p>Your Shortcuts</p>
            <a href=""><img src="../assests/images/shortcut-1.png" />Web Developers</a>
            <a href=""><img src="../assests/images/shortcut-2.png" />Web Design course</a>
            <a href=""><img src="../assests/images/shortcut-3.png" />Full Stack Development</a>
            <a href=""><img src="../assests/images/shortcut-4.png" />Web Experts</a>
        </div>
    </div>
    <!-- main-content -->
    <div class="main-content">
        <?php if (isset($_SESSION['cpw_suc'])) {
        ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $_SESSION['cpw_suc'];
                unset($_SESSION['cpw_suc']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php
        } ?>
        <?php if (isset($_SESSION['send_request_error'])) {
        ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $_SESSION['send_request_error'];
                unset($_SESSION['send_request_error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php
        } ?>
        <?php
        if ($data1 == null) {
        } else {
            for ($i = 0; $i < count($data1); $i++) {
        ?>


                <div class="post-container">
                    <div class="post-row">
                        <div class="user-profile">
                            <a href="#"> <img src="<?= $data1[$i]['photoURL'] ?>" alt="" />
                                <div>
                                    <?php if ($data1[$i]['idUser'] !== $result['user']['idUser']) :  ?>

                                        <a href="../quanlytaikhoan/view_user.php?idUser=<?= $data1[$i]['idUser'] ?>">
                                            <p><?= $data1[$i]['name'] ?></p>
                                        </a>
                                    <?php else : ?>
                                        <a href="../quanlytaikhoan/view_profile.php">
                                            <p><?= $data1[$i]['name'] ?></p>
                                        </a>
                                    <?php endif; ?>
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

                        <?php if ($data1[$i]['idUser'] === $result['user']['idUser']) {
                        } else {
                        ?>
                            <div class="post-profile-icon">

                                <div style="cursor:pointer">
                                    <div data-bs-toggle="modal" data-bs-target="#request<?php echo $data1[$i]['idPost'] ?>"><img src="../assests/images/send-icon.jpg"> <small> Gửi yêu cầu </small></div>
                                    <div class=" modal fade" id="request<?php echo $data1[$i]['idPost'] ?>" tabindex="-1" aria-labelledby="Label_Edit" aria-hidden="true">
                                        <div class="modal-dialog modal-lg ">
                                            <!-- modal-xl -->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="Label_Edit">Gửi yêu cầu</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="../post/view_sendRequest.php" method="post">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="idPost" id="idPost" value="<?php echo $data1[$i]['idPost'] ?>">
                                                        <input type="hidden" name="idUserRequest" id="idPost" value="<?php echo $result['user']['idUser'] ?>">

                                                        <div class="row mb-3">
                                                            <label for="message" class="col-md-4 col-lg-3 col-form-label">Tin nhắn</label>
                                                            <div class="col-md-8 col-lg-9">
                                                                <textarea class="form-control" id="message" name="message" placeholder="Mô tả ..." rows="3"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                        <button type="submit" name="sendRequest" class="btn btn-primary">Gửi</button>
                                                    </div>
                                                </form>


                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        <?php  } ?>

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
        <button type="button" class="load-more-btn">Load More</button>

    </div>
    <!-- right-sidebar -->
    <div class="right-sidebar">
        <div class="sidebar-title">
            <h4 class="text-warning">Quảng cáo</h4>
        </div>
        <img src="../assests/images/advertisement.png" alt="" srcset="" class="sidebar-ads" />
        <div class="sidebar-title">
            <h4 class="text-success">Top nhà hảo tâm</h4>
        </div>
        <?php

        $token = $_SESSION['token'];
        $url = 'http://localhost:8000/website_openshare/controllers/users/post/displaytop10.php';

        // Khởi tạo một cURL session
        $curl = curl_init();

        // Thiết lập các tùy chọn cho cURL session
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
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
        <?php for ($i = 0; $i < count($data2); $i++) { ?>
            <div class="online-list">
                <div class="online">
                    <img src="<?= $data2[$i]['photoURL'] ?>" alt="" srcset="" />
                    <p><?= $data2[$i]['name'] ?></p>
                </div>

                <div class="TopDongGop">
                    <p>
                    <p class="text-danger"><?= $data2[$i]['SoluongdochoTC'] ?></p>
                    </p>
                </div>
            </div>
        <?php } ?>
    </div>

</div>
<?php include('../layout/footer.php'); ?>
<?php include('../post/view_post.php') ?>