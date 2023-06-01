<?php include('../Layout/view_header.php') ?>
<?php include('../Layout/view_sidebar.php') ?>

<?php

$token = $_SESSION['token_admin'];
$url = 'http://localhost:8000/website_openshare/controllers/admin/UserManager/displayUser.php';

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
<main id="main" class="main">
    <?php if (isset($_SESSION['status'])) {
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['status'];
            unset($_SESSION['status']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

        </div>
    <?php } ?>
    <div class="pagetitle">
        <h1>Quản lý người dùng</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../Trangchu/Trangchu.php">Trangchu</a></li>
                <li class="breadcrumb-item">Quản lý người dùng</li>
                <li class="breadcrumb-item active">Người dùng</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">

        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">

                        <!-- Table with stripped rows -->
                        <table class="table datatable table-striped table-bordered" border="1">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Mã số</th>
                                    <th scope="col">Họ và tên</th>
                                    <th scope="col">Tài khoản</th>
                                    <!-- <th scope="col">Email</th> -->
                                    <th scope="col">Ảnh đại diện</th>
                                    <th scope="col">Số lần cho</th>
                                    <th colspan="2">Chức năng</th>

                                    <!-- <th scope="col">Số điện thoại</th>
                                    <th scope="col">Địa chỉ</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                for ($i = 0; $i < count($data1); $i++) { ?>
                                    <?php

                                    // $token = $_SESSION['token_admin'];
                                    $idUser = $data1[$i]['idUser'];
                                    $data = array(
                                        'idUser' => $idUser
                                    );
                                    $json_data = json_encode($data);

                                    $url = 'http://localhost:8000/website_openshare/controllers/admin/Staff/getNumberPoin.php';


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
                                        $data6 = $data ? $data['data'] : null;
                                    }

                                    // Đóng cURL session
                                    curl_close($curl);
                                    ?>
                                    <tr>
                                        <th scope="col"><?= $i + 1 ?></td>
                                        <td><?= ($data1[$i]['idUser']) ?></td>
                                        <td><?= ($data1[$i]['name']) ?></td>
                                        <td><?= ($data1[$i]['userName']) ?></td>
                                        <td><img src="<?= ($data1[$i]['photoURL']) ?>" alt="" srcset="" width="50px" height="20px" style="border-radius:50%"></td>
                                        <td><?= $data6[0]['SoluongdochoTC'] ?></td>
                                        <td>
                                            <!-- DETAIL  -->
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#Modal_Detail<?php echo ($data1[$i]['idUser']) ?>">
                                                <i class="bi bi-info-circle"></i> Chi tiết
                                            </button>
                                            <div class="modal fade" id="Modal_Detail<?php echo ($data1[$i]['idUser']) ?>" tabindex="-1" aria-labelledby="LabelModal" aria-hidden="true">
                                                <div class="modal-dialog modal-xl ">
                                                    <!-- modal-xl -->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="LabelModal">Chi tiết</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="container d-flex justify-content-center mt-50 mb-50">
                                                                <div class="row">
                                                                    <div class="col-md-12 ">

                                                                        <div class="card card-body ">
                                                                            <div class="media align-items-center align-items-lg-start text-center text-lg-left flex-column flex-lg-row">
                                                                                <div class="mr-2 mb-3 mb-lg-0">


                                                                                    <img src="<?= ($data1[$i]['photoURL']) ?>" alt="" srcset="" width="200px" height="200px">

                                                                                </div>

                                                                                <div class="media-body">
                                                                                    <h6 class="media-title font-weight-semibold">

                                                                                        <p class="text-primary">
                                                                                            <?= ($data1[$i]['name']) ?>
                                                                                        </p>
                                                                                    </h6>

                                                                                    <ul class="list-inline list-inline-dotted mb-3 mb-lg-2">

                                                                                        <li class="list-inline-item text-muted"> <?= ($data1[$i]['phoneNumber']) ?></li>

                                                                                    </ul>


                                                                                    <p class="mb-3"><span class="font-weight-bold"> Email: </span> <?php if ($data1[$i]["email"] != null) echo $data1[$i]["email"];
                                                                                                                                                    else echo "Chưa cập nhật"; ?></p>



                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>





                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- END-DETAIL  -->

                    </div>
                </div>
            </div>
        </div>

        <!-- DELETE  -->

        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#ModalDelete<?php echo ($data1[$i]['idUser']) ?>">
            <i class="bi bi-lock"></i> <?php if ($data1[$i]['isBan'] == 1) echo "Mở Khóa";
                                        else echo "Khóa" ?>
        </button>
        <div class="modal fade" id="ModalDelete<?php echo ($data1[$i]['idUser']) ?>" tabindex="-1" aria-labelledby="Label_Edit" aria-hidden="true">
            <div class="modal-dialog modal-lg ">
                <!-- modal-xl -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="Label_Edit"> <?php if ($data1[$i]['isBan'] == 1) echo "Mở Khóa";
                                                                    else echo "Khóa" ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <?php if ($data1[$i]['isBan'] == 0) { ?>
                        <form action="./view_banUser.php" method="post">
                            <div class="modal-body">


                                <input type="hidden" name="Ban_User" id="Ban_User" value="<?php echo ($data1[$i]['idUser']) ?>">

                                <div class="form-group">
                                    <label>Bạn có chắc khóa người dùng <span class="text-danger font-weight-bold"> <?php echo ($data1[$i]['name']) ?></span> hay không?</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="submit" name="deletedata" class="btn btn-primary">Khóa</button>

                            </div>
                        </form>
                    <?php } else { ?>
                        <form action="./view_unbanUser.php" method="post">
                            <div class="modal-body">

                                <input type="hidden" name="UnBan_User" id="UnBan_User" value="<?php echo ($data1[$i]['idUser']) ?>">

                                <div class="form-group">
                                    <label>Bạn có chắc mở khóa người dùng <span class="text-danger font-weight-bold"> <?php echo ($data1[$i]['name']) ?></span> hay không?</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="submit" name="undeletedata" class="btn btn-primary">Mở khóa</button>
                            </div>
                        </form>
                </div>
            <?php } ?>

            </div>

        </div>
        </div>
        </div>
        </td>
        <!-- END-DELETE  -->

        </tr>
    <?php } ?>
    </tbody>
    </table>



    </section>

</main><!-- End #main -->


<?php include('../Layout/view_footer.php') ?>
<style>
    table thead {
        background-color: #333;
        color: #fff;
    }
</style>