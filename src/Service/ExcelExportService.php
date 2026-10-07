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
}
