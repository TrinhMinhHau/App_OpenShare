<?php include('../Layout/view_header.php') ?>
<?php include('../Layout/view_sidebar.php') ?>

<?php

$token = $_SESSION['token_admin'];
$url = 'http://localhost:8000/website_openshare/controllers/admin/ItemType/displayItem.php';

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
    <?php if (isset($_SESSION['status_success'])) {
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['status_success'];
            unset($_SESSION['status_success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

        </div>

    <?php } ?>
    <?php if (isset($_SESSION['status_error'])) {
    ?>

        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?= $_SESSION['status_error'];
            unset($_SESSION['status_error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

        </div>
    <?php } ?>
    <?php if (isset($_SESSION['status_delete'])) {
    ?>

        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['status_delete'];
            unset($_SESSION['status_delete']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

        </div>
    <?php } ?>
    <?php if (isset($_SESSION['status_update_success'])) {
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['status_update_success'];
            unset($_SESSION['status_update_success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

        </div>

    <?php } ?>
    <div class="pagetitle">
        <h1>Quản lý loại đồ dùng</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../Trangchu/Trangchu.php">Trangchu</a></li>
                <li class="breadcrumb-item ">Quản lý loại đồ dùng</li>
                <li class="breadcrumb-item active">Loại đồ dùng</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <!--add -->


        <div class="card">
            <div class="card-body d-flex flex-row justify-content-between align-items-center pt-3">

                <button type="button" class="btn btn-primary p-3" data-bs-toggle="modal" data-bs-target="#addmodal">
                    <i class="bi bi-plus-lg"></i>Thêm mới
                </button>

            </div>
        </div>
        <form action="./view_addItem.php" method="post">
            <div class="modal fade" id="addmodal" tabindex="-1" aria-labelledby="Label_Add" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div id="dl_rs"></div>
                        <div class="modal-header">

                            <h5 class="modal-title" id="Label_Add">Thêm mới</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group ">
                                <label for="Them_LoaiDoDung">Tên loại đồ dùng</label>
                                <input required value="<?php if (isset($_POST['Them_LoaiDoDung'])) echo $_POST['Them_LoaiDoDung'];
                                                        else ""; ?>" required type="text" name="Them_LoaiDoDung" class="form-control" id="Them_LoaiDoDung" placeholder="Nhập tên loại đồ dùng cần thêm">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="close">Đóng</button>
                            <button type="reset" name="reset" class="btn btn-warning" id="reset">Xoá dữ liệu</button>
                            <button type="submit" name="addItem" class="btn btn-primary" id="Them_Moi">Thêm mới</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- end add -->
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
                                    <th scope="col">Tên loại đồ dùng</th>
                                    <th colspan="2">Chức năng</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                for ($i = 0; $i < count($data1); $i++) { ?>
                                    <tr>
                                        <th scope="col"><?= $i + 1 ?></td>
                                        <td><?= ($data1[$i]['idType']) ?></td>
                                        <td><?= ($data1[$i]['nameType']) ?></td>
                    </div>
                </div>
            </div>
        </div>
        </td>
        <!-- UPDATE -->
        <td>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ModalUpdate<?php echo ($data1[$i]['idType']) ?>">
                <i class="ri-refresh-line"></i> Cập nhật
            </button>
            <div class="modal fade" id="ModalUpdate<?php echo ($data1[$i]['idType']) ?>" tabindex="-1" aria-labelledby="Label_Edit" aria-hidden="true">
                <div class="modal-dialog modal-lg ">
                    <!-- modal-xl -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="Label_Edit">Cập nhật</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="./view_updateItem.php" method="post">
                            <div class="modal-body">


                                <input type="hidden" name="idType" id="idType" value="<?php echo ($data1[$i]['idType']) ?>">
                                <div class="form-group ">
                                    <label for="CapNhat_LoaiDoDung">Tên loại đồ dùng</label>
                                    <input required value="<?php echo $data1[$i]['nameType'] ?>" required type="text" name="CapNhat_LoaiDoDung" class="form-control" id="CapNhat_LoaiDoDung" placeholder="Nhập tên loại đồ dùng">
                                </div>
                                </br>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="submit" name="updateItem" class="btn btn-primary">Cập nhật</button>

                            </div>
                        </form>


                    </div>

                </div>
            </div>
            </div>

            <!-- ENDUPDATE -->
            <!-- DELETE  -->
            <?php if ($data1[$i]['idType'] === 8) : ?>
            <?php else : ?>
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#ModalDelete<?php echo ($data1[$i]['idType']) ?>">
                    <i class="bi bi-trash-fill"></i> Xóa
                </button>
                <div class="modal fade" id="ModalDelete<?php echo ($data1[$i]['idType']) ?>" tabindex="-1" aria-labelledby="Label_Edit" aria-hidden="true">
                    <div class="modal-dialog modal-lg ">
                        <!-- modal-xl -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="Label_Edit">Xóa</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="./view_deleteItem.php" method="post">
                                <div class="modal-body">


                                    <input type="hidden" name="idType" id="idType" value="<?php echo ($data1[$i]['idType']) ?>">

                                    <div class="form-group">
                                        <label>Bạn có chắc chắn xóa <span class="text-danger font-weight-bold"> <?php echo ($data1[$i]['nameType']) ?></span> hay không?</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                    <button type="submit" name="deleteItem" class="btn btn-danger">Xóa</button>

                                </div>
                            </form>


                        </div>

                    </div>
                </div>
                </div>
            <?php endif ?>
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