<?php
namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use App\Service\GlPostingService;

class PayrollPayBankCommand extends Command
{
    protected function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser->setDescription('Tạo UNC thanh toán lương qua ngân hàng: Nợ 334 / Có 1121');
        $parser->addOption('month', [
            'short' => 'm',
            'default' => null,
            'help' => 'Tháng (1-12). VD: --month=9 . Nếu bỏ trống sẽ lấy tháng hiện tại'
        ]);
        $parser->addOption('year', [
            'short' => 'y',
            'default' => null,
            'help' => 'Năm. VD: --year=2026 . Nếu bỏ trống sẽ lấy năm hiện tại'
        ]);
        $parser->addOption('payroll_id', [
            'default' => null,
            'help' => 'Chi lương cho 1 bảng lương cụ thể theo ID. VD: --payroll_id=5 . Nếu có month/year sẽ ưu tiên payroll_id'
        ]);
        $parser->addOption('bank_account_id', [
            'short' => 'b',
            'default' => null,
            'help' => 'ID tài khoản ngân hàng (bank_accounts.id). Nếu bỏ trống lấy TK mặc định'
        ]);
        $parser->addOption('group', [
            'default' => '1',
            'choices' => ['0', '1'],
            'help' => '1 = mỗi phòng ban 1 UNC (mặc định), 0 = gộp cả tháng 1 UNC duy nhất'
        ]);
        $parser->addOption('force', [
            'boolean' => true,
            'help' => 'Force tạo lại UNC dù đã có'
        ]);
        return $parser;
    }

    public function execute(Arguments $args, ConsoleIo $io)
    {
        $service = new GlPostingService();
        $month = $args->getOption('month');
        $year = $args->getOption('year');
        $payrollId = $args->getOption('payroll_id');
        $bankAccountId = $args->getOption('bank_account_id');
        $group = $args->getOption('group') !== '0';
        $force = $args->getOption('force') ?? false;

        // Nếu có payroll_id -> chi 1 bảng
        if ($payrollId) {
            $io->out("=== Chi lương qua NH cho Payroll ID #$payrollId ===");
            $io->out("Bank Account: " . ($bankAccountId ?: 'auto (mặc định)') . " | Force: " . ($force ? 'YES' : 'NO'));
            
            $res = $service->createPayrollBankPayment((int)$payrollId, $bankAccountId ? (int)$bankAccountId : null, $force);
            
            if ($res['status'] === 'ok') {
                $io->success(sprintf("OK: %s - UNC %s - Bút toán %s - %.0f VND",
                    $res['message'],
                    $res['voucher_number'],
                    $res['entry_number'],
                    $res['amount']
                ));
                return static::CODE_SUCCESS;
            } elseif ($res['status'] === 'skipped') {
                $io->warning("SKIPPED: " . $res['message']);
                return static::CODE_SUCCESS;
            } else {
                $io->error("ERROR: " . $res['message']);
                return static::CODE_ERROR;
            }
        }

        // Nếu có month/year -> chi cả tháng
        if (!$month) $month = (int)date('n');
        if (!$year) $year = (int)date('Y');

        $month = (int)$month;
        $year = (int)$year;

        $io->out("=== Chi lương qua NH tháng $month/$year ===");
        $io->out("Bank Account: " . ($bankAccountId ?: 'auto') . " | Group by Dept: " . ($group ? 'YES (mỗi PB 1 UNC)' : 'NO (gộp 1 UNC)') . " | Force: " . ($force ? 'YES' : 'NO'));

        // Kiểm tra bảng lương tồn tại
        $payrollTbl = $this->fetchTable('Payrolls');
        $count = $payrollTbl->find()->where(['payroll_month' => $month, 'payroll_year' => $year, 'status IN' => ['approved','paid']])->count();
        if ($count === 0) {
            $io->error("Không có bảng lương nào T$month/$year ở trạng thái approved/paid");
            return static::CODE_ERROR;
        }

        $res = $service->createPayrollMonthBankPayment($month, $year, $bankAccountId ? (int)$bankAccountId : null, $group, $force);

        if ($res['status'] === 'ok') {
            $io->success($res['message']);
            $io->out("Tổng thực chi: " . number_format($res['total_amount']) . " VND");
            $io->out("\nChi tiết:");
            foreach ($res['details'] as $d) {
                $r = $d['result'];
                $status = $r['status'] ?? 'unknown';
                $msg = $r['message'] ?? ($r['voucher_number'] ?? '') . ' - ' . ($r['entry_number'] ?? '');
                $io->out(sprintf("  - Payroll %s (%s): %s - %s", $d['payroll_id'], $d['code'], $status, $msg));
            }
            return static::CODE_SUCCESS;
        } else {
            $io->error($res['message']);
            return static::CODE_ERROR;
        }
    }
}
