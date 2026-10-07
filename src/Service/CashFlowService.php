<?php
namespace App\Service;

use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenDate;

class CashFlowService
{
    // Mã chỉ tiêu lưu chuyển tiền tệ theo TT200 B03-DN - phương pháp trực tiếp
    const MAP = [
        // I. Hoạt động kinh doanh
        '01' => ['label' => 'Tiền thu từ bán hàng, cung cấp dịch vụ và doanh thu khác', 'type' => 'in', 'accounts' => ['131','511','5111','5112','5113','515','711'], 'activity' => 'operating'],
        '02' => ['label' => 'Tiền chi trả cho người cung cấp hàng hóa, dịch vụ', 'type' => 'out', 'accounts' => ['331','152','153','1561','156','151','1331'], 'activity' => 'operating'],
        '03' => ['label' => 'Tiền chi trả cho người lao động', 'type' => 'out', 'accounts' => ['334','3341','3348'], 'activity' => 'operating'],
        '04' => ['label' => 'Tiền lãi vay đã trả', 'type' => 'out', 'accounts' => ['635'], 'activity' => 'operating'],
        '05' => ['label' => 'Thuế thu nhập doanh nghiệp đã nộp', 'type' => 'out', 'accounts' => ['3334','3335'], 'activity' => 'operating'],
        '06' => ['label' => 'Tiền thu khác từ hoạt động kinh doanh', 'type' => 'in', 'accounts' => ['1388','141','3388','33311','333'], 'activity' => 'operating'],
        '07' => ['label' => 'Tiền chi khác cho hoạt động kinh doanh', 'type' => 'out', 'accounts' => ['641','642','622','627','3383','3384','138','141','133','33311'], 'activity' => 'operating'],
        // II. Hoạt động đầu tư
        '21' => ['label' => 'Tiền chi để mua sắm, xây dựng TSCĐ và các tài sản dài hạn khác', 'type' => 'out', 'accounts' => ['211','212','213','241','2411','2412','2413'], 'activity' => 'investing'],
        '22' => ['label' => 'Tiền thu từ thanh lý, nhượng bán TSCĐ và các tài sản dài hạn khác', 'type' => 'in', 'accounts' => ['211','711'], 'activity' => 'investing', 'keyword' => 'thanh lý'],
        '23' => ['label' => 'Tiền chi cho vay, mua các công cụ nợ của đơn vị khác', 'type' => 'out', 'accounts' => ['128','1281','1282','1288','222','228'], 'activity' => 'investing'],
        '24' => ['label' => 'Tiền thu hồi cho vay, bán lại các công cụ nợ', 'type' => 'in', 'accounts' => ['128'], 'activity' => 'investing'],
        '25' => ['label' => 'Tiền chi đầu tư góp vốn vào đơn vị khác', 'type' => 'out', 'accounts' => ['221','2211','222','228'], 'activity' => 'investing'],
        '26' => ['label' => 'Tiền thu hồi đầu tư góp vốn vào đơn vị khác', 'type' => 'in', 'accounts' => ['221','222'], 'activity' => 'investing'],
        '27' => ['label' => 'Tiền thu lãi cho vay, cổ tức và lợi nhuận được chia', 'type' => 'in', 'accounts' => ['515','5151','5152'], 'activity' => 'investing'],
        // III. Hoạt động tài chính
        '31' => ['label' => 'Tiền thu từ phát hành cổ phiếu, nhận vốn góp của chủ sở hữu', 'type' => 'in', 'accounts' => ['411','4111','4112'], 'activity' => 'financing'],
        '32' => ['label' => 'Tiền trả vốn góp cho các chủ sở hữu, mua lại cổ phiếu', 'type' => 'out', 'accounts' => ['411'], 'activity' => 'financing'],
        '33' => ['label' => 'Tiền thu từ đi vay', 'type' => 'in', 'accounts' => ['341','3411','3412','343','3431'], 'activity' => 'financing'],
        '34' => ['label' => 'Tiền trả nợ gốc vay', 'type' => 'out', 'accounts' => ['341','343'], 'activity' => 'financing'],
        '35' => ['label' => 'Tiền trả nợ gốc thuê tài chính', 'type' => 'out', 'accounts' => ['3412','212'], 'activity' => 'financing'],
        '36' => ['label' => 'Cổ tức, lợi nhuận đã trả cho chủ sở hữu', 'type' => 'out', 'accounts' => ['421','4211','4212','353','3531'], 'activity' => 'financing'],
    ];

