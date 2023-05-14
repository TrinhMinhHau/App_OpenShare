<?php include('../Layout/view_header.php') ?>
<?php include('../Layout/view_sidebar.php') ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<style>
    .err {
        font-size: .875em;
        color: red;
    }
</style>

<main id="main" class="main">
    <?php if (isset($_SESSION['capnhat'])) {
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['capnhat'];
            unset($_SESSION['capnhat']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

        </div>
    <?php
    } ?>
    <div class="pagetitle">
        <h1>Thông tin tài khoản</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../Trangchu/Trangchu.php">Trang chủ</a></li>
                <li class="breadcrumb-item active">Thông tin nhân viên</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                        <img src="<?= $result['user']['photoURL'] ?>" alt="Profile" class="rounded-circle">
                        <h2><?= $result['user']['userName'] ?></h2>
                        <h3><?php if ($result['user']['idRole'] == 0) {
                                echo "Nhân viên";
                            } else {
                                echo "Quản lý";
                            } ?></span></h3>
                        <div class="social-links mt-2">
                            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-xl-8">

                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">

                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Giới thiệu</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Chỉnh sửa thông tin</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Đổi mật khẩu</button>
                            </li>

                        </ul>
                        <div class="tab-content pt-2">

                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h5 class="card-title">Sơ lược về bản thân</h5>
                                <p class="small fst-italic"></p>

                                <h5 class="card-title">Chi tiết về bản thân</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Họ và tên</div>
                                    <div class="col-lg-9 col-md-8"><?= $result['user']['name'] ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Địa chỉ</div>
                                    <div class="col-lg-9 col-md-8"><?= $result['user']['address'] ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Số điện thoại</div>
                                    <div class="col-lg-9 col-md-8"><?= $result['user']['phoneNumber'] ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8"><?= $result['user']['email'] ?></div>
                                </div>

                            </div>

                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                <!-- Profile Edit Form -->
                                <form method="post" action="view_editprofile.php" enctype="multipart/form-data">
                                    <div class="row mb-3">
                                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Ảnh đại diện</label>
                                        <div class="col-md-8 col-lg-9">
                                            <img src="<?= $result['user']['photoURL'] ?>" alt="Profile" id="img">
                                            <input type="hidden" value="<?= $result['user']['photoURL'] ?>" name="img" id="img_onchange">
                                            <!-- <div class="pt-2">
                                                <input type="file" name="fileToUpload" id="fileToUpload">
                                            </div> -->
                                            <div class="mb-3 pt-2">
                                                <label for="formFileMultiple" class="form-label"></label>
                                                <input class="form-control" type="file" hidden id="fileToUploadmul" name="fileToUpload">
                                                <input type="button" onClick="getFile.simulate()" value="Chọn tệp ảnh" id="getFile1" />
                                                <label id="selected">Không tệp nào được chọn</label>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="id" value="<?= $result['user']['idStaff'] ?> " class=" form-control">

                                    <div class="row mb-3">
                                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Họ và tên</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="fullName" type="text" class="form-control" id="fullName" value="<?= $result['user']['name'] ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Address" class="col-md-4 col-lg-3 col-form-label">Địa chỉ</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="address" type="text" class="form-control" id="Address" value="<?= $result['user']['address'] ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Số điện thoại</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="phone" type="text" class="form-control" id="Phone" value="<?= $result['user']['phoneNumber'] ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="email" type="email" class="form-control" id="Email" value="<?= $result['user']['email'] ?>">
                                        </div>
                                    </div>


                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary" name="editprofile">Lưu thay đổi</button>
                                    </div>
                                </form><!-- End Profile Edit Form -->

                            </div>


                            <div class="tab-pane fade pt-3" id="profile-change-password">
                                <!-- Change Password Form -->
                                <!-- <form onsubmit="return validateForm()" name="changePasswordForm"> -->


                                <div id="dl_rs">
                                </div>


                                <input type="hidden" name="id" id="id" value="<?= $result['user']['idStaff'] ?> " class=" form-control">

                                <div class="row mb-3">
                                    <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Mật khẩu hiện tại</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="password" type="password" class="form-control" id="currentPassword" required>
                                    </div>
                                    <span id="err_ms" class="err">
                                    </span>
                                </div>

                                <div class="row mb-3">
                                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Mật khẩu mới</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="newpassword" type="password" class="form-control" id="newPassword" required>
                                    </div>
                                    <span id="err_ms1" class="err"></span>
                                </div>

                                <div class="row mb-3">
                                    <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Nhập lại mật khẩu mới</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="renewpassword" type="password" class="form-control" id="renewPassword" required>
                                    </div>
                                    <span id="err_ms2" class="err"></span>

                                </div>

                                <div class="text-center">
                                    <button type="submit" id="changepassword" class="btn btn-primary" name="changepassword">Đổi mật khẩu</button>
                                </div>
                                <!-- </form>End Change Password Form -->

                            </div>

                        </div><!-- End Bordered Tabs -->

                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->
<?php include('../Layout/view_footer.php') ?>

<script>
    $(document).ready(function() {
        $("#changepassword").click(function() {
            const newPassword = $('#newPassword').val();
            const confirmPassword = $('#renewPassword').val();
            if (newPassword.length < 8) {
                $('#err_ms1').html('Mật khẩu phải lớn hơn 7 ký tự');
            } else if (newPassword !== confirmPassword) {
                $('#err_ms1').html('');
                $('#err_ms2').html('Mật khẩu không khớp');
            } else {
                $('#err_ms2').html('');
                $.post("./view_changpassword.php", {
                    id: $("#id").val(),
                    password: $("#currentPassword").val(),
                    newpassword: $("#newPassword").val()
                }, function(data) {
                    $("#dl_rs").html(data);
                })
            }

        });
    });
    imgInpEl = document.getElementById('fileToUploadmul');
    imgEL = document.getElementById('img');

    imgInpEl.onchange = evt => {
        const [file] = imgInpEl.files
        if (file) {
            imgEL.src = URL.createObjectURL(file)
        }
    }
</script>
<script src="../../users/assests/handle_choosefile.js"></script>
<style>
    #selected {
        border-radius: 10px;
        text-transform: uppercase;
        color: teal;
        padding: 0 5px;
        border-width: 1px;
        border-style: solid;
        border-color: grey;
        font-size: 13px !important;
    }

    #getFile1 {
        border-radius: 10px;
        background: teal;
        cursor: pointer;
        color: white;
        padding: 0 5px;
        font-family: Trebuchet MS;
        border: 0;

    }

    #getFile1:hover {
        background: #0aa;
    }
</style>