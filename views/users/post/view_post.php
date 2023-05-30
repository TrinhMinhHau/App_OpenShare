    <div class="post">
        <i class="fa-regular fa-pen-to-square" data-bs-toggle="modal" data-bs-target="#post"></i>

        <div class="modal fade" id="post" tabindex="-1" aria-labelledby="Label_Edit" aria-hidden="true">
            <div class="modal-dialog modal-lg ">
                <!-- modal-xl -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="Label_Edit">Đăng bài cho</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="../post/view_scriptpost.php" method="post" id="form_post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row mb-3">
                                <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Tiêu đề</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="title" type="text" class="form-control" id="fullName" placeholder="Bếp ga cũ cầm cho ..." required oninvalid="this.setCustomValidity('Vui lòng nhập tiêu đề!!!')" oninput="setCustomValidity('')">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="description" class="col-md-4 col-lg-3 col-form-label">Mô tả</label>
                                <div class="col-md-8 col-lg-9">
                                    <textarea class="form-control" id="description" name="description" placeholder="Mô tả ..." rows="3" required oninvalid="this.setCustomValidity('Vui lòng nhập mô tả!!!')" oninput="setCustomValidity('')"></textarea>
                                    <i class=" bi bi-mic-fill mic" id="click_to_record"></i>
                                    <div id="listening_indicator"></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Ảnh</label>
                                <div class="col-md-8 col-lg-9">
                                    <div id="galeria">
                                    </div>
                                    <div class="mb-3 pt-2">
                                        <label for="formFileMultiple" class="form-label"></label>
                                        <input class="form-control" type="file" hidden id="fileToUploadmul" required name="fileToUpload[]" onchange="
                                        previewMultiple(event)" multiple>
                                        <input type="button" onClick="getFile.simulate()" value="Chọn tệp ảnh" id="getFile1" />
                                        <label id="selected">Không tệp nào được chọn</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="soluongdocho" class="col-md-4 col-lg-3 col-form-label">Số lượng</label>
                                <div class="col-md-8 col-lg-9">
                                    <input class="form-control" type="number" name="soluong" id="soluong" min=1 required placeholder="Nhập số lượng đồ cho" oninvalid="this.setCustomValidity('Vui lòng nhập số lượng đồ cho!!!')" oninput="setCustomValidity('')">
                                </div>
                            </div>
                            <input type="hidden" name="id" value="<?= $result['user']['idUser'] ?> " class=" form-control">

                            <div class="row mb-3">
                                <label for="type" class="col-md-4 col-lg-3 col-form-label">Loại đồ cho</label>
                                <div class="col-md-8 col-lg-9">
                                    <select class="form-select" name="type">
                                        <?php
                                        $token = $_SESSION['token'];
                                        $url = 'http://localhost:8000/website_openshare/controllers/users/type/getType.php';

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
                                            $data3 = $data['data'];
                                        }

                                        // Đóng cURL session
                                        curl_close($curl);
                                        ?>
                                        <?php for ($i = 0; $i < count($data3); $i++) { ?>
                                            <option value="<?= $data3[$i]['idType'] ?>" selected><?= $data3[$i]['nameType'] ?></option>
                                        <?php } ?>

                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="Address" class="col-md-4 col-lg-3 col-form-label">Địa chỉ</label>
                                <div class="col-md-8 col-lg-9">
                                    <select class="form-select" name="address">
                                        <option value="" selected>Chọn địa chỉ</option>
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
                                            $data4 = $data ? $data['data'] : null;
                                        }

                                        // Đóng cURL session
                                        curl_close($curl);
                                        ?>
                                        <?php
                                        if ($data4 == null) {
                                        } else {
                                            for ($i = 0; $i < count($data4); $i++) { ?>

                                                <option value="<?= $data4[$i]['address'] ?>"><?= $data4[$i]['address'] ?></option>
                                        <?php }
                                        } ?>

                                    </select>
                                    <p class="mt-3">
                                        <button class="btn btn-primary p-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                            Thêm địa chỉ
                                        </button>
                                        <!-- <span class="text-warning">(*Thêm địa chỉ khác, ngoài địa chỉ của bạn)</span> -->
                                        <i class="bi bi-info-circle note text-warning" data-bs-toggle="collapse" data-bs-target="#collapseExample1" aria-expanded="false" aria-controls="collapseExample1"></i>
                                    <div class="collapse" id="collapseExample1">
                                        <div class="card card-body">
                                            Lựa chọn này nhằm mục đích để người cho chưa cập nhật địa chỉ có thể cho đồ hoặc có thể cho giúp người khác cho đồ khi họ không sử dụng App.
                                        </div>
                                    </div>
                                    </p>
                                </div>

                                <div class="collapse" id="collapseExample">

                                    <div class="container" style="margin-bottom: 20px;">

                                        <div class="row">
                                            <div class="col-md-3"><select name="" id="province_post" class="form-select"></select></div>
                                            <div class="col-md-3"> <select name="" id="district_post" class=" form-select">
                                                    <option value="">chọn quận</option>
                                                </select></div>
                                            <div class="col-md-3">
                                                <select name="" id="ward_post" class="form-select">
                                                    <option value="">chọn phường</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" placeholder="Nhập địa chỉ" class="input-group p-1" id="street_post">

                                            </div>
                                            <input type="hidden" name="result_post" id="result_post" value="" />
                                        </div>

                                    </div>

                                </div>
                                <div class="row mb-3">
                                    <label for="capcha" class="col-md-4 col-lg-3 col-form-label">Capcha</label>
                                    <div class="col-md-8 col-lg-9 input_field captch_box">
                                        <input type="text" value="" disabled />
                                        <button class="refresh_button">
                                            <i class="bi bi-arrow-repeat repeat"></i>
                                        </button>
                                    </div>

                                </div>
                                <div class="row mb-3">
                                    <label for="" class="col-md-4 col-lg-3"></label>
                                    <div class="col-md-8 col-lg-9 input_field captch_input">
                                        <input type="text" placeholder="Nhập capcha" required oninvalid="this.setCustomValidity('Vui lòng nhập capcha!!!')" oninput="setCustomValidity('')" />
                                    </div>
                                    <div class="message"></div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="submit" name="post" id="post_sub" class="btn btn-primary">Lưu thay đổi</button>

                            </div>
                    </form>


                </div>

            </div>
        </div>
    </div>
    <script>
        function previewMultiple(event) {
            var saida = document.getElementById("fileToUploadmul");
            var quantos = saida.files.length;
            var galeria = document.getElementById("galeria");
            for (var i = 0; i < quantos; i++) {
                var urls = URL.createObjectURL(event.target.files[i]);
                var img = document.createElement("img");
                img.src = urls;
                img.width = "85";
                img.height = "85";
                img.style.borderRadius = "10px";
                img.style.boxShadow = "0 0 8px rgba(0, 0, 0, 0.2)";
                img.style.opacity = "85%";
                galeria.appendChild(img);
            }
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js" integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../assests/handle_address_post.js"></script>
    <script src="../assests/handle_choosefile.js"></script>
    <script src="../assests/handle_capcha.js"></script>

    <script>
        document.querySelector('#form_post #post_sub').addEventListener('click', function() {
            // Lấy giá trị của trường "select"
            var selectValue = document.querySelector('#form_post select[name="address"]').value;
            var addressAdd = document.getElementById('result_post').value;
            // Kiểm tra nếu giá trị bằng chuỗi rỗng
            if (selectValue === '' && addressAdd === '') {
                // Hiển thị trường nhập địa chỉ thêm
                document.querySelector('#form_post #collapseExample').classList.add('show');

                // Ngăn không cho form được gửi
                event.preventDefault();
            }
        });

        document.getElementById("click_to_record").addEventListener("click", function() {
            var old_text = document.getElementById("description").value;
            var speech = true;
            window.SpeechRecognition = window.webkitSpeechRecognition;
            var listeningIndicator = document.getElementById("listening_indicator");

            const recognition = new SpeechRecognition();
            recognition.interimResults = true;
            recognition.lang = "vi-VN";
            recognition.addEventListener("start", () => {
                listeningIndicator.style.backgroundColor = "green";
                listeningIndicator.textContent = "Đang lắng nghe...";
            });

            recognition.addEventListener("end", () => {
                listeningIndicator.style.backgroundColor = "red";
                listeningIndicator.textContent = "";
            });
            recognition.addEventListener("result", (e) => {
                const transcript = Array.from(e.results)
                    .map((result) => result[0])
                    .map((result) => result.transcript)
                    .join("");

                document.getElementById("description").value = old_text + ' ' + transcript;
                console.log(transcript);
            });

            if (speech == true) {
                recognition.start();
            }
        });
    </script>
    <style>
        #description {
            position: relative;
        }

        .mic {
            position: absolute !important;
            top: 120px;
            right: 30px !important;
        }

        .note {
            position: relative !important;
            top: 5px;
            left: 10px !important;
        }

        #listening_indicator {
            width: 150px;
        }
    </style>
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
    <style>
        .input_field {
            position: relative;
            width: 50%;
        }

        .refresh_button {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            background: #826afb;
            height: 30px;
            width: 30px;
            border: none;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
            margin-right: 5px;
        }

        .repeat {
            position: static !important;
        }

        .refresh_button:active {
            transform: translateY(-50%) scale(0.98);
        }

        .input_field input,
        .button button {
            height: 100%;
            width: 100%;
            outline: none;
            border: none;
            border-radius: 8px;
        }

        .input_field input {
            padding: 0 15px;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .captch_box input {
            color: #6b6b6b;
            font-size: 22px;
            pointer-events: none;
        }

        .captch_input input {
            padding: 10px 15px;
        }

        .captch_input input:focus {
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.08);
        }
    </style>