    public function getCashFlowReport(string $fromDate, string $toDate): array
    {
        $jelTbl = TableRegistry::getTableLocator()->get('JournalEntryLines');
        $jeTbl = TableRegistry::getTableLocator()->get('JournalEntries');
        $coaTbl = TableRegistry::getTableLocator()->get('ChartOfAccounts');

        // Lấy ID TK 111, 112
        $cashAccounts = $coaTbl->find()->where(['code IN' => ['111','1111','1112','1113','112','1121','1122','1123']])->all();
        $cashAccountIds = collection($cashAccounts)->extract('id')->toList();
        $cashAccountCodes = collection($cashAccounts)->combine('id','code')->toArray();

        // Lấy tất cả bút toán có 111/112 trong kỳ
        $entries = $jeTbl->find()
            ->where([
                'JournalEntries.entry_date >=' => $fromDate,
                'JournalEntries.entry_date <=' => $toDate,
                'JournalEntries.status' => 'posted'
            ])
            ->contain(['JournalEntryLines' => ['ChartOfAccounts']])
            ->orderBy(['JournalEntries.entry_date' => 'ASC'])
            ->toArray();

        $result = [];
        foreach (self::MAP as $code => $cfg) {
            $result[$code] = [
                'code' => $code,
                'label' => $cfg['label'],
                'type' => $cfg['type'],
                'activity' => $cfg['activity'],
                'amount' => 0,
                'details' => []
            ];
        }

        // Phân loại dòng tiền dựa trên bút toán đối ứng với 111/112
        foreach ($entries as $je) {
            $hasCash = false;
            $cashLines = [];
            $otherLines = [];
            foreach ($je->journal_entry_lines as $line) {
                if (in_array($line->chart_of_account_id, $cashAccountIds)) {
                    $hasCash = true;
                    $cashLines[] = $line;
                } else {
                    $otherLines[] = $line;
                }
            }
            if (!$hasCash) continue;

            // Với mỗi dòng đối ứng, tìm mã chỉ tiêu phù hợp
            foreach ($otherLines as $other) {
                $coaCode = $other->chart_of_account->code ?? '';
                $matchedCode = $this->classifyAccount($coaCode, $other, $cashLines);
                if ($matchedCode && isset($result[$matchedCode])) {
                    $amt = $other->debit > 0 ? $other->debit : $other->credit;
                    // Xác định chiều: nếu cash là Nợ (thu tiền) và other là Có => thu, ngược lại chi
                    // Đơn giản: nếu cash debit >0 => thu, nếu cash credit >0 => chi
                    $isCashDebit = false;
                    foreach ($cashLines as $cl) {
                        if ($cl->debit > 0) $isCashDebit = true;
                    }
                    // Đối ứng logic
                    if ($result[$matchedCode]['type'] === 'in' && $isCashDebit) {
                        $result[$matchedCode]['amount'] += $amt;
                        $result[$matchedCode]['details'][] = [
                            'date' => $je->entry_date,
                            'number' => $je->entry_number,
                            'desc' => $je->description,
                            'account' => $coaCode,
                            'amount' => $amt
                        ];
                    } elseif ($result[$matchedCode]['type'] === 'out' && !$isCashDebit) {
                        $result[$matchedCode]['amount'] += $amt;
                        $result[$matchedCode]['details'][] = [
                            'date' => $je->entry_date,
                            'number' => $je->entry_number,
                            'desc' => $je->description,
                            'account' => $coaCode,
                            'amount' => $amt
                        ];
                    }
                }
            }
        }

        // Tổng hợp
        $operatingIn = 0; $operatingOut = 0;
        $investingIn = 0; $investingOut = 0;
        $financingIn = 0; $financingOut = 0;

        foreach ($result as $code => $r) {
            if ($r['activity'] === 'operating') {
                if ($r['type'] === 'in') $operatingIn += $r['amount'];
                else $operatingOut += $r['amount'];
            } elseif ($r['activity'] === 'investing') {
                if ($r['type'] === 'in') $investingIn += $r['amount'];
                else $investingOut += $r['amount'];
            } elseif ($r['activity'] === 'financing') {
                if ($r['type'] === 'in') $financingIn += $r['amount'];
                else $financingOut += $r['amount'];
            }
        }

        $netOperating = $operatingIn - $operatingOut; // 20
        $netInvesting = $investingIn - $investingOut; // 30
        $netFinancing = $financingIn - $financingOut; // 40
        $netCashFlow = $netOperating + $netInvesting + $netFinancing; // 50

        // Tiền đầu kỳ và cuối kỳ từ số dư 111+112
        $beginBalance = $this->getCashBalance($fromDate, true);
        $endBalance = $this->getCashBalance($toDate, false);

        return [
            'from_date' => $fromDate,
            'to_date' => $toDate,
            'lines' => $result,
            'summary' => [
                'operating_in' => $operatingIn,
                'operating_out' => $operatingOut,
                'net_operating' => $netOperating, // 20
                'investing_in' => $investingIn,
                'investing_out' => $investingOut,
                'net_investing' => $netInvesting, // 30
                'financing_in' => $financingIn,
                'financing_out' => $financingOut,
                'net_financing' => $netFinancing, // 40
                'net_cash_flow' => $netCashFlow, // 50
                'begin_balance' => $beginBalance, // 60
                'end_balance' => $endBalance, // 70
                'check' => $beginBalance + $netCashFlow, // phải bằng end_balance nếu không có chênh lệch tỷ giá
            ],
            'cash_account_ids' => $cashAccountIds
        ];
    }

