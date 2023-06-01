
<?php

require_once '../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

session_start();
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

// Đóng cURL session
curl_close($curl);

// Tạo một đối tượng Spreadsheet mới
$spreadsheet = new Spreadsheet();

// Lấy trang tính đầu tiên trong file Excel
$sheet = $spreadsheet->getActiveSheet();
$sheet->insertNewRowBefore(2);
$sheet->setCellValue('A1', 'Thống kê số lượng bài cho theo từng loại');
$sheet->mergeCells('A1:B1');
$sheet->getStyle('A1:B1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A1:B1')->getFont()->setBold(true);
// Thiết lập tên các cột trong file Excel
$sheet->setCellValue('A2', 'Loại đồ dùng');
$sheet->setCellValue('B2', 'Số lượng bài cho');
// Thiết lập độ rộng cho các cột
$sheet->getColumnDimension('A')->setWidth(20); // Width of column A is set to 15
$sheet->getColumnDimension('B')->setWidth(20); // Width of column B is set to 20
// Lấy dữ liệu từ API và ghi vào file Excel
$row = 2;
if ($data1 != null) {
    foreach ($data1 as $data) {
        $sheet->setCellValue('A' . $row, $data['nameType']);
        $sheet->setCellValue('B' . $row, $data['count']);
        $row++;
    }

    // Khởi tạo một đối tượng Writer để ghi file Excel
    $writer = new Xlsx($spreadsheet);

    // Thiết lập header để tải file Excel xuống
    ob_end_clean();
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="thongkesobaichotheoloai.xlsx"');
    header('Cache-Control: max-age=0');

    // Thiết lập border cho toàn bộ bảng
    $styleArray = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['rgb' => '000000'],
            ],
        ],
    ];
    $sheet->getStyle('A1:B' . ($row - 1))->applyFromArray($styleArray);

    // Thiết lập màu nền cho tiêu đề
    $sheet->getStyle('A1:B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('FFA500');

    // Ghi file Excel ra output
    $writer->save('php://output');
}
