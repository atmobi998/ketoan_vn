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

    public function exportCashFlow(array $report, array $detail): string
    {
        $html = '<html><head><meta charset="utf-8"><style>body{font-family:"DejaVu Sans",sans-serif;font-size:11px;}h2{font-size:14px;text-align:center;}table{width:100%;border-collapse:collapse;}th,td{border:1px solid #000;padding:4px;}th{background:#eee;}.text-end{text-align:right;}.fw-bold{font-weight:bold;}</style></head><body>';
        $html .= '<h2>BÁO CÁO LƯU CHUYỂN TIỀN TỆ - PP TRỰC TIẾP - B03-DN - TT200</h2>';
        $html .= '<p>Từ '.htmlspecialchars($report['from_date']).' đến '.htmlspecialchars($report['to_date']).' - Ngày xuất: '.date('d/m/Y H:i:s').'</p>';
        $html .= '<p>Thu TM: '.number_format($detail['cash_in']??0).' | Chi TM: '.number_format($detail['cash_out']??0).' | Thu NH: '.number_format($detail['bank_in']??0).' | Chi NH: '.number_format($detail['bank_out']??0).'</p>';
        $html .= '<table><tr><th>Mã số</th><th>Chỉ tiêu</th><th>Kỳ này</th></tr>';
        $labels = ['01'=>'Tiền thu từ bán hàng','02'=>'Tiền chi trả cho người cung cấp','03'=>'Tiền chi trả cho người lao động','04'=>'Tiền lãi vay đã trả','05'=>'Thuế TNDN đã nộp','06'=>'Tiền thu khác từ HĐKD','07'=>'Tiền chi khác cho HĐKD','20'=>'Lưu chuyển tiền thuần từ HĐKD','21'=>'Tiền chi mua sắm TSCĐ','22'=>'Tiền thu thanh lý TSCĐ','23'=>'Tiền chi cho vay','24'=>'Tiền thu hồi cho vay','25'=>'Tiền chi đầu tư góp vốn','26'=>'Tiền thu hồi đầu tư','27'=>'Tiền thu lãi, cổ tức','30'=>'Lưu chuyển tiền thuần từ HĐĐT','31'=>'Tiền thu phát hành CP','32'=>'Tiền trả vốn góp','33'=>'Tiền thu từ đi vay','34'=>'Tiền trả nợ vay','35'=>'Tiền trả thuê tài chính','36'=>'Cổ tức đã trả','40'=>'Lưu chuyển tiền thuần từ HĐTC','50'=>'Lưu chuyển tiền thuần trong kỳ','60'=>'Tiền đầu kỳ','61'=>'Chênh lệch tỷ giá','70'=>'Tiền cuối kỳ'];
        $order = ['01','02','03','04','05','06','07','20','21','22','23','24','25','26','27','30','31','32','33','34','35','36','40','50','60','61','70'];
        foreach ($order as $code) {
            $amount=0; if(isset($report['lines'][$code])) $amount=$report['lines'][$code]['amount']; else { $map=['20'=>'net_operating','30'=>'net_investing','40'=>'net_financing','50'=>'net_cash_flow','60'=>'begin_balance','70'=>'end_balance']; if(isset($map[$code])) $amount=$report['summary'][$map[$code]]??0; }
            $bold = in_array($code,['20','30','40','50','70']) ? ' style="font-weight:bold;background:#e0f7fa;"' : '';
            $html .= '<tr'.$bold.'><td style="text-align:center">'.$code.'</td><td>'.htmlspecialchars($labels[$code]??$code).'</td><td style="text-align:right">'.number_format($amount).'</td></tr>';
        }
        $html .= '</table><p>Đối chiếu: Đầu kỳ ('.number_format($report['summary']['begin_balance']??0).') + Thuần ('.number_format($report['summary']['net_cash_flow']??0).') = '.number_format($report['summary']['check']??0).' | Cuối kỳ: '.number_format($report['summary']['end_balance']??0).'</p></body></html>';
        $dompdf = new \Dompdf\Dompdf(); $dompdf->loadHtml($html,'UTF-8'); $dompdf->setPaper('A4','portrait'); $dompdf->render();
        $tmpDir = sys_get_temp_dir(); $file = $tmpDir . DIRECTORY_SEPARATOR . 'LCTT_TT200_' . date('Ymd_His') . '.pdf'; file_put_contents($file,$dompdf->output()); return $file;
    }

}
