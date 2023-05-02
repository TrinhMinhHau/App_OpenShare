<?php include('../layout/header.php'); ?>
<script src="//code.jquery.com/jquery.min.js"></script>

<!-- CSS của Images Grid -->
<script src="https://cdn.jsdelivr.net/gh/taras-d/images-grid/src/images-grid.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/taras-d/images-grid/src/images-grid.min.css" />

<!--Profile Page-->
<div class="profile-container1">
    <?php if (isset($_GET['keyword'])) : ?>
        <?php
        $token = $_SESSION['token'];
        $idType = $_GET['idType'];
        $keyword = isset($_GET['keyword']) ? str_replace(' ', '_', $_GET['keyword']) : '';
        $url = 'http://localhost:8000/website_openshare/controllers/users/post/search_pageType.php?keyword=' . $keyword . '&idType=' . $idType;

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
            $data1 = $data ? $data['data'] : null;
        }

        // Đóng cURL session
        curl_close($curl);
        // Tạo các nút phân trang

        ?>
    <?php else : ?>
        <?php
        $token = $_SESSION['token'];
        $idType = $_GET['idType'];
        $data = array(
            'idType' => $idType
        );
        $json_data = json_encode($data);
        $url = 'http://localhost:8000/website_openshare/controllers/users/post/getPostWithType.php';

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
    <?php endif; ?>



    <div class="page">

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../TrangChu/index.php">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="../TrangChu/index.php">Loại đồ cho</a></li>
            <li class="breadcrumb-item active"><?php if ($data1 == null) echo '';
                                                else  echo $data1[0]['nameType'] ?></li>
        </ol>

    </div>


    <div class="post-col displayRequest">

        <?php
        if ($data1 == null) {
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
                                <a href="#">
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
                    <div class="post-row">

                        <div class="post-profile-icon">

                            <?php if ($data1[$i]['idUser'] === $result['user']['idUser']) {
                            } else {
                            ?>
                                <div class="post-profile-icon">

                                    <div style="cursor:pointer">
                                        <div data-bs-toggle="modal" data-bs-target="#request<?php echo $data1[$i]['idPost'] ?>"><img src="../assests/images/send-icon.jpg"> <small> Gửi yêu cầu </small></div>
                                        <div class=" modal fade" id="request<?php echo $data1[$i]['idPost'] ?>" tabindex="-1" aria-labelledby="Label_Edit" aria-hidden="true">
                                            <div class="modal-dialog modal-lg ">
                                                <!-- modal-xl -->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="Label_Edit">Gửi yêu cầu</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="../post/view_sendRequest.php" method="post">
                                                        <div class="modal-body">
                                                            <input type="hidden" name="idPost" id="idPost" value="<?php echo $data1[$i]['idPost'] ?>">
                                                            <input type="hidden" name="idUserRequest" id="idPost" value="<?php echo $result['user']['idUser'] ?>">

                                                            <div class="row mb-3">
                                                                <label for="message" class="col-md-4 col-lg-3 col-form-label">Tin nhắn</label>
                                                                <div class="col-md-8 col-lg-9">
                                                                    <textarea class="form-control" id="message" name="message" placeholder="Mô tả ..." rows="3"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                            <button type="submit" name="sendRequest" class="btn btn-primary">Gửi</button>
                                                        </div>
                                                    </form>


                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            <?php  } ?>


                        </div>
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