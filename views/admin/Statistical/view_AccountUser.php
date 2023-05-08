<?php include('../Layout/view_header.php') ?>
<?php include('../Layout/view_sidebar.php') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php

$token = $_SESSION['token'];
$url = 'http://localhost:8000/website_openshare/controllers/admin/Statistical/AccountUser.php';

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
// var_dump($data1);

// Đóng cURL session
curl_close($curl);
?>
<div id="main" class="main d-flex justify-content-center align-items-center">
    <div class="col-lg-9 ">
        <div class="card">
            <div class="card-body">
                <div>
                    <i class="bi bi-list toggle" style="cursor:pointer"></i>
                    <div class="menu-child">
                        <ul class="child">
                            <li><a href="" id="download-chart-png"><i class="bi bi-filetype-png"></i> Tải xuổng PNG</a></li>
                            <li><a href="" id="download-chart-jpg"><i class="bi bi-filetype-jpg"></i> Tải xuông JPG</a></li>
                            <!-- <li><a href="./view_xuatExcel_AccountUser.php">Xuất excel</a></li> -->

                        </ul>
                    </div>
                </div>
                <h5 class="card-title text-center">Biểu đồ cột biễu diễn số lượng người dùng đăng ký mỗi tháng</h5>

                <!-- Bar Chart -->
                <div>
                    <label for="year" style="color:#012970; font-size:20px">Chọn một năm :</label>
                    <select class="form-select" id="year" onchange="updateChart()">
                        <?php
                        $unique_years = array();
                        foreach ($data1 as $row) {
                            $year = $row['year'];
                            if (!in_array($year, $unique_years)) {
                                array_push($unique_years, $year);
                            }
                        }
                        foreach ($unique_years as $year) { ?>
                            <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <!-- <a href="" id="download-chart" download="monthly_user_signups.png">Download Chart</a> -->
                <canvas id="myChart"></canvas>
                <script>
                    var data = <?php echo json_encode($data1); ?>;

                    var year = '2022';

                    function filterDataByYear() {
                        return data.filter(d => d.year === year);
                    }

                    function getDataForChart() {
                        var filteredData = filterDataByYear();
                        var counts = filteredData.map(d => d.count);
                        var months = filteredData.map(d => d.month);
                        return {
                            counts: counts,
                            months: months
                        };
                    }

                    function updateChart() {
                        year = document.getElementById('year').value;
                        var dataForChart = getDataForChart();
                        myChart.data.labels = dataForChart.months;
                        myChart.data.datasets[0].data = dataForChart.counts;
                        myChart.update();
                    }

                    var dataForChart = getDataForChart();
                    var ctx = document.getElementById('myChart').getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: dataForChart.months,
                            datasets: [{
                                label: 'Số người dùng đã đăng ký',
                                data: dataForChart.counts,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });
                    document.getElementById('download-chart-png').addEventListener('click', function() {
                        var url = myChart.toBase64Image();
                        this.href = url;
                        this.download = 'thongkenguoidung.png';

                    });
                    document.getElementById('download-chart-jpg').addEventListener('click', function() {
                        var canvas = document.getElementById('myChart');
                        canvas.toBlob(function(blob) {
                            var url = URL.createObjectURL(blob);
                            var link = document.createElement('a');
                            link.download = 'Thongkenguoidung.jpg';
                            link.href = url;
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                            URL.revokeObjectURL(url);
                        }, 'image/jpeg', 1);
                    });

                    document.querySelector('.toggle').addEventListener('click', function() {
                        document.querySelector('.menu-child').classList.toggle('active');
                        console.log("123");
                    });
                </script>
                <a href="./view_xuatExcel_AccountUser.php" class="btn btn-primary"><i class="bi bi-file-spreadsheet"></i> Xuất Excel</a>
            </div>
        </div>
    </div>
</div>
<?php include('../Layout/view_footer.php') ?>

<style>
    .menu-child {
        background-color: rgba(0, 0, 0, 0);
        width: 200px;
        padding: 3px;
        box-sizing: border-box;
        border-radius: 1px;
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.3);
        display: none;
    }

    .menu-child ul li {
        list-style: none;
        cursor: pointer;
    }

    .menu-child ul li:hover {
        background-color: rgba(0, 0, 0, 0.3);
    }

    .menu-child ul li a {
        color: #012970;
    }

    .active {
        display: block;
    }

    .toggle {
        font-size: 25px;
    }
</style>