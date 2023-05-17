<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>OpenShare</title>

    <link href="../../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
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
                    <a href="../TrangChu/index.php"><i class="bi bi-house-door-fill" style="cursor: pointer; font-size:30px; color:#012970"></i></a>
                </li>
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
                    // var_dump($data1);
                }
                ?>
                <?php
                if (isset($_SESSION['token'])) {
                    $token = $_SESSION['token'];
                } else {
                    header('location: ../auth/view_login.php');
                }
                $url = "http://localhost:8000/website_openshare/controllers/users/post/getNoticeGiveandReceive.php";

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
                    $data_gar = $data ? $data['data'] : null;
                    // var_dump($data_merge);
                }
                ?>
                <?php
                $data_merge = array_merge($data1, $data_gar);
                usort($data_merge, function ($a, $b) {
                    $timeA = isset($a['created_at']) ? $a['created_at'] : $a['createAt_N'];
                    $timeB = isset($b['created_at']) ? $b['created_at'] : $b['createAt_N'];
                    return strtotime($timeB) - strtotime($timeA);
                });
                // var_dump($data_merge);
                ?>
                <?php
                $dem = 0;
                for ($i = 0; $i < count($data_merge); $i++) {
                    if (isset($data_merge[$i]['isSeen']) && $data_merge[$i]['isSeen'] == 0 && ($data_merge[$i]['user_id'] == $result['user']['idUser'])) {
                        $dem++;
                    }
                    if (isset($data_merge[$i]['issen_N']) && $data_merge[$i]['issen_N'] == 0  && ($data_merge[$i]['idUserRequest_N'] == $result['user']['idUser']) && ($data_merge[$i]['status_accept_reject'] !== null)) {
                        $dem++;
                    }
                    if (isset($data_merge[$i]['issen_N']) && $data_merge[$i]['issen_N'] == 0  && ($data_merge[$i]['idUser'] == $result['user']['idUser']) && ($data_merge[$i]['status_accept_reject'] === null)) {
                        $dem++;
                    }
                }

                ?>
                <li>
                    <i class="bi bi-bell notice-click nav-icon " style="cursor: pointer"></i>
                    <span class=" badge bg-primary badge-number"><?php echo $dem ?></span>
                </li>
            </ul>
            <!-- settings-notice -->
            <div class="settings-notice" style="overflow: scroll; ">
                <div class="settings-notice-inner">
                    <?php
                    function convert_time($datecreate)
                    {

                        $thoigianhienthi = 0;
                        $thoigian = round((strtotime(date('Y-m-d H:i:s')) - strtotime($datecreate)) / 3600, 0) + 5;
                        if ($thoigian <= 24) {
                            $thoigianhienthi = $thoigian;
                        } else {
                            $thoigianhienthi = round($thoigian / 24);
                        }
                        $text = '';
                        if ($thoigian <= 24) {
                            $text = ' giờ trước';
                        } else {
                            $text = ' ngày trước';
                        }
                        echo 'Cách đây ' . $thoigianhienthi . $text;
                    }
                    ?>
                    <?php if ($data_merge == null) : ?>
                    <?php else : ?>
                        <?php for ($i = 0; $i < count($data_merge); $i++) { ?>
                            <?php if (isset($data_merge[$i]['user_id']) && $data_merge[$i]['user_id'] !== 'Undefined' && $data_merge[$i]['user_id'] === $result['user']['idUser']) : ?>
                                <?php if ($data_merge[$i]['isSeen'] == 1) : ?>
                                    <div class="setting-notice isSeen">
                                        <img src="../assests/images/notice-icon-b.png" class="settings-icon" alt="" />
                                        <a href="../post/view_displayPostWithidPost.php?idPost=<?= $data_merge[$i]['post_id'] ?>">
                                            <h4><?= $data_merge[$i]['titlePost'] ?></h4>
                                            <p><?= $data_merge[$i]['messagefromAdmin'] ?></p>
                                            <p><?php convert_time($data_merge[$i]['created_at']) ?></p>
                                        </a>
                                    </div>
                                <?php else : ?>
                                    <div class="setting-notice">
                                        <img src="../assests/images/notice-icon-b.png" class="settings-icon" alt="" />
                                        <a href="../post/view_displayPostWithidPost.php?idPost=<?= $data_merge[$i]['post_id'] ?>">
                                            <h4><?= $data_merge[$i]['titlePost'] ?></h4>
                                            <p><?= $data_merge[$i]['messagefromAdmin'] ?></p>
                                            <p><?php convert_time($data_merge[$i]['created_at']) ?></p>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                            <!-- receive  -->
                            <?php if (isset($data_merge[$i]['idUser']) && $data_merge[$i]['idUser'] === $result['user']['idUser'] && $data_merge[$i]['status_accept_reject'] === null) : ?>
                                <?php if ($data_merge[$i]['issen_N'] == 1) : ?>
                                    <div class="setting-notice isSeen">
                                        <img src="<?= $data_merge[$i]['photoURL'] ?>" class="settings-icon" alt="" />
                                        <a href="../post/view_displayReceiveRequestbyidPost.php?idPost=<?= $data_merge[$i]['idPost'] ?>&idNotice=<?= $data_merge[$i]['idNotice'] ?>">
                                            <p>Bạn <span class="text-primary"><?= $data_merge[$i]['name'] ?></span> đã gửi yêu cầu đến bài viết <span class=" text-primary"><?= $data_merge[$i]['title'] ?></span></p>
                                            <p><?php convert_time($data_merge[$i]['createAt_N']) ?></p>
                                        </a>
                                    </div>
                                <?php else : ?>
                                    <div class="setting-notice">
                                        <img src="<?= $data_merge[$i]['photoURL'] ?>" class="settings-icon" alt="" />
                                        <a href="../post/view_displayReceiveRequestbyidPost.php?idPost=<?= $data_merge[$i]['idPost'] ?>&idNotice=<?= $data_merge[$i]['idNotice'] ?>">
                                            <p>Bạn <span class="text-primary"><?= $data_merge[$i]['name'] ?></span> đã gửi yêu cầu đến bài viết <span class=" text-primary"><?= $data_merge[$i]['title'] ?></span></p>
                                            <p><?php convert_time($data_merge[$i]['createAt_N']) ?></p>
                                        </a>
                                    </div>
                                <?php endif ?>
                            <?php endif ?>
                            <?php if (isset($data_merge[$i]['idUserRequest_N']) && $data_merge[$i]['idUserRequest_N'] === $result['user']['idUser'] && $data_merge[$i]['status_accept_reject'] === 1) : ?>
                                <?php if ($data_merge[$i]['issen_N'] == 1) : ?>
                                    <div class=" setting-notice isSeen">
                                        <img src="../assests/images/icon-thanh-cong.png" class="settings-icon" alt="" />
                                        <a href="../post/view_displaySendRequestbyidPost.php?idPost=<?= $data_merge[$i]['idPost'] ?>&idNotice=<?= $data_merge[$i]['idNotice'] ?>">
                                            <p>Yêu cầu của bạn đến bài cho <span class="text-primary"><?= $data_merge[$i]['title'] ?></span> được chấp nhận</p>
                                            <p><?php convert_time($data_merge[$i]['createAt_N']) ?></p>
                                        </a>
                                    </div>
                                <?php else : ?>
                                    <div class=" setting-notice ">
                                        <img src="../assests/images/icon-thanh-cong.png" class="settings-icon" alt="" />
                                        <a href="../post/view_displaySendRequestbyidPost.php?idPost=<?= $data_merge[$i]['idPost'] ?>&idNotice=<?= $data_merge[$i]['idNotice'] ?>">
                                            <p>Yêu cầu của bạn đến bài cho <span class="text-primary"><?= $data_merge[$i]['title'] ?></span> được chấp nhận</p>
                                            <p><?php convert_time($data_merge[$i]['createAt_N']) ?></p>
                                        </a>
                                    </div>
                                <?php endif ?>
                            <?php endif ?>
                            <?php if (isset($data_merge[$i]['idUserRequest_N']) && $data_merge[$i]['idUserRequest_N'] === $result['user']['idUser'] && $data_merge[$i]['status_accept_reject'] === 0) : ?>
                                <?php if ($data_merge[$i]['issen_N'] == 1) : ?>
                                    <div class="setting-notice isSeen">
                                        <img src="../assests/images/icon_refuse.png" class="settings-icon" alt="" />
                                        <a href="../post/view_displaySendRequestbyidPost.php?idPost=<?= $data_merge[$i]['idPost'] ?>&idNotice=<?= $data_merge[$i]['idNotice'] ?>">
                                            <p>Yêu cầu của bạn đến bài cho <span class="text-primary"><?= $data_merge[$i]['title'] ?></span> bị từ chối</p>
                                            <p><?php convert_time($data_merge[$i]['createAt_N']) ?></p>
                                        </a>
                                    </div>
                                <?php else : ?>
                                    <div class="setting-notice">
                                        <img src="../assests/images/icon_refuse.png" class="settings-icon" alt="" />
                                        <a href="../post/view_displaySendRequestbyidPost.php?idPost=<?= $data_merge[$i]['idPost'] ?>&idNotice=<?= $data_merge[$i]['idNotice'] ?>">
                                            <p>Yêu cầu của bạn đến bài cho <span class="text-primary"><?= $data_merge[$i]['title'] ?></span> bị từ chối</p>
                                            <p><?php convert_time($data_merge[$i]['createAt_N']) ?></p>
                                        </a>
                                    </div>
                                <?php endif ?>
                            <?php endif ?>

                        <?php } ?>


                    <?php endif ?>
                </div>
            </div>
        </div>
        <div class="nav-right">
            <!-- <form action="" method="get">
                <div class="search-box">
                    <img src="../assests/images/search.png" alt="" srcset="" />
                    <input type="text" placeholder="Tìm theo tỉnh, từ khóa trong mô tả" name="keyword" value="<?php if (isset($_GET['keyword'])) echo $_GET['keyword'];
                                                                                                                else ''  ?>" />
                    <input type="hidden" name="idType" value="<?php if (isset($_GET['idType'])) echo $_GET['idType'];
                                                                else ''  ?>">
                </div>
            </form> -->
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
                        <a href="../contact/contact.php">Giúp chúng tôi cải thiện Website</a>
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