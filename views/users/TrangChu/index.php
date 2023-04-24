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
    $data1 = $data['data'];
}

// Đóng cURL session
curl_close($curl);
?>
<div class="container1">
    <!-- left-sidebar -->
    <div class="left-sidebar">
        <div class="imp-links">
            <a href="../quanlytaikhoan/view_profile.php"><img src="<?= $result['user']['photoURL'] ?>" alt="" style="border-radius: 50%" /><?= $result['user']['name'] ?></a>
            <a href="#"><img src="../assests/images/news.png" alt="" />Lastest News</a>
            <a href="#"><img src="../assests/images/friends.png" alt="" />Friends</a>
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
                                    <a href="#">
                                        <p><?= $data1[$i]['name'] ?></p>
                                    </a> <span><?= $data1[$i]['postDate'] ?></span>
                                </div>
                                <div class="address">
                                    <p><i class="fa-solid fa-location-dot"></i> <?= $data1[$i]['address'] ?></p>
                                </div>
                                <div class="type">
                                    <a href="#">
                                        <p><?= $data1[$i]['nameType'] ?></p>
                                    </a>
                                </div>
                        </div>
                        <a href="#"><i class="fas fa-ellipsis-v"></i></a>
                    </div>
                    <p class="title"><?= $data1[$i]['title'] ?></p>
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
        <button type="button" class="load-more-btn">Load More</button>
    </div>
    <!-- right-sidebar -->
    <div class="right-sidebar">
        <div class="sidebar-title">
            <h4>Events</h4>
            <a href="">See All</a>
        </div>

        <div class="event">
            <div class="left-event">
                <h3>18</h3>
                <span>March</span>
            </div>
            <div class="right-event">
                <h4>Social Media</h4>
                <p>
                    <i class="fa-sharp fa-solid fa-location-dot"></i> Willson Tech
                    Park
                </p>
                <a href="#">More info</a>
            </div>
        </div>
        <div class="event">
            <div class="left-event">
                <h3>22</h3>
                <span>June</span>
            </div>
            <div class="right-event">
                <h4>Mobile Marketing</h4>
                <p>
                    <i class="fa-sharp fa-solid fa-location-dot"></i> Willson Tech
                    Park
                </p>
                <a href="#">More info</a>
            </div>
        </div>
        <div class="sidebar-title">
            <h4>Advertisment</h4>
            <a href="">Close</a>
        </div>
        <img src="../assests/images/advertisement.png" alt="" srcset="" class="sidebar-ads" />
        <div class="sidebar-title">
            <h4>Conversation</h4>
            <a href="">Hide chat</a>
        </div>
        <div class="online-list">
            <div class="online">
                <img src="../assests/images/member-1.png" alt="" srcset="" />
            </div>
            <p>Alison Mina</p>
        </div>
        <div class="online-list">
            <div class="online">
                <img src="../assests/images/member-2.png" alt="" srcset="" />
            </div>
            <p>Alison Mina</p>
        </div>
        <div class="online-list">
            <div class="online">
                <img src="../assests/images/member-3.png" alt="" srcset="" />
            </div>
            <p>Alison Mina</p>
        </div>
        <div class="online-list">
            <div class="online">
                <img src="../assests/images/member-1.png" alt="" srcset="" />
            </div>
            <p>Alison Mina</p>
        </div>
        <div class="online-list">
            <div class="online">
                <img src="../assests/images/member-2.png" alt="" srcset="" />
            </div>
            <p>Alison Mina</p>
        </div>
        <div class="online-list">
            <div class="online">
                <img src="../assests/images/member-3.png" alt="" srcset="" />
            </div>
            <p>Alison Mina</p>
        </div>
    </div>
</div>
<?php include('../layout/footer.php'); ?>