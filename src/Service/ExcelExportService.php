<?php
namespace App\Service;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ExcelExportService
{
    public function export(string $tableName, array $records): string
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle(substr($tableName, 0, 31));
        if (empty($records)) {
            $sheet->setCellValue('A1', 'Khong co du lieu - ' . $tableName);
        } else {
            $first = $records[0];
            if (is_object($first)) $first = $first->toArray();
            $headers = array_keys($first);
            $col = 1;
            foreach ($headers as $h) { $sheet->setCellValue([$col, 1], $h); $col++; }
            $row = 2;
            foreach ($records as $rec) {
                if (is_object($rec)) $rec = $rec->toArray();
                $col = 1;
                foreach ($headers as $h) {
                    $val = $rec[$h] ?? '';
                    if ($val instanceof \DateTimeInterface) $val = $val->format('Y-m-d H:i:s');
                    $sheet->setCellValue([$col, $row], (string)$val);
                    $col++;
                }
                $row++;
            }
            foreach (range(1, count($headers)) as $c) { $sheet->getColumnDimensionByColumn($c)->setAutoSize(true); }
        }
        $tmpDir = sys_get_temp_dir();
        $file = $tmpDir . DIRECTORY_SEPARATOR . $tableName . '_' . date('Ymd_His') . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($file);
        return $file;
    }
    public function exportFinancial(array $data, string $reportName): string
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle($reportName);
        $sheet->setCellValue('A1', 'BAO CAO TAI CHINH - ' . strtoupper($reportName));
        $sheet->setCellValue('A2', 'Ngay xuat: ' . date('d/m/Y H:i:s'));
        $row = 4;
        foreach ($data as $line) {
            $sheet->setCellValue('A' . $row, $line['code'] ?? '');
            $sheet->setCellValue('B' . $row, $line['name'] ?? '');
            $sheet->setCellValue('C' . $row, $line['debit'] ?? 0);
            $sheet->setCellValue('D' . $row, $line['credit'] ?? 0);
            $sheet->setCellValue('E' . $row, $line['balance'] ?? 0);
            $sheet->getStyle("A$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $row++;
        }
        $tmpDir = sys_get_temp_dir();
        $file = $tmpDir . DIRECTORY_SEPARATOR . $reportName . '_' . date('Ymd_His') . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($file);
        return $file;
    }

    public function exportCashFlow(array $report, array $detail): string
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('LCTT - B03-DN');
        $sheet->setCellValue('A1', 'BÁO CÁO LƯU CHUYỂN TIỀN TỆ - PP TRỰC TIẾP - MẪU B03-DN - TT200');
        $sheet->setCellValue('A2', 'Từ ' . $report['from_date'] . ' đến ' . $report['to_date']);
        $sheet->setCellValue('A3', 'Ngày xuất: ' . date('d/m/Y H:i:s'));
        $sheet->setCellValue('A5', 'Thu tiền mặt (PT)'); $sheet->setCellValue('B5', $detail['cash_in'] ?? 0);
        $sheet->setCellValue('A6', 'Chi tiền mặt (PC)'); $sheet->setCellValue('B6', $detail['cash_out'] ?? 0);
        $sheet->setCellValue('A7', 'Thu tiền NH (BC)'); $sheet->setCellValue('B7', $detail['bank_in'] ?? 0);
        $sheet->setCellValue('A8', 'Chi tiền NH (BN)'); $sheet->setCellValue('B8', $detail['bank_out'] ?? 0);
        $row = 10;
        $sheet->setCellValue('A'.$row, 'Mã số'); $sheet->setCellValue('B'.$row, 'Chỉ tiêu'); $sheet->setCellValue('C'.$row, 'Kỳ này'); $sheet->setCellValue('D'.$row, 'TM');
        $sheet->getStyle('A'.$row.':D'.$row)->getFont()->setBold(true); $row++;
        $labels = [
            '01'=>'Tiền thu từ bán hàng, cung cấp dịch vụ','02'=>'Tiền chi trả cho người cung cấp','03'=>'Tiền chi trả cho người lao động',
            '04'=>'Tiền lãi vay đã trả','05'=>'Thuế TNDN đã nộp','06'=>'Tiền thu khác từ HĐKD','07'=>'Tiền chi khác cho HĐKD','20'=>'Lưu chuyển tiền thuần từ HĐKD',
            '21'=>'Tiền chi mua sắm TSCĐ','22'=>'Tiền thu thanh lý TSCĐ','23'=>'Tiền chi cho vay','24'=>'Tiền thu hồi cho vay',
            '25'=>'Tiền chi đầu tư góp vốn','26'=>'Tiền thu hồi đầu tư','27'=>'Tiền thu lãi, cổ tức','30'=>'Lưu chuyển tiền thuần từ HĐĐT',
            '31'=>'Tiền thu phát hành CP','32'=>'Tiền trả vốn góp','33'=>'Tiền thu từ đi vay','34'=>'Tiền trả nợ vay','35'=>'Tiền trả thuê tài chính','36'=>'Cổ tức đã trả',
            '40'=>'Lưu chuyển tiền thuần từ HĐTC','50'=>'Lưu chuyển tiền thuần trong kỳ (20+30+40)','60'=>'Tiền và tương đương tiền đầu kỳ','61'=>'Chênh lệch tỷ giá','70'=>'Tiền cuối kỳ (50+60+61)'
        ];
        $sections = ['I. HĐKD'=>['01','02','03','04','05','06','07','20'],'II. HĐĐT'=>['21','22','23','24','25','26','27','30'],'III. HĐTC'=>['31','32','33','34','35','36','40'],'TỔNG'=>['50','60','61','70']];
        foreach ($sections as $title=>$codes) {
            $sheet->setCellValue('A'.$row, $title); $sheet->getStyle('A'.$row)->getFont()->setBold(true); $row++;
            foreach ($codes as $code) {
                $amount = 0;
                if (isset($report['lines'][$code])) $amount = $report['lines'][$code]['amount'];
                else { $map=['20'=>'net_operating','30'=>'net_investing','40'=>'net_financing','50'=>'net_cash_flow','60'=>'begin_balance','70'=>'end_balance']; if(isset($map[$code])) $amount=$report['summary'][$map[$code]]??0; }
                $sheet->setCellValue('A'.$row, $code); $sheet->setCellValue('B'.$row, $labels[$code]??$code); $sheet->setCellValue('C'.$row, $amount); $row++;
            }
        }
        foreach (range(1,4) as $c) $sheet->getColumnDimensionByColumn($c)->setAutoSize(true);
        $tmpDir = sys_get_temp_dir(); $file = $tmpDir . DIRECTORY_SEPARATOR . 'LCTT_TT200_' . date('Ymd_His') . '.xlsx';
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet); $writer->save($file); return $file;
    }

}
