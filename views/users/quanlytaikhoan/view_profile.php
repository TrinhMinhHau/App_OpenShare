<?php include('../layout/header.php'); ?>
<script src="//code.jquery.com/jquery.min.js"></script>

<!-- CSS của Images Grid -->
<script src="https://cdn.jsdelivr.net/gh/taras-d/images-grid/src/images-grid.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/taras-d/images-grid/src/images-grid.min.css" />
<?php

$token = $_SESSION['token'];
$idUser = $result['user']['idUser'];
$data = array(
    'id_Userget' => $idUser
);
$json_data = json_encode($data);

$url = 'http://localhost:8000/website_openshare/controllers/users/post/displayPostbyidUser.php';


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
    $data1 = $data ? $data['data'] : null;
}

// Đóng cURL session
curl_close($curl);
?>
<!--Profile Page-->
<div class="page" style="margin-top: 30px;">

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="../TrangChu/index.php">Trang chủ</a></li>
        <li class="breadcrumb-item active">Trang cá nhân</li>
    </ol>

</div>
<div class="profile-container">
    <?php if (isset($_SESSION['post_success'])) {
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['post_success'];
            unset($_SESSION['post_success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    } ?>
    <?php if (isset($_SESSION['status_delete_post'])) {
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['status_delete_post'];
            unset($_SESSION['status_delete_post']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    } ?>
    <?php if (isset($_SESSION['status_delete'])) {
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['status_delete'];
            unset($_SESSION['status_delete']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    } ?>
    <?php if (isset($_SESSION['status_success'])) {
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['status_success'];
            unset($_SESSION['status_success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    } ?>
    <?php if (isset($_SESSION['status_error'])) {
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['status_error'];
            unset($_SESSION['status_error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    } ?>
    <?php if (isset($_SESSION['capnhat'])) {
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['capnhat'];
            unset($_SESSION['capnhat']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    } ?>

    <div class="profile-details">
        <div class="pd-left">
            <div class="pd-row">
                <img src="<?= $result['user']['photoURL'] ?>" alt="" class="pd-image" />
                <div>
                    <h3><?= $result['user']['name'] ?></h3>
                    <?php

                    $token = $_SESSION['token'];
                    $idUser = $result['user']['idUser'];
                    $data = array(
                        'idUser' => $idUser
                    );
                    $json_data = json_encode($data);

                    $url = 'http://localhost:8000/website_openshare/controllers/users/post/displaynumberItemGiveSuccess.php';


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
                        $data5 = $data ? $data['data'] : null;
                    }

                    // Đóng cURL session
                    curl_close($curl);
                    ?>
                    <p style="margin-left: 5px; font-size:15px;" class="text-bold">Đã Cho <span class="text-success"><?php if ($data5 == null) echo 0;
                                                                                                                        else echo $data5[0]['SoluongdochoTC'] ?></span></p>

                </div>
            </div>
        </div>
    </div>

    <div class="profile-info">
        <div class="info-col">
            <div class="profile-intro">
                <div class="update-info">
                    <h3>Thông tin cơ bản</h3>
                    <a href="#" class="address_user" data-bs-toggle="modal" data-bs-target="#capnhat" role="button">Cập nhật</a>

                    <div class="modal fade" id="capnhat" tabindex="-1" aria-labelledby="Label_Edit" aria-hidden="true">
                        <div class="modal-dialog modal-lg ">
                            <!-- modal-xl -->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="Label_Edit">Cập nhật</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="./view_editprofile.php" method="post" enctype="multipart/form-data">
                                    <div class="modal-body">

                                        <div class="row mb-3">
                                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Ảnh đại diện</label>
                                            <div class="col-md-8 col-lg-9">
                                                <img src="<?= $result['user']['photoURL'] ?>" alt="Profile" id="img" width="100px" height="100px">
                                                <input type="hidden" value="<?= $result['user']['photoURL'] ?>" name="img" id="img_onchange">
                                                <div class="mb-3 pt-2">
                                                    <label for="formFileMultiple" class="form-label"></label>
                                                    <input class="form-control" type="file" hidden id="fileToUploadmul" name="fileToUpload">
                                                    <input type="button" onClick="getFile.simulate()" value="Chọn tệp ảnh" id="getFile1" />
                                                    <label id="selected">Không tệp nào được chọn</label>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="id" value="<?= $result['user']['idUser'] ?> " class=" form-control">

                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Họ và tên</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="fullName" type="text" class="form-control" id="fullName" value="<?= $result['user']['name'] ?>">
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

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                        <button type="submit" name="editprofile" class="btn btn-primary">Lưu thay đổi</button>

                                    </div>
                                </form>


                            </div>

                        </div>
                    </div>


                </div>
                <hr />
                <ul>
                    <li>
                        <img src="../assests/images/email-icon2.png" alt="" /> <?php if ($result['user']['email'] == null) echo "Chưa cập nhật";
                                                                                else echo $result['user']['email'] ?>
                    </li>
                    <li>
                        <img src="../assests/images/icon-phone.png" alt="" /><?php if ($result['user']['phoneNumber'] == null) echo "Chưa cập nhật";
                                                                                else echo $result['user']['phoneNumber'] ?>
                    </li>
                </ul>
                <hr />
                <div class="update-info">
                    <h3>Địa chỉ</h3>
                    <!-- <button type="button" class="btn btn-primary btn-sm address_user" data-bs-toggle="modal" data-bs-target="#them">
                        Thêm
                    </button> -->
                    <a href="#" class="address_user" data-bs-toggle="modal" data-bs-target="#them" role="button">Thêm</a>

                    <div class="modal fade" id="them" tabindex="-1" aria-labelledby="Label_Edit" aria-hidden="true">
                        <div class="modal-dialog modal-lg ">
                            <!-- modal-xl -->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="Label_Edit">Thêm</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="./view_createAddress.php" method="post">
                                    <div class="modal-body">

                                        <input type="hidden" name="idUser" id="idPost" value="<?php echo ($result['user']['idUser']) ?>">
                                        <div class="form-group">
                                            <div class="container">

                                                <div class="row">
                                                    <div class="col-md-3"><select name="" id="province" class="form-select" required></select></div>
                                                    <div class="col-md-3"> <select name="" id="district" class=" form-select" required>
                                                            <option value="">chọn quận</option>
                                                        </select></div>
                                                    <div class="col-md-3">
                                                        <select name="" id="ward" class="form-select" required>
                                                            <option value="">chọn phường</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="text" placeholder="Nhập số nhà" class="input-group p-1" id="street" required>

                                                    </div>
                                                    <input type="hidden" name="result" id="result" value="" />
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                        <button type="submit" name="createAddress" class="btn btn-primary">Thêm</button>

                                    </div>
                                </form>


                            </div>

                        </div>
                    </div>
                </div>
                <hr />
                <ul>
                    <?php

                    $token = $_SESSION['token'];
                    $idUser = $result['user']['idUser'];
                    $data = array(
                        'idUser' => $idUser
                    );
                    $json_data = json_encode($data);

                    $url = 'http://localhost:8000/website_openshare/controllers/users/address/get.php';


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
                        $data2 = $data ? $data['data'] : null;
                    }

                    // Đóng cURL session
                    curl_close($curl);
                    ?>

                    <?php
                    if ($data2 == null) { ?>
                        <li>
                            <img src="../assests/images/profile-location.png" alt="" />Chưa cập nhật
                        </li>
                        <?php } else {

                        for ($i = 0; $i < count($data2); $i++) { ?>
                            <li>
                                <img src="../assests/images/profile-location.png" alt="" /><?= $data2[$i]['address'] ?>

                                <a href="#" class="address_user" data-bs-toggle="modal" data-bs-target="#ModalDelete<?php echo ($data2[$i]['idAdress']) ?>" role="button">xóa</a>

                                <div class="modal fade" id="ModalDelete<?php echo ($data2[$i]['idAdress']) ?>" tabindex="-1" aria-labelledby="Label_Edit" aria-hidden="true">
                                    <div class="modal-dialog modal-lg ">
                                        <!-- modal-xl -->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="Label_Edit">Xóa</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="./view_deleteAddress.php" method="post">
                                                <div class="modal-body">


                                                    <input type="hidden" name="idAddress" id="idPost" value="<?php echo ($data2[$i]['idAdress']) ?>">

                                                    <div class="form-group">
                                                        <label>Bạn có chắc chắn xóa địa chỉ <span class="text-danger"><?= $data2[$i]['address'] ?></span> hay không?</label>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                    <button type="submit" name="deleteAddress" class="btn btn-danger">Xóa</button>

                                                </div>
                                            </form>


                                        </div>

                                    </div>
                                </div>
                            </li>
                    <?php }
                    } ?>
                </ul>
            </div>
        </div>
        <div class="post-col">

            <?php
            if ($data1 == null) {
            ?>
                <div class="post-container">
                    <p class="datanull">Không có bài đăng nào </p>
                </div>
                <?php
            } else {
                for ($i = 0; $i < count($data1); $i++) {
                ?>


                    <div class="post-container">
                        <div class="post-row">
                            <div class="user-profile">
                                <a href="#"> <img src="<?= $data1[$i]['photoURL'] ?>" alt="" />
                                </a>
                                <div>
                                    <a href="#">
                                        <p><?= $data1[$i]['name'] ?></p>
                                    </a>
                                    <span><?= $data1[$i]['postDate'] ?></span>
                                </div>
                                <div class="address">
                                    <p><i class="fa-solid fa-location-dot"></i> <?= explode(",",  $data1[$i]['address'])[0] ?></p>
                                </div>
                                <div class="type">
                                    <a href="../post/view_displayPostWithType.php?idType=<?= $data1[$i]['idType'] ?>">
                                        <p><?= $data1[$i]['nameType'] ?></p>
                                    </a>
                                </div>
                                <div class="status_post">
                                    <p><?php if ($data1[$i]['isShow'] == 0) {
                                            echo "Đang đợi duyệt";
                                        } elseif ($data1[$i]['isShow'] == 1 && $data1[$i]['soluongdocho'] > 0) {
                                            echo "Đang cho";
                                        } elseif ($data1[$i]['isShow'] == 1 && $data1[$i]['soluongdocho'] == 0) {
                                            echo "Cho thành công";
                                        } else if ($data1[$i]['isShow'] == 2) {
                                            echo "Bị từ chối";
                                        }
                                        ?></p>
                                </div>
                            </div>
                            <?php if ($data1[$i]['isShow'] == 0) : ?>
                                <i class="fas fa-ellipsis-v toggle<?= $i ?>" style="cursor:pointer"></i>
                                <div class="menu-child menu<?= $i ?>">
                                    <ul class="child">
                                        <li>
                                            <form action="../post/view_deletePost.php" method="post" id="form_delete<?= $i ?>">
                                                <a href="#" onclick="document.getElementById('form_delete<?= $i ?>').submit()">Xoá bài cho</a>
                                                <input type="hidden" name="deletePost" value="<?= $data1[$i]['idPost'] ?>">
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                                <script>
                                    document.querySelector('.toggle<?= $i ?>').addEventListener('click', function() {
                                        document.querySelector('.menu<?= $i ?>').classList.toggle('active');
                                    });
                                </script>
                            <?php endif; ?>
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
                        <div class="post-row">

                        </div>
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
        </div>
    </div>
</div>
<script>
    imgInpEl = document.getElementById('fileToUploadmul');
    imgEL = document.getElementById('img');

    imgInpEl.onchange = evt => {
        const [file] = imgInpEl.files
        if (file) {
            imgEL.src = URL.createObjectURL(file)
        }
    }
</script>
<?php include('../layout/footer.php'); ?>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
<script src="../assests/handle_address.js"></script>
<script src="../assests/handle_choosefile.js"></script>
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