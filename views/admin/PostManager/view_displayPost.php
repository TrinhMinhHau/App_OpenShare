<?php include('../Layout/view_header.php') ?>
<?php include('../Layout/view_sidebar.php') ?>

<?php

$token = $_SESSION['token_admin'];
$url = 'http://localhost:8000/website_openshare/controllers/admin/PostManager/displayapprovPost.php';

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

    <?php if (isset($_SESSION['status_approv_success'])) {
    ?>

        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['status_approv_success'];
            unset($_SESSION['status_approv_success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

        </div>
    <?php } ?>
    <?php if (isset($_SESSION['status_delete'])) { ?>


        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['status_delete'];
            unset($_SESSION['status_delete']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

        </div>
    <?php } ?>
    <div class="pagetitle">
        <h1>Quản lý bài cho</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../Trangchu/Trangchu.php">Trangchu</a></li>
                <li class="breadcrumb-item ">Quản lý bài cho</li>
                <li class="breadcrumb-item active">Bài cho</li>
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
                            <thead class="  ">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Mã số</th>
                                    <th scope="col">Tên người đăng</th>
                                    <th scope="col">Tiêu đề</th>
                                    <th scope="col">Tên loại</th>
                                    <th scope="col">Ngày đăng</th>
                                    <th scope="col">Mã NV duyệt</th>
                                    <th colspan=2>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($data1 == null) {
                                } else {
                                    for ($i = 0; $i < count($data1); $i++) { ?>
                                        <tr>
                                            <th scope="col"><?= $i + 1 ?></td>
                                            <td><?= ($data1[$i]['idPost']) ?></td>
                                            <td><?= ($data1[$i]['name']) ?></td>
                                            <td><?= ($data1[$i]['title']) ?></td>
                                            <td><?= ($data1[$i]['nameType']) ?></td>
                                            <td><?= ($data1[$i]['postDate']) ?></td>
                                            <td><?= ($data1[$i]['idStaffApprove']) ?></td>

                                            <td>
                                                <!-- DETAIL  -->
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#Modal_Detail<?php echo ($data1[$i]['idPost']) ?>">
                                                    <i class="bi bi-info-circle"></i> Chi tiết
                                                </button>
                                                <div class="modal fade" id="Modal_Detail<?php echo ($data1[$i]['idPost']) ?>" tabindex="-1" aria-labelledby="LabelModal" aria-hidden="true">
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
                                                                                        <?php
                                                                                        // var_dump(json_decode($data1[$i]['photos']));
                                                                                        for ($j = 0; $j < count(json_decode($data1[$i]['photos'])); $j++) {
                                                                                        ?>

                                                                                            <img src="<?php echo json_decode($data1[$i]['photos'])[$j] ?> " alt="" srcset="" width="100px" height="100px">
                                                                                        <?php
                                                                                        }
                                                                                        ?>
                                                                                    </div>
                                                                                    </br>
                                                                                    <div class="media-body">
                                                                                        <h3 class="media-title ">
                                                                                            <p class="text-black">
                                                                                                Địa chỉ: <?= ($data1[$i]['address']) ?>
                                                                                            </p>
                                                                                        </h3>
                                                                                        <h6 class="media-title font-weight-semibold">
                                                                                            <h2 class="text-black">Mô tả</h2>
                                                                                            <p class="text-black">
                                                                                                <?= ($data1[$i]['description']) ?>
                                                                                            </p>
                                                                                        </h6>


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

                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#ModalDelete<?php echo ($data1[$i]['idPost']) ?>">
                                                    <i class="bi bi-trash-fill"></i> Xóa
                                                </button>
                                                <div class="modal fade" id="ModalDelete<?php echo ($data1[$i]['idPost']) ?>" tabindex="-1" aria-labelledby="Label_Edit" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg ">
                                                        <!-- modal-xl -->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="Label_Edit">Xóa</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="./view_deletePost.php" method="post">
                                                                <div class="modal-body">


                                                                    <input type="hidden" name="idPost" id="idPost" value="<?php echo ($data1[$i]['idPost']) ?>">

                                                                    <div class="form-group">
                                                                        <label>Bạn có chắc chắn xóa bài viết này hay không?</label>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                                    <button type="submit" name="deletePost" class="btn btn-primary">Xóa</button>

                                                                </div>
                                                            </form>


                                                        </div>

                                                    </div>
                                                </div>
                    </div>

                    </td>


                </div>

            </div>

        </div>
        </div>
        </td>
        <!-- DELETE  -->

        <!-- END-DELETE  -->

        </tr>
<?php }
                                } ?>

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