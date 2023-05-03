<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>OpenShare</title>

    <link href="../../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="../../../assets/vendor/bootstrap/js/bootstrap.min.js" rel="stylesheet"></script>
    <link rel="stylesheet" href="../assests/style.css" />
    <script src="https://kit.fontawesome.com/ed71b1744c.js" crossorigin="anonymous"></script>
    <script defer src="../assests/script.js"></script>


</head>

<body>

    <?php
    session_start();
    if (isset($_SESSION['token'])) {
        $token = $_SESSION['token'];
    } else {
        header('location: ../auth/view_login.php');
    }
    $url = "http://localhost:8000/website_openshare/controllers/users/profile/getUsers.php";

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $headers = array(
        "Accept: application/json",
        "Authorization: Bearer {$token}",
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    //for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $resp = curl_exec($curl);
    curl_close($curl);
    if ($resp) {
        $result = json_decode($resp, true);
        // var_dump($result);
    }
    ?>
    <nav>
        <div class="nav-left">
            <a href="../TrangChu/index.php">
                <img src="../assests/images/openshare_logo.png" alt="" height="41px" class="logo" /></a>
            <ul>
                <li>
                    <a href="../TrangChu/index.php" class="active1"><img src="../assests/images/house-icon-black-and-white-home-vector-24922033-removebg-preview.png" alt="" srcset="" /></a>
                </li>
                <li>
                    <img src="../assests/images/notification.png" alt="" srcset="" class="notice-click" style="cursor: pointer" />
                </li>
            </ul>
            <!-- settings-notice -->
            <div class="settings-notice " style="overflow: scroll; ">
                <div class="settings-notice-inner">
                    <?php
                    if (isset($_SESSION['token'])) {
                        $token = $_SESSION['token'];
                    } else {
                        header('location: ../auth/view_login.php');
                    }
                    $url = "http://localhost:8000/website_openshare/controllers/users/post/getNoticeFromAdmin.php";

                    $curl = curl_init($url);
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                    $headers = array(
                        "Accept: application/json",
                        "Authorization: Bearer {$token}",
                    );
                    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                    //for debug only!
                    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

                    $resp = curl_exec($curl);
                    curl_close($curl);
                    if ($resp) {
                        $data = json_decode($resp, true);
                        $data1 = $data ? $data['data'] : null;
                        // var_dump($result);
                    }
                    ?>
                    <?php if ($data1 == null) : ?>
                    <?php else : ?>

                        <?php for ($i = 0; $i < count($data1); $i++) { ?>
                            <?php if ($data1[$i]['user_id'] === $result['user']['idUser']) : ?>
                                <?php if ($data1[$i]['isSeen'] == 1) : ?>
                                    <div class="setting-notice isSeen">
                                        <img src="../assests/images/notice-icon-b.png" class="settings-icon" alt="" />
                                        <a href="../post/view_displayPostWithidPost.php?idPost=<?= $data1[$i]['post_id'] ?>">
                                            <h4><?= $data1[$i]['titlePost'] ?></h4>
                                            <p><?= $data1[$i]['messagefromAdmin'] ?></p>
                                            <p>Cách đây <?= round((strtotime(date('Y-m-d H:i:s')) - strtotime($data1[$i]['created_at'])) / 3600, 0) + 5 ?> giờ trước </p>
                                        </a>
                                    </div>
                                <?php else : ?>
                                    <div class="setting-notice">
                                        <img src="../assests/images/notice-icon-b.png" class="settings-icon" alt="" />
                                        <a href="../post/view_displayPostWithidPost.php?idPost=<?= $data1[$i]['post_id'] ?>">
                                            <h4><?= $data1[$i]['titlePost'] ?></h4>
                                            <p><?= $data1[$i]['messagefromAdmin'] ?></p>
                                            <p>Cách đây <?= round((strtotime(date('Y-m-d H:i:s')) - strtotime($data1[$i]['created_at'])) / 3600, 0) + 5 ?> giờ trước </p>
                                        </a>
                                    </div>
                                <?php endif ?>
                            <?php endif ?>
                        <?php } ?>
                    <?php endif ?>


                    <div class="setting-notice">
                        <img src="../assests/images/notice-icon-b.png" class="settings-icon" alt="" />
                        <a href="#">
                            <h4>TrinhMinhHau</h4>
                            <p>Bài đăng đã được duyệt</p>
                            <p>Cách đây 5p</p>
                        </a>
                    </div>
                    <div class="setting-notice">
                        <img src="../assests/images/notice-icon-b.png" class="settings-icon" alt="" />
                        <a href="#">
                            <h4>TrinhMinhHau</h4>
                            <p>Bài đăng đã được duyệt</p>
                            <p>Cách đây 5p</p>
                        </a>
                    </div>
                    <div class="setting-notice">
                        <img src="../assests/images/notice-icon-b.png" class="settings-icon" alt="" />
                        <a href="#">
                            <h4>TrinhMinhHau</h4>
                            <p>Bài đăng đã được duyệt</p>
                            <p>Cách đây 5p</p>
                        </a>
                    </div>
                    <div class="setting-notice">
                        <img src="../assests/images/notice-icon-b.png" class="settings-icon" alt="" />
                        <a href="#">
                            <h4>TrinhMinhHau</h4>
                            <p>Bài đăng đã được duyệt</p>
                            <p>Cách đây 5p</p>
                        </a>
                    </div>
                    <div class="setting-notice">
                        <img src="../assests/images/notice-icon-b.png" class="settings-icon" alt="" />
                        <a href="#">
                            <h4>TrinhMinhHau</h4>
                            <p>
                                Bài đăng đã được duyệt Bài đăng đã được duyệt Bài đăng đã được
                                duyệt
                            </p>
                            <p>Cách đây 5p</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="nav-right">
            <form action="" method="get">
                <div class="search-box">
                    <img src="../assests/images/search.png" alt="" srcset="" />
                    <input type="text" placeholder="Tìm theo tỉnh, từ khóa trong mô tả" name="keyword" value="<?php if (isset($_GET['keyword'])) echo $_GET['keyword'];
                                                                                                                else ''  ?>" />
                    <input type="hidden" name="idType" value="<?php if (isset($_GET['idType'])) echo $_GET['idType'];
                                                                else ''  ?>">
                </div>
            </form>
            <div class="nav-user-icon online" id="userClick">
                <img src="<?= $result['user']['photoURL'] ?>" alt="" />
            </div>
        </div>
        <!-- settings-menu -->
        <div class="settings-menu">
            <div id="dark-btn">
                <span></span>
            </div>
            <div class="settings-menu-inner">
                <div class="user-profile">
                    <img src="<?= $result['user']['photoURL'] ?>" alt="" />
                    <div>
                        <p><?= $result['user']['name'] ?></p>
                        <a href="../quanlytaikhoan/view_profile.php">Xem trang cá nhân</a>
                    </div>
                </div>
                <hr />
                <div class="user-profile">
                    <img src="../assests/images/feedback.png" alt="" />
                    <div>
                        <p>Gửi phản hồi</p>
                        <a href="#">Giúp chúng tôi cải thiện Website</a>
                    </div>
                </div>
                <hr />
                <div class="setting-links">
                    <img src="../assests/images/changepassword.png" class="settings-icon" alt="" />
                    <a href="../quanlytaikhoan/view_changepassword.php">Đổi mật khẩu</a>
                </div>
                <div class="setting-links">
                    <img src="../assests/images/logout.png" class="settings-icon" alt="" />
                    <a href="../auth/view_logout.php">Đăng Xuất</a>
                </div>
            </div>
        </div>
    </nav>
    <script>
        const lis = document.querySelectorAll('.nav-left ul li a');
        for (let i = 0; i < lis.length; i++) {
            lis[i].addEventListener('click', function() {
                // Xóa lớp active1 từ tất cả các phần tử li
                for (let j = 0; j < lis.length; j++) {
                    lis[j].classList.remove('active1');
                }
                // Thêm lớp active1 vào phần tử li được click
                this.classList.add('active1');
            });
        }
    </script>