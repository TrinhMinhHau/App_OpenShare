<?php include('../layout/header.php'); ?>
<script src="//code.jquery.com/jquery.min.js"></script>

<!-- CSS của Images Grid -->
<script src="https://cdn.jsdelivr.net/gh/taras-d/images-grid/src/images-grid.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/taras-d/images-grid/src/images-grid.min.css" />

<!--Profile Page-->
<div class="profile-container1">

    <?php
    $token = $_SESSION['token'];
    $idPost = $_GET['idPost'];
    $data = array(
        'idPost' => $idPost
    );
    $json_data = json_encode($data);
    $url = 'http://localhost:8000/website_openshare/controllers/users/post/getPostWithidPost.php';

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

    <div class="post-col displayRequest">

        <?php
        if ($data1 == null) {
        } else {

        ?>

            <div class="post-container">
                <div class="post-row">
                    <div class="user-profile">
                        <a href="../quanlytaikhoan/view_user.php?idUser=<?= $data1[0]['idUser'] ?>"> <img src="<?= $data1[0]['photoURL'] ?>" alt="" />
                        </a>
                        <div>
                            <a href="../quanlytaikhoan/view_user.php?idUser=<?= $data1[0]['idUser'] ?>">
                                <p><?= $data1[0]['name'] ?></p>
                            </a>
                            <span><?= $data1[0]['postDate'] ?></span>
                        </div>
                        <div class="address">
                            <p><i class="fa-solid fa-location-dot"></i> <?= explode(",",  $data1[0]['address'])[0] ?></p>
                        </div>
                        <div class="type">
                            <a href="../post/view_displayPostWithType.php?idType=<?= $data1[0]['idType'] ?>">
                                <p><?= $data1[0]['nameType'] ?></p>
                            </a>
                        </div>
                        <div class="status_post">
                            <p><?php if ($data1[0]['isShow'] == 2) {
                                    echo "Không được duyệt";
                                } elseif ($data1[0]['isShow'] == 1) {
                                    echo "Đã được duyệt";
                                }
                                ?></p>
                        </div>

                    </div>

                </div>
                <p class="post-text">
                    <?= $data1[0]['description'] ?>
                </p>
                <div id="post-image">
                    <?php
                    if ($data1[0]['photos'] == null) {
                    } else {
                        $arr_img = [];
                        for ($j = 0; $j < count(json_decode($data1[0]['photos'])); $j++) {
                            array_push($arr_img, json_decode($data1[0]['photos'])[$j]);
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
                    $("#post-image").imagesGrid({
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