    private function classifyAccount(string $code, $line, array $cashLines): ?string
    {
        // Ưu tiên khớp chính xác mã trong MAP
        foreach (self::MAP as $mapCode => $cfg) {
            if (in_array($code, $cfg['accounts'])) {
                // Kiểm tra chiều thu/chi khớp với cash
                $isCashDebit = false;
                foreach ($cashLines as $cl) { if ($cl->debit > 0) $isCashDebit = true; }
                if (($cfg['type'] === 'in' && $isCashDebit) || ($cfg['type'] === 'out' && !$isCashDebit)) {
                    return $mapCode;
                }
            }
        }
        // Fallback theo đầu số TK
        if (preg_match('/^(131|511|515|711)/', $code)) return '01';
        if (preg_match('/^(331|152|153|156)/', $code)) return '02';
        if (preg_match('/^334/', $code)) return '03';
        if (preg_match('/^635/', $code)) return '04';
        if (preg_match('/^3334|^3335/', $code)) return '05';
        if (preg_match('/^(211|212|213|241)/', $code)) return '21';
        if (preg_match('/^128/', $code)) return '23';
        if (preg_match('/^221|^222|^228/', $code)) return '25';
        if (preg_match('/^515/', $code)) return '27';
        if (preg_match('/^411/', $code)) return '31';
        if (preg_match('/^341|^343/', $code)) {
            // Thu hay trả?
            $isCashDebit = false;
            foreach ($cashLines as $cl) { if ($cl->debit > 0) $isCashDebit = true; }
            return $isCashDebit ? '33' : '34';
        }
        if (preg_match('/^421|^353/', $code)) return '36';
        // Mặc định còn lại cho hoạt động kinh doanh khác
        $isCashDebit = false;
        foreach ($cashLines as $cl) { if ($cl->debit > 0) $isCashDebit = true; }
        return $isCashDebit ? '06' : '07';
    }

    private function getCashBalance(string $date, bool $isBegin): float
    {
        $jelTbl = TableRegistry::getTableLocator()->get('JournalEntryLines');
        $jeTbl = TableRegistry::getTableLocator()->get('JournalEntries');
        $coaTbl = TableRegistry::getTableLocator()->get('ChartOfAccounts');
        $cashIds = $coaTbl->find()->where(['code IN' => ['111','1111','1112','1113','112','1121','1122','1123']])->all()->extract('id')->toList();

        $query = $jelTbl->find()
            ->contain(['JournalEntries'])
            ->where([
                'JournalEntries.entry_date <' . ($isBegin ? '' : '=') => $date,
                'JournalEntries.status' => 'posted',
                'JournalEntryLines.chart_of_account_id IN' => $cashIds
            ]);

        // Tính số dư Nợ - Có
        $lines = $query->toArray();
        $balance = 0;
        foreach ($lines as $l) {
            $balance += $l->debit - $l->credit;
        }
        return $balance;
    }

    public function getCashBalanceDetail(string $fromDate, string $toDate): array
    {
        // Chi tiết thu chi tiền mặt và tiền gửi
        $crTbl = TableRegistry::getTableLocator()->get('CashReceipts');
        $cpTbl = TableRegistry::getTableLocator()->get('CashPayments');
        $brTbl = TableRegistry::getTableLocator()->get('BankReceipts');
        $bpTbl = TableRegistry::getTableLocator()->get('BankPayments');

        $crTotal = $crTbl->find()->where(['voucher_date >=' => $fromDate, 'voucher_date <=' => $toDate, 'status' => 'approved'])->select(['total' => 'SUM(amount_vnd)'])->first();
        $cpTotal = $cpTbl->find()->where(['voucher_date >=' => $fromDate, 'voucher_date <=' => $toDate, 'status' => 'approved'])->select(['total' => 'SUM(amount_vnd)'])->first();
        $brTotal = $brTbl->find()->where(['voucher_date >=' => $fromDate, 'voucher_date <=' => $toDate, 'status' => 'approved'])->select(['total' => 'SUM(amount_vnd)'])->first();
        $bpTotal = $bpTbl->find()->where(['voucher_date >=' => $fromDate, 'voucher_date <=' => $toDate, 'status' => 'approved'])->select(['total' => 'SUM(amount_vnd)'])->first();

        return [
            'cash_in' => $crTotal->total ?? 0,
            'cash_out' => $cpTotal->total ?? 0,
            'bank_in' => $brTotal->total ?? 0,
            'bank_out' => $bpTotal->total ?? 0,
        ];
    }
}
