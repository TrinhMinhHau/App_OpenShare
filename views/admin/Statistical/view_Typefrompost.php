<?php include('../Layout/view_header.php') ?>
<?php include('../Layout/view_sidebar.php') ?>

<?php

$token = $_SESSION['token_admin'];
$url = 'http://localhost:8000/website_openshare/controllers/admin/Statistical/Typefrompost.php';

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
    $data1 = (isset($data['data'])) ? $data['data'] : null;
}
var_dump($data1);
var_dump($data1[0]['nameType']);
$arr_nameType = [];
$arr_count = [];
for ($i = 0; $i < count($data1); $i++) {
    array_push($arr_nameType, $data1[$i]['nameType']);
    array_push($arr_count, $data1[$i]['count']);
}

// Đóng cURL session
curl_close($curl);
?>
<div id="main" class="main d-flex justify-content-center align-items-center">
    <div class="col-lg-9  ">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-center">Biểu đồ cột biểu diễn số lượng đồ cho theo từng loại</h5>

                <!-- Bar Chart -->
                <div id="barChart"></div>

                <script>
                    document.addEventListener("DOMContentLoaded", () => {

                        new ApexCharts(document.querySelector("#barChart"), {
                            series: [{
                                data: <?= json_encode($arr_count) ?>
                            }],
                            chart: {
                                type: 'bar',
                                height: 350
                            },
                            plotOptions: {
                                bar: {
                                    borderRadius: 4,
                                    horizontal: true,
                                }
                            },
                            dataLabels: {
                                enabled: false
                            },
                            xaxis: {
                                categories: <?= json_encode($arr_nameType) ?>,
                            }
                        }).render();
                    });
                </script>
                <a href="./view_xuatExcel_Typefrompost.php" class="btn btn-primary"><i class="bi bi-file-spreadsheet"></i> Xuất Excel</a>

            </div>
        </div>
    </div>
</div>
<?php include('../Layout/view_footer.php') ?>