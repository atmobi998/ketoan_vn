<?php
namespace App\Service;
use Dompdf\Dompdf;

class PdfExportService
{
    public function export(string $tableName, array $records): string
    {
        $html = '<html>
    <head><meta charset="utf-8">
        <style>
            body {font-family: "DejaVu Sans", sans-serif;font-size: 14px;}
            h2 {font-family: "DejaVu Sans", sans-serif;font-weight: bold;font-size: 16px;}
        </style>
    </head>
    <body><h2 style="text-align:center">BÁO CÁO - ' . strtoupper($tableName) . '</h2>';
        $html .= '<p>Ngay xuat: ' . date('d/m/Y H:i:s') . '</p>';
        $html .= '<table border="1" cellpadding="5" cellspacing="0" style="width:100%; border-collapse:collapse; font-size:12px;">';
        if (empty($records)) {
            $html .= '<tr><td>Khong co du lieu</td></tr>';
        } else {
            $first = $records[0];
            if (is_object($first)) $first = $first->toArray();
            $headers = array_keys($first);
            $html .= '<tr>'; foreach ($headers as $h) $html .= '<th>' . htmlspecialchars($h) . '</th>'; $html .= '</tr>';
            foreach ($records as $rec) {
                if (is_object($rec)) $rec = $rec->toArray();
                $html .= '<tr>';
                foreach ($headers as $h) {
                    $val = $rec[$h] ?? '';
                    if ($val instanceof \DateTimeInterface) $val = $val->format('Y-m-d');
                    $html .= '<td>' . htmlspecialchars((string)$val) . '</td>';
                }
                $html .= '</tr>';
            }
        }
        $html .= '</table></body></html>';
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $tmpDir = sys_get_temp_dir();
        $file = $tmpDir . DIRECTORY_SEPARATOR . $tableName . '_' . date('Ymd_His') . '.pdf';
        file_put_contents($file, $dompdf->output());
        return $file;
    }

    public function exportFinancial(array $records, string $tableName): string
    {
        $html = '<html>
    <head><meta charset="utf-8">
        <style>
            body {font-family: "DejaVu Sans", sans-serif;font-size: 14px;}
            h2 {font-family: "DejaVu Sans", sans-serif;font-weight: bold;font-size: 16px;}
        </style>
    </head>
    <body><h2 style="text-align:center">BÁO CÁO TÀI CHÍNH - ' . strtoupper($tableName) . '</h2>';
        $html .= '<p>Ngay xuat: ' . date('d/m/Y H:i:s') . '</p>';
        $html .= '<table border="1" cellpadding="5" cellspacing="0" style="width:100%; border-collapse:collapse; font-size:12px;">';
        if (empty($records)) {
            $html .= '<tr><td>Khong co du lieu</td></tr>';
        } else {
            $first = $records[0];
            if (is_object($first)) $first = $first->toArray();
            $headers = array_keys($first);
            $html .= '<tr>'; foreach ($headers as $h) $html .= '<th>' . htmlspecialchars($h) . '</th>'; $html .= '</tr>';
            foreach ($records as $rec) {
                if (is_object($rec)) $rec = $rec->toArray();
                $html .= '<tr>';
                foreach ($headers as $h) {
                    $val = $rec[$h] ?? '';
                    if ($val instanceof \DateTimeInterface) $val = $val->format('Y-m-d');
                    $html .= '<td>' . htmlspecialchars((string)$val) . '</td>';
                }
                $html .= '</tr>';
            }
        }
        $html .= '</table></body></html>';
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $tmpDir = sys_get_temp_dir();
        $file = $tmpDir . DIRECTORY_SEPARATOR . $tableName . '_' . date('Ymd_His') . '.pdf';
        file_put_contents($file, $dompdf->output());
        return $file;
    }

}
