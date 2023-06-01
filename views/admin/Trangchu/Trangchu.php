<?php include('../Layout/view_header.php') ?>
<?php include('../Layout/view_sidebar.php') ?>
<?php
$token = $_SESSION['token_admin'];

// Các URL cần render
$url1 = 'http://localhost:8000/website_openshare/controllers/admin/Statistical/sumofUser.php';
$url2 = 'http://localhost:8000/website_openshare/controllers/admin/Statistical/sumofPost.php';
$url3 = 'http://localhost:8000/website_openshare/controllers/admin/Statistical/sumofItemSuccess.php';
$url4 = 'http://localhost:8000/website_openshare/controllers/admin/Statistical/displayTop10.php';

// Khởi tạo một multi-cURL session
$multiCurl = curl_multi_init();

// Thiết lập các tùy chọn cho các URL
$options = array(
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        "Accept: application/json",
        "Authorization: Bearer {$token}",
    )
);

// Tạo một cURL handle cho URL 1
$curl1 = curl_init($url1);
curl_setopt_array($curl1, $options);
curl_multi_add_handle($multiCurl, $curl1);

// Tạo một cURL handle cho URL 2
$curl2 = curl_init($url2);
curl_setopt_array($curl2, $options);
curl_multi_add_handle($multiCurl, $curl2);

// Tạo một cURL handle cho URL 3
$curl3 = curl_init($url3);
curl_setopt_array($curl3, $options);
curl_multi_add_handle($multiCurl, $curl3);

// Tạo một cURL handle cho URL 4
$curl4 = curl_init($url4);
curl_setopt_array($curl4, $options);
curl_multi_add_handle($multiCurl, $curl4);
// Thực hiện các yêu cầu cùng lúc
do {
    $status = curl_multi_exec($multiCurl, $active);
    if ($active) {
        curl_multi_select($multiCurl);
    }
} while ($active && $status == CURLM_OK);

// Lấy kết quả của các yêu cầu
$response1 = curl_multi_getcontent($curl1);
$response2 = curl_multi_getcontent($curl2);
$response3 = curl_multi_getcontent($curl3);
$response4 = curl_multi_getcontent($curl4);

// Xử lý kết quả trả về
$data1 = json_decode($response1, true);
$data11 = (isset($data1['data'])) ? $data1['data'] : null;

$data2 = json_decode($response2, true);
$data22 = (isset($data2['data'])) ? $data2['data'] : null;

$data3 = json_decode($response3, true);
$data33 = (isset($data3['data'])) ? $data3['data'] : null;

$data4 = json_decode($response4, true);
$data44 = (isset($data4['data'])) ? $data4['data'] : null;

// Đóng các cURL handle và multi-cURL session
curl_multi_remove_handle($multiCurl, $curl1);
curl_multi_remove_handle($multiCurl, $curl2);
curl_multi_remove_handle($multiCurl, $curl3);
curl_multi_remove_handle($multiCurl, $curl4);
curl_multi_close($multiCurl);
?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Tổng quan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./Trangchu.php">Tổng quan</a></li>
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">
                    <!-- Sales Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Tổng số người dùng</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?php if ($data11 == null) echo 0;
                                            else echo $data11['0']['countUser'] ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Sales Card -->

                    <!-- Revenue Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    Số lượng bài cho đã đăng
                                </h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-file-earmark-post"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?php if ($data22 == null) echo 0;
                                            else echo $data22['0']['TongSoluongbaicho'] ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Revenue Card -->

                    <!-- Customers Card -->
                    <div class="col-xxl-4 col-xl-12">
                        <div class="card info-card customers-card">


                            <div class="card-body">
                                <h5 class="card-title">Số lượng đồ dùng đã cho thành công
                                </h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-check2-square"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?php if ($data33 == null) echo 0;
                                            else echo $data33['0']['Soluongdochothanhcong'] ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Top Selling -->
                </div>
            </div>
            <!-- End Left side columns -->

            <!-- Right side columns -->
            <div class="col-lg-4">
                <!-- Recent Activity -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Top Đóng Góp</h5>
                        <div class="activity">
                            <?php if ($data44 == null) {
                            } else {
                                for ($i = 0; $i < count($data44); $i++) {
                            ?>
                                    <div class="online-list">
                                        <div class="online">
                                            <a href="#">
                                                <img src="<?= $data44[$i]['photoURL'] ?>" alt="" srcset="" />
                                            </a>
                                            <a href="#" style="text-decoration: none; color:#333">
                                                <p><?= $data44[$i]['name'] ?></p>
                                            </a>
                                        </div>
                                        <div class="TopDongGop">
                                            <p>
                                            <p class="text-danger"><?= $data44[$i]['SoluongdochoTC'] ?></p>
                                            </p>
                                        </div>
                                    </div>
                            <?php }
                            } ?>
                        </div>
                    </div>
                </div>
                <!-- End Recent Activity -->
            </div>
            <!-- End Right side columns -->
        </div>
    </section>
</main>
<!-- End #main -->
<?php include('../Layout/view_footer.php') ?>

<style>
    .online-list {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        justify-content: space-between;
    }

    .online-list .online img {
        width: 50px;
        border-radius: 50%;
    }

    .online-list .online {
        display: flex;
    }

    .online-list .online p {
        margin-top: 10px;
        margin-left: 10px;
    }

    .TopDongGop p {
        margin-top: 10px;
    }
</style>