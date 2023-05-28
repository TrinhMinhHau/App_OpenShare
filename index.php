<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>OpenShare</title>

    <link href="./assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <script src="./assets/vendor/bootstrap/js/bootstrap.min.js" rel="stylesheet"></script>
    <link rel="stylesheet" href="./views/users/assests/style.css" />
    <script src="https://kit.fontawesome.com/ed71b1744c.js" crossorigin="anonymous"></script>
    <script defer src="./views/users/assests/script.js"></script>
    <!-- Thư viện jQuery -->
    <script src="//code.jquery.com/jquery.min.js"></script>
    <!-- CSS của Images Grid -->
    <script src="https://cdn.jsdelivr.net/gh/taras-d/images-grid/src/images-grid.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/taras-d/images-grid/src/images-grid.min.css" />

</head>

<body>
    <nav>
        <div class="nav-left">
            <a href="./index.php">
                <img src="./views/users/assests/images/openshare_logo.png" alt="" height="41px" class="logo" /></a>
            <ul>
                <li>
                    <a href="./index.php"><i class="bi bi-house-door-fill" style="cursor: pointer; font-size:30px; color:#012970"></i></a>
                </li>
            </ul>
        </div>
        <div class="nav-right">
            <li><a href="./views/users/auth/view_login.php">Đăng nhập</a></li>
            <li><a href="./views/users/auth/view_register.php">Đăng ký</a></li>
        </div>
    </nav>
    <?php if (isset($_GET['keyword'])) : ?>
        <?php
        $limit = 3;
        $page = isset($_GET['page']) ? $_GET['page'] : 1; // Trang hiện tại, mặc định là trang 1
        $offset = ($page - 1) * $limit; // Vị trí bắt đầu của kết quả cần lấy
        $keyword = isset($_GET['keyword']) ? str_replace(' ', '_', $_GET['keyword']) : '';


        $url = 'http://localhost:8000/website_openshare/controllers/users/post/search_page.php?keyword=' . $keyword . '&offset=' . $offset . '&limit=' . $limit;

        // Khởi tạo một cURL session
        $curl = curl_init();

        // Thiết lập các tùy chọn cho cURL session
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                "Accept: application/json",
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

    <?php else : ?>
        <?php

        $limit = 5; // Số lượng bài viết muốn hiển thị trên mỗi trang
        $page = isset($_GET['page']) ? $_GET['page'] : 1; // Trang hiện tại, mặc định là trang 1
        $offset = ($page - 1) * $limit; // Vị trí bắt đầu của kết quả cần lấy


        $url = 'http://localhost:8000/website_openshare/controllers/users/post/getpostapi.php?offset=' . $offset . '&limit=' . $limit;

        // Khởi tạo một cURL session
        $curl = curl_init();

        // Thiết lập các tùy chọn cho cURL session
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                "Accept: application/json",
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
    <?php endif; ?>
    <div class="container1">

        <!-- left-sidebar -->
        <div class="left-sidebar">
            <div class="shortcut-links">
                <p> <i class="fa-solid fa-chart-bar"></i> Danh mục loại đồ cho</p>

                <ul>
                    <?php
                    $url = 'http://localhost:8000/website_openshare/controllers/users/type/getType.php';

                    // Khởi tạo một cURL session
                    $curl = curl_init();

                    // Thiết lập các tùy chọn cho cURL session
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => $url,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json',
                            "Accept: application/json",
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
                        $data3 = $data ? $data['data'] : null;
                    }

                    // Đóng cURL session
                    curl_close($curl);
                    ?>
                    <?php for ($i = 0; $i < count($data3); $i++) { ?>
                        <li><a href="./views/users/post/view_displayPostWithType.php?idType=<?= $data3[$i]['idType'] ?>"><i class="fa-regular fa-circle"></i> <?= $data3[$i]['nameType'] ?></a></li>
                    <?php } ?>
                </ul>

            </div>


        </div>
        <!-- main-content -->
        <div class="main-content">
            <div class="write-post-container" style="display: flex; justify-content: center; align-items: center;">

                <div class="post-row">
                    <form action="" method="get">
                        <div class="search-box">
                            <img src="./views/users/assests/images/search.png" alt="" srcset="" />
                            <input type="text" placeholder="Bạn cần tìm gì ?" name="keyword" id="keyword" value="<?php if (isset($_GET['keyword'])) echo $_GET['keyword'];
                                                                                                                    else ''  ?>" />
                            <i class="bi bi-mic-fill" id="search_microphone" style="cursor:pointer"></i>
                        </div>
                        <div id="listening_indicator1"></div>
                    </form>

                </div>

            </div>
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
            function convert_time($datecreate)
            {

                $thoigianhienthi = 0;
                $thoigian = round((strtotime(date('Y-m-d H:i:s')) - strtotime($datecreate)) / 3600, 0) + 5;
                if ($thoigian <= 24) {
                    $thoigianhienthi = $thoigian;
                } else if ($thoigian > 24 && $thoigian <= 168) {
                    $thoigianhienthi = round($thoigian / 24);
                } else {
                    $thoigianhienthi = $datecreate;
                }
                $text = '';
                if ($thoigian <= 24) {
                    $text = ' giờ trước';
                } else if ($thoigian > 24 && $thoigian <= 168) {
                    $text = ' ngày trước';
                } else {
                    $text = '';
                }
                echo $thoigianhienthi . $text;
            }

            if ($data1 == null) {
            } else {
                for ($i = 0; $i < count($data1); $i++) {
            ?>


                    <div class="post-container">
                        <div class="post-row">
                            <div class="user-profile">
                                <a href="#"> <img src="<?= $data1[$i]['photoURL'] ?>" alt="" />
                                    <div>

                                        <a href="./views/users/quanlytaikhoan/view_profile.php">
                                            <p><?= $data1[$i]['name'] ?></p>
                                        </a>

                                        <span><?php convert_time($data1[$i]['approvDate']) ?></span>
                                    </div>
                                    <div class="address">
                                        <p><i class="fa-solid fa-location-dot"></i> <?= explode(",",  $data1[$i]['address'])[0] ?></p>
                                    </div>
                                    <div class="type">
                                        <a href="./views/users/post/view_displayPostWithType.php?idType=<?= $data1[$i]['idType'] ?>">
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
            <?php if (isset($_GET['keyword'])) : ?>
                <?php

                $keyword = isset($_GET['keyword']) ? str_replace(' ', '_', $_GET['keyword']) : '';
                $url = 'http://localhost:8000/website_openshare/controllers/users/post/search.php?keyword=' . $keyword;

                // Khởi tạo một cURL session
                $curl = curl_init();

                // Thiết lập các tùy chọn cho cURL session
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        "Accept: application/json",
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
                // Tạo các nút phân trang

                ?>
                <?php
                if ($data9 == null) {
                    $total_posts = 1;
                } else {
                    $total_posts = count($data9);
                }
                // Tổng số bài viết
                $total_pages = ceil($total_posts / $limit); // Tổng số trang
                $prev_page = ($page > 1) ? $page - 1 : 1; // Trang trước đó
                $next_page = ($page < $total_pages) ? $page + 1 : $total_pages; // Trang kế tiếp

                echo '<div class="pagination">';
                echo '<a href="?keyword=' . $_GET['keyword'] . '&page=' . $prev_page . '">Trang trước</a>';

                for ($i = 1; $i <= $total_pages; $i++) {
                    $active = ($i == $page) ? 'active' : '';
                    echo '<a href="?keyword=' . $_GET['keyword'] . '&page=' . $i . '" class="' . $active . '">' . $i . '</a>';
                }

                echo '<a href="?keyword=' . $_GET['keyword'] . '&page=' . $next_page . '">Trang kế tiếp</a>';
                echo '</div>';
                ?>
            <?php else : ?>
                <?php

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
                // Tạo các nút phân trang

                ?>
                <?php
                $total_posts = count($data9); // Tổng số bài viết

                $total_pages = ceil($total_posts / $limit); // Tổng số trang
                $prev_page = ($page > 1) ? $page - 1 : 1; // Trang trước đó
                $next_page = ($page < $total_pages) ? $page + 1 : $total_pages; // Trang kế tiếp

                echo '<div class="pagination">';
                if ($page > 1) {
                    echo '<a href="?page=' . $prev_page . '">Trang trước</a>';
                }
                for ($i = 1; $i <= $total_pages; $i++) {
                    $active = ($i == $page) ? 'active' : '';
                    echo '<a href="?page=' . $i . '" class="' . $active . '">' . $i . '</a>';
                }
                if ($page < $total_pages) {
                    echo '<a href="?page=' . $next_page . '">Trang kế tiếp</a>';
                }
                echo '</div>';
                ?>
            <?php endif; ?>


            <!-- <button type="button" class="load-more-btn">Load More</button> -->

        </div>
        <!-- right-sidebar -->
        <div class="right-sidebar">
            <div class="sidebar-title">
                <h4 class="text-warning">Quảng cáo</h4>
            </div>
            <img src="./views/users/assests/images/advertisement.png" alt="" srcset="" class="sidebar-ads" />
            <div class="sidebar-title">
                <h4 class="text-success">Top nhà hảo tâm</h4>
            </div>
            <?php

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
            <?php for ($i = 0; $i < count($data2); $i++) {
            ?>
                <div class="online-list">
                    <div class="online">

                        <a href="./views/users/quanlytaikhoan/view_profile.php">
                            <img src="<?= $data2[$i]['photoURL'] ?>" alt="" srcset="" />
                        </a>
                        <a href="./views/users/quanlytaikhoan/view_profile.php" style="text-decoration: none; color:#333">
                            <p><?= $data2[$i]['name'] ?></p>
                        </a>
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
    <?php include('./views/users/layout/footer.php'); ?>
    <script>
        // Lấy URL hiện tại của trang
        var currentUrl = window.location.href;

        // Lặp lại các phần tử <a> trong menu
        const lis = document.querySelectorAll('.nav-left ul li a ');
        for (let i = 0; i < lis.length; i++) {
            const link = lis[i];

            // Nếu href của phần tử <a> khớp với URL hiện tại
            if (link.href === currentUrl) {
                // Thêm lớp active vào thẻ <a>
                link.classList.add('active1');
            }

            // Thêm sự kiện click cho phần tử <a>
            link.addEventListener('click', function() {
                // Xóa lớp active từ tất cả các phần tử <a>
                for (let j = 0; j < lis.length; j++) {
                    lis[j].classList.remove('active1');
                }

                // Thêm lớp active vào phần tử <a> được click
                this.classList.add('active1');
            });
        }
        console.log(123);
    </script>
    <style>
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
        }

        .pagination a {
            display: inline-block;
            padding: 5px 10px;
            margin: 0 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            color: #333;
            text-decoration: none;
        }

        .pagination a.active {
            background-color: #333;
            color: #fff;
        }

        #listening_indicator1 {
            margin-top: 5px;
            width: 150px;
            float: right;
            border-radius: 5px;
        }
    </style>
    <script>
        document.getElementById("search_microphone").addEventListener("click", function() {
            var old_text = document.getElementById("keyword").value;
            var speech = true;
            window.SpeechRecognition = window.webkitSpeechRecognition;
            var listeningIndicator = document.getElementById("listening_indicator1");

            const recognition = new SpeechRecognition();
            recognition.interimResults = true;
            recognition.lang = "vi-VN";
            recognition.addEventListener("start", () => {
                listeningIndicator.style.backgroundColor = "green";
                listeningIndicator.style.color = "white";
                listeningIndicator.textContent = "Đang lắng nghe...";
            });

            recognition.addEventListener("end", () => {
                listeningIndicator.style.backgroundColor = "red";
                listeningIndicator.textContent = "";
            });
            recognition.addEventListener("result", (e) => {
                const transcript = Array.from(e.results)
                    .map((result) => result[0])
                    .map((result) => result.transcript)
                    .join("");

                document.getElementById("keyword").value = old_text + ' ' + transcript;
                console.log(transcript);
            });

            if (speech == true) {
                recognition.start();
            }
        });
    </script>
    <style>
        .nav-right li {
            list-style: none;
            padding: 10px;
        }

        .nav-right li a {
            text-decoration: none;
            color: #333;
        }

        .nav-right li a:hover {
            text-decoration: underline;
            color: #333;
        }
    </style>