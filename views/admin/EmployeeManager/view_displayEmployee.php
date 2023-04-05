<?php include('../Layout/view_header.php') ?>
<?php include('../Layout/view_sidebar.php') ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<style>
    #err_ms1 {
        font-size: .875em;
        color: red;
    }
</style>
<?php

$token = $_SESSION['token'];
$url = 'http://localhost:8000/website_openshare/controllers/admin/EmployeeManager/displayEmployee.php';

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
        <h1>Quản lý nhân viên</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../Trangchu/Trangchu.php">Trangchu</a></li>
                <li class="breadcrumb-item active">Nhân viên</li>
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
                            <label for="Them_TaiKhoan">Tài khoản</label>
                            <input required value="" required type="text" name="Them_TaiKhoan" class="form-control" id="Them_TaiKhoan" placeholder="Nhập tài khoản">
                        </div>

                        <div class="form-group ">
                            <label for="Them_MatKhau">Mật khẩu</label>
                            <input required value="" required type="password" name="Them_MatKhau" class="form-control" id="Them_MatKhau" placeholder="Nhập mật khẩu">
                            <small id="err_ms1"></small>

                        </div>
                        <div class="form-group ">
                            <label for="Them_HoTen">Họ tên</label>
                            <div class="form-group">
                                <input required value="" required type="text" name="Them_HoTen" class="form-control" id="Them_HoTen" placeholder="Nhập họ tên">

                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="Them_Email">Email</label>
                            <input required value="" required type="text" name="Them_Email" class="form-control" id="Them_Email" placeholder="Nhập điện thoại">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="close">Đóng</button>
                        <button type="reset" name="reset" class="btn btn-warning" id="reset">Xoá dữ liệu</button>
                        <button type="submit" name="insertdata" class="btn btn-primary" id="Them_Moi">Thêm mới</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end add -->
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">

                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Mã số</th>
                                    <th scope="col">Họ và tên</th>
                                    <th scope="col">Tài khoản</th>
                                    <!-- <th scope="col">Email</th> -->
                                    <th scope="col">Ảnh đại diện</th>
                                    <th></th>
                                    <th></th>
                                    <!-- <th scope="col">Số điện thoại</th>
                                    <th scope="col">Địa chỉ</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                for ($i = 0; $i < count($data1); $i++) { ?>
                                    <tr>
                                        <th scope="col"><?= $i + 1 ?></td>
                                        <td><?= ($data1[$i]['idStaff']) ?></td>
                                        <td><?= ($data1[$i]['name']) ?></td>
                                        <td><?= ($data1[$i]['userName']) ?></td>
                                        <td><img src="<?= ($data1[$i]['photoURL']) ?>" alt="" srcset="" width="50px" height="20px" style="border-radius:50%"></td>
                                        <td>
                                            <!-- DETAIL  -->
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#Modal_Detail<?php echo ($data1[$i]['idStaff']) ?>">
                                                Chi tiết
                                            </button>
                                            <div class="modal fade" id="Modal_Detail<?php echo ($data1[$i]['idStaff']) ?>" tabindex="-1" aria-labelledby="LabelModal" aria-hidden="true">
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

                                                                                    <p class="mb-3"><span class="font-weight-bold"> Địa chỉ: </span> <?php if ($data1[$i]["address"] != null) echo $data1[$i]["address"];
                                                                                                                                                        else echo "Chưa cập nhật"; ?></p>
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
                                        </td>
                    </div>
                </div>
            </div>
        </div>
        </td>
        <!-- DELETE  -->
        <td>
            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#ModalDelete<?php echo ($data1[$i]['idStaff']) ?>">
                <?php if ($data1[$i]['isBan'] == 1) echo "Mở Khóa";
                                    else echo "Khóa" ?>
            </button>
            <div class="modal fade" id="ModalDelete<?php echo ($data1[$i]['idStaff']) ?>" tabindex="-1" aria-labelledby="Label_Edit" aria-hidden="true">
                <div class="modal-dialog modal-lg ">
                    <!-- modal-xl -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="Label_Edit"> <?php if ($data1[$i]['isBan'] == 1) echo "Mở Khóa";
                                                                        else echo "Khóa" ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <?php if ($data1[$i]['isBan'] == 0) { ?>
                            <form action="./view_banEmployee.php" method="post">
                                <div class="modal-body">


                                    <input type="hidden" name="Ban_Employee" id="Ban_Employee" value="<?php echo ($data1[$i]['idStaff']) ?>">

                                    <div class="form-group">
                                        <label>Bạn có chắc khóa nhân viên <span class="text-danger font-weight-bold"> <?php echo ($data1[$i]['name']) ?></span> hay không?</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                    <button type="submit" name="deletedata" class="btn btn-primary">Khóa</button>

                                </div>
                            </form>
                        <?php } else { ?>
                            <form action="./view_unbanEmployee.php" method="post">
                                <div class="modal-body">

                                    <input type="hidden" name="Ban_Employee" id="Ban_Employee" value="<?php echo ($data1[$i]['idStaff']) ?>">

                                    <div class="form-group">
                                        <label>Bạn có chắc mở khóa nhân viên <span class="text-danger font-weight-bold"> <?php echo ($data1[$i]['name']) ?></span> hay không?</label>
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


<script>
    $(document).ready(function() {
        $("#Them_Moi").click(function() {
            const password = $('#Them_MatKhau').val();
            if (password.length < 8) {
                $('#err_ms1').html('Mật khẩu phải lớn hơn 7 ký tự');
            } else {
                $('#err_ms1').html('');
                $.post("../Staff/view_register.php", {
                    userName: $('#Them_TaiKhoan').val(),
                    password: $("#Them_MatKhau").val(),
                    name: $("#Them_HoTen").val()

                }, function(data) {
                    $("#dl_rs").html(data);
                })
            }

        });
    });

    const close = document.getElementById("close");
    close.onclick = function() {
        window.location.href = './view_displayEmployee.php';

    }

    const usernameEl = document.getElementById("Them_TaiKhoan");

    const passwordEl = document.getElementById("Them_MatKhau");
    const nameEl = document.getElementById("Them_HoTen");

    document.getElementById("reset").onclick = function() {
        usernameEl.value = '';
        passwordEl.value = '';
        nameEl.value = '';
    }
</script>