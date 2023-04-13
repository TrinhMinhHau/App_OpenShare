
<?php

require_once '../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

session_start();
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

// Đóng cURL session
curl_close($curl);

// Tạo một đối tượng Spreadsheet mới
$spreadsheet = new Spreadsheet();

// Lấy trang tính đầu tiên trong file Excel
$sheet = $spreadsheet->getActiveSheet();
$sheet->insertNewRowBefore(2);
$sheet->setCellValue('A1', 'Thống kê người dùng đã đăng ký');
$sheet->mergeCells('A1:C1');
$sheet->getStyle('A1:C1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A1:C1')->getFont()->setBold(true);
// Thiết lập tên các cột trong file Excel
$sheet->setCellValue('A2', 'Năm');
$sheet->setCellValue('B2', 'Tháng');
$sheet->setCellValue('C2', 'Số người dùng đăng ký');
// Thiết lập độ rộng cho các cột
$sheet->getColumnDimension('A')->setWidth(15); // Width of column A is set to 15
$sheet->getColumnDimension('B')->setWidth(15); // Width of column B is set to 20
$sheet->getColumnDimension('C')->setWidth(25); // Width of column C is set to 25

// Lấy dữ liệu từ API và ghi vào file Excel
$row = 3;
if ($data1 != null) {
    foreach ($data1 as $data) {
        $sheet->setCellValue('A' . $row, $data['year']);
        $sheet->setCellValue('B' . $row, $data['month']);
        $sheet->setCellValue('C' . $row, $data['count']);
        $row++;
    }
    $sheet->getStyle('A1:C' . ($row - 1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    // Khởi tạo một đối tượng Writer để ghi file Excel
    $writer = new Xlsx($spreadsheet);

    // Thiết lập header để tải file Excel xuống
    ob_end_clean();
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="thongkenguoidung.xlsx"');
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
    $sheet->getStyle('A1:C' . ($row - 1))->applyFromArray($styleArray);

    // Thiết lập màu nền cho tiêu đề
    $sheet->getStyle('A1:C1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('FFA500');
    $sheet->getStyle('A2:C2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('0080FF');
    $sheet->getStyle('A2:C2')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

    // Ghi file Excel ra output
    $writer->save('php://output');
}
