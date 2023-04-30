<?php include('../layout/header.php'); ?>
<script src="//code.jquery.com/jquery.min.js"></script>

<!-- CSS của Images Grid -->
<script src="https://cdn.jsdelivr.net/gh/taras-d/images-grid/src/images-grid.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/taras-d/images-grid/src/images-grid.min.css" />
<?php

$token = $_SESSION['token'];
$idUser = $result['user']['idUser'];
$data = array(
    'idUser' => $idUser
);
$json_data = json_encode($data);

$url = 'http://localhost:8000/website_openshare/controllers/users/post/manegerRequest.php';


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
<div class="profile-container">
    <?php if (isset($_SESSION['give_Error'])) {
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['give_Error'];
            unset($_SESSION['give_Error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    } ?>
    <?php if (isset($_SESSION['give_success'])) {
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['give_success'];
            unset($_SESSION['give_success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    } ?>
    <?php if (isset($_SESSION['requestApprove_success'])) {
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['requestApprove_success'];
            unset($_SESSION['requestApprove_success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    } ?>
    <?php if (isset($_SESSION['requestApprove_error'])) {
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['requestApprove_error'];
            unset($_SESSION['requestApprove_error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    } ?>
    <?php if (isset($_SESSION['requestRefuse_success'])) {
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['requestRefuse_success'];
            unset($_SESSION['requestRefuse_success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    } ?>

    <div class="page">

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../TrangChu/index.php">Trang chủ</a></li>
            <li class="breadcrumb-item active">Yêu cầu đã nhận </li>
        </ol>

    </div>
    <div class="profile-details displayRequest">
        <div class="pd-left">
            <div class="pd-row">
                <img src="<?= $result['user']['photoURL'] ?>" alt="" class="pd-image" />
                <div>
                    <h3><?= $result['user']['name'] ?></h3>
                    <p>120 Friends - 20 Mutual</p>
                    <img src="../assests/images/member-1.png" alt="" />
                    <img src="../assests/images/member-2.png" alt="" />
                    <img src="../assests/images/member-3.png" alt="" />
                    <img src="../assests/images/member-4.png" alt="" />
                    <img src="../assests/images/member-5.png" alt="" />
                    <img src="../assests/images/member-6.png" alt="" />
                </div>
            </div>
        </div>
        <div class="pd-right">
            <button type="button">
                <img src="../assests/images/add-friends.png" alt="" /> Friends
            </button>
            <button type="button">
                <img src="../assests/images/message.png" alt="" />Message
            </button>
            <br />
            <a href=""><img src="../assests/images/more.png" alt="" /></a>
        </div>
    </div>


    <div class="post-col displayRequest">

        <?php
        if ($data1 == null) {
        ?>
            <div class="post-container">
                <p class="datanull">Không yêu cầu nào được nhận </p>
            </div>
            <?php
        } else {
            $currentIdPost = null;
            for ($i = 0; $i < count($data1); $i++) { ?>
                <?php if ($data1[$i]['idPost'] !== $currentIdPost) : ?>
                    <div class="post-container">
                        <div class="post-row">
                            <div class="user-profile">
                                <a href="#"> <img src="<?= $result['user']['photoURL'] ?>" alt="" />
                                </a>
                                <div>
                                    <a href="#">
                                        <p><?= $result['user']['name'] ?></p>
                                    </a>
                                    <span><?= $data1[$i]['postDate'] ?></span>
                                </div>
                                <div class="address">
                                    <p><i class="fa-solid fa-location-dot"></i> <?= explode(",",  $data1[$i]['address'])[0] ?></p>
                                </div>
                                <div class="type">
                                    <a href="#">
                                        <p><?= $data1[$i]['nameType'] ?></p>
                                    </a>
                                </div>
                            </div>
                            <i class="fas fa-ellipsis-v toggle<?= $i ?>" style="cursor:pointer"></i>
                            <div class="menu-child menu<?= $i ?>">
                                <ul class="child">
                                    <li>

                                        <form action="../post/view_deletePost.php" method="post" id="form_delete">
                                            <a href="#" onclick="document.getElementById('form_delete').submit()">Xoá bài cho</a>
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
                        <div class="post-row">
                            <div class="activity-icons">
                                <div>
                                    <img src="../assests/images/like-blue.png" alt="" />
                                    120
                                </div>
                                <div>
                                    <img src="../assests/images/comments.png" alt="" />
                                    45
                                </div>
                                <div>
                                    <img src="../assests/images/share.png" alt="" />
                                    20
                                </div>
                            </div>

                        </div>
                    </div>
                    <?php $currentIdPost = $data1[$i]['idPost']; ?>
                    <p>
                        <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample<?= $data1[$i]['idPost'] ?>" aria-expanded="false" aria-controls="collapseExample">
                            Xem các yêu cầu
                        </a>
                    </p>
                <?php endif; ?>

                <div class="collapse" id="collapseExample<?= $data1[$i]['idPost'] ?>" style="margin-bottom: 5px;">
                    <div class="card card-body">
                        <div class=" profile-request">
                            <div class="user-profile">
                                <a href="#"> <img src="<?= $data1[$i]['photoURL'] ?>" alt="" />
                                </a>
                                <div>
                                    <a href="#">
                                        <p><?= $data1[$i]['name'] ?></p>
                                    </a>
                                    <span><?= $data1[$i]['requestDate'] ?></span>
                                </div>
                            </div>
                            <div class="status_post">
                                <p><?php if ($data1[$i]['status'] == 0) {
                                        echo "Đang đợi";
                                    } elseif ($data1[$i]['status'] == 1) {
                                        echo "Đã duyệt";
                                    } elseif ($data1[$i]['status'] == 2) {
                                        echo "Từ chối";
                                    } else if ($data1[$i]['status'] == 3) {
                                        echo "Đã cho thành công";
                                    } else if ($data1[$i]['status'] == 4) {
                                        echo "Đã cho thất bại";
                                    }
                                    ?></p>
                            </div>
                        </div>

                        <div style="margin-bottom: 5px;">
                            <span><?= $data1[$i]['message'] ?></span>
                        </div>
                        <?php if ($data1[$i]['status'] == 0) : ?>
                            <div>
                                <button class=" btn btn-primary" data-bs-toggle="modal" data-bs-target="#dongy<?= $data1[$i]['idRequest'] ?>">Đồng ý</button>

                                <div class="modal fade" id="dongy<?= $data1[$i]['idRequest'] ?>" tabindex="-1" aria-labelledby="Label_Edit" aria-hidden="true">
                                    <div class="modal-dialog modal-lg ">
                                        <!-- modal-xl -->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="Label_Edit">Đồng ý yêu cầu</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="../post/view_acceptRequest.php" method="post">
                                                <div class="modal-body">
                                                    <input type="hidden" name="idRequest" value="<?= $data1[$i]['idRequest'] ?>">
                                                    <div class="row mb-3">
                                                        <label for="message" class="col-md-4 col-lg-3 col-form-label">Tin nhắn</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <textarea class="form-control" id="message" name="message" placeholder="Nhập tin nhắn cho người yêu cầu ..." rows="3" required></textarea>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                    <button type="submit" name="acceptRequest" class="btn btn-primary">Đồng ý</button>
                                                </div>
                                            </form>


                                        </div>

                                    </div>
                                </div>
                                <button class=" btn btn-danger" data-bs-toggle="modal" data-bs-target="#tuchoi<?= $data1[$i]['idUserRequest'] ?>">Từ chối</button>

                                <div class="modal fade" id="tuchoi<?= $data1[$i]['idUserRequest'] ?>" tabindex="-1" aria-labelledby="Label_Edit" aria-hidden="true">
                                    <div class="modal-dialog modal-lg ">
                                        <!-- modal-xl -->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="Label_Edit">Từ chối yêu cầu</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="../post/view_refuseRequest.php" method="post">
                                                <div class="modal-body">
                                                    <input type="hidden" name="idRequest" value="<?= $data1[$i]['idRequest'] ?>">

                                                    <div class="form-group">
                                                        <label>Bạn có chắc chắn từ chối yêu cầu này hay không?</label>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                    <button type="submit" name="refuseRequest" class="btn btn-danger">Từ chối</button>
                                                </div>
                                            </form>


                                        </div>

                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if ($data1[$i]['status'] == 1) : ?>
                            <div>
                                <button class=" btn btn-primary" data-bs-toggle="modal" data-bs-target="#chothanhcong<?= $data1[$i]['idUserRequest'] ?>">Cho thành công</button>

                                <div class="modal fade" id="chothanhcong<?= $data1[$i]['idUserRequest'] ?>" tabindex="-1" aria-labelledby="Label_Edit" aria-hidden="true">
                                    <div class="modal-dialog modal-lg ">
                                        <!-- modal-xl -->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="Label_Edit">Cho thành công</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="./view_detailsuccess.php" method="post">
                                                <div class="modal-body">
                                                    <input type="hidden" name="idRequest" value="<?= $data1[$i]['idRequest'] ?>">

                                                    <div class="form-group">
                                                        <label>Bạn có chắc chắn hoàn thành yêu cầu này hay không?</label>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                    <button type="submit" name="successGive" class="btn btn-primary">Xác nhận</button>
                                                </div>
                                            </form>


                                        </div>

                                    </div>
                                </div>
                                <button class=" btn btn-danger" data-bs-toggle="modal" data-bs-target="#chothatbai<?= $data1[$i]['idUserRequest'] ?>">Cho thất bại</button>

                                <div class="modal fade" id="chothatbai<?= $data1[$i]['idUserRequest'] ?>" tabindex="-1" aria-labelledby="Label_Edit" aria-hidden="true">
                                    <div class="modal-dialog modal-lg ">
                                        <!-- modal-xl -->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="Label_Edit">Cho thất bại</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="./view_detailerror.php" method="post">
                                                <div class="modal-body">
                                                    <input type="hidden" name="idRequest" value="<?= $data1[$i]['idRequest'] ?>">

                                                    <div class="form-group">
                                                        <label>Bạn có chắc chắn không cho yêu cầu này hay không?</label>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                    <button type="submit" name="errorGive" class="btn btn-danger">Từ chối</button>
                                                </div>
                                            </form>


                                        </div>

                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
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
    <?php include('../post/view_post.php') ?>
</div>
<script>
    imgInpEl = document.getElementById('fileToUpload');
    imgEL = document.getElementById('img');

    imgInpEl.onchange = evt => {
        const [file] = imgInpEl.files
        if (file) {
            imgEL.src = URL.createObjectURL(file)
        }
    }
</script>
<?php include('../layout/footer.php'); ?>
<script src="../assests/handle_address.js"></script>