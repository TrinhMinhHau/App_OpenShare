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
            <a href="./index.html">
                <img src="../assests/images/openshare_logo.png" alt="" height="41px" class="logo" /></a>
            <ul>
                <li>
                    <a href="#"><img src="../assests/images/house-icon-black-and-white-home-vector-24922033-removebg-preview.png" alt="" srcset="" /></a>
                </li>
                <li>
                    <img src="../assests/images/notification.png" alt="" srcset="" class="notice-click" style="cursor: pointer" />
                </li>
                <li><img src="../assests/images/inbox.png" alt="" srcset="" /></li>
                <li><img src="../assests/images/video.png" alt="" srcset="" /></li>
            </ul>
            <!-- settings-notice -->
            <div class="settings-notice">
                <div class="settings-notice-inner">
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
            <div class="search-box">
                <img src="../assests/images/search.png" alt="" srcset="" />
                <input type="text" placeholder="Search" />
            </div>
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
                        <a href="../quanlytaikhoan/view_profile.php">See your profile</a>
                    </div>
                </div>
                <hr />
                <div class="user-profile">
                    <img src="../assests/images/feedback.png" alt="" />
                    <div>
                        <p>Give Feedback</p>
                        <a href="#">Help us to improve the new design</a>
                    </div>
                </div>
                <hr />
                <div class="setting-links">
                    <img src="../assests/images/changepassword.png" class="settings-icon" alt="" />
                    <a href="../quanlytaikhoan/view_changepassword.php">Đổi mật khẩu<img src="../assests/images/arrow.png" width="10px" alt="" /></a>
                </div>
                <div class="setting-links">
                    <img src="../assests/images/logout.png" class="settings-icon" alt="" />
                    <a href="../auth/view_logout.php">Logout<img src="../assests/images/arrow.png" width="10px" alt="" /></a>
                </div>
            </div>
        </div>
    </nav>