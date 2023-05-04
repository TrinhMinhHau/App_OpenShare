<?php include('../Layout/view_header.php') ?>
<?php include('../Layout/view_sidebar.php') ?>

<?php

$token = $_SESSION['token'];
$url = 'http://localhost:8000/website_openshare/controllers/admin/PostManager/displayUnapprovedPost.php';

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

    <?php if (isset($_SESSION['status_reject_success'])) {
    ?>

        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['status_reject_success'];
            unset($_SESSION['status_reject_success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

        </div>
    <?php } ?>

    <div class="pagetitle">
        <h1>Quản lý loại đồ dùng</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../Trangchu/Trangchu.php">Trangchu</a></li>
                <li class="breadcrumb-item ">Quản lý bài viết</li>
                <li class="breadcrumb-item active">Bài viết chưa duyệt</li>
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
                                    <th scope="col">Tên người đăng</th>
                                    <th scope="col">Tiêu đề</th>
                                    <th scope="col">Tên loại</th>
                                    <th scope="col">Ngày đăng</th>
                                    <th scope="col">Chức năng</th>

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
                                                                                        <h3 class="media-title">
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


                                                                <div id="reason-form<?php echo $data1[$i]['idPost'] ?>" style="display: none;">
                                                                    <form action="./view_rejectPost.php" method="post">
                                                                        <label for="reason" class="col-md-4 col-lg-3 col-form-label">Lý do từ chối</label>
                                                                        <div class=" media-body col-md-12 col-lg-12 mb-1">
                                                                            <textarea class="form-control" id="reason" name="reason" placeholder="Nhập lý do từ chối ..." rows="3" required></textarea>
                                                                        </div>
                                                                        <button type="submit" class="btn btn-danger" name="Tuchoi">Từ chối</button>
                                                                        <button type="button" class="btn btn-secondary" onclick="hideReasonForm(<?php echo ($data1[$i]['idPost']) ?>)">Hủy</button>
                                                                        <input type="hidden" name="idPost" id="idPost" value="<?php echo ($data1[$i]['idPost']) ?>">
                                                                        <input type="hidden" name="idStaff" id="idStaff" value="<?php echo ($result['user']['idStaff']) ?>">
                                                                        <input type="hidden" name="idUser" id="idUser" value="<?php echo ($data1[$i]['idUser']) ?>">
                                                                        <input type="hidden" name="title" id="title" value="<?php echo ($data1[$i]['title']) ?>">
                                                                    </form>
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <form action="./view_approvPost.php" method="post">
                                                                    <button type="submit" id="duyet<?php echo $data1[$i]['idPost'] ?>" class="btn btn-primary" data-bs-dismiss="modal" name="Duyet">Duyệt</button>
                                                                    <input type="hidden" name="idPost" id="idPost" value="<?php echo ($data1[$i]['idPost']) ?>">
                                                                    <input type="hidden" name="idStaff" id="idStaff" value="<?php echo ($result['user']['idStaff']) ?>">
                                                                    <input type="hidden" name="idUser" id="idUser" value="<?php echo ($data1[$i]['idUser']) ?>">
                                                                    <input type="hidden" name="title" id="title" value="<?php echo ($data1[$i]['title']) ?>">
                                                                </form>
                                                                <!-- <form action="./view_rejectPost.php" method="post">
                                                                    <button type="submit" class="btn btn-danger" data-bs-dismiss="modal" name="Tuchoi">Từ chối</button>
                                                                    <input type="hidden" name="idPost" id="idPost" value="<?php echo ($data1[$i]['idPost']) ?>">
                                                                    <input type="hidden" name="idStaff" id="idStaff" value="<?php echo ($result['user']['idStaff']) ?>">
                                                                    <input type="hidden" name="idUser" id="idUser" value="<?php echo ($data1[$i]['idUser']) ?>">
                                                                    <input type="hidden" name="title" id="title" value="<?php echo ($data1[$i]['title']) ?>">

                                                                </form> -->
                                                                <button type="submit" class="btn btn-danger" id="tuchoi<?php echo ($data1[$i]['idPost']) ?>" onclick="showReasonForm(<?php echo ($data1[$i]['idPost']) ?>)">Từ Chối </button>

                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- END-DETAIL  -->
                                            </td>


                    </div>

                </div>

            </div>
        </div>
        </td>
        <!-- UPDATE -->

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
<script>
    function showReasonForm(idPost) {
        document.getElementById("reason-form" + idPost).style.display = "block";
        document.getElementById("duyet" + idPost).style.display = "none";
        document.getElementById("tuchoi" + idPost).style.display = "none";
    }

    function hideReasonForm(idPost) {
        document.getElementById("reason-form" + idPost).style.display = "none";
        document.getElementById("duyet" + idPost).style.display = "inline-block";
        document.getElementById("tuchoi" + idPost).style.display = "inline-block";
    }
</script>