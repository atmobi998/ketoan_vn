<div class="bank_receipts index">
    <h3>BankReceipts <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
    <a href="<?= $this->Url->build(['action' => 'exportExcel']) ?>" class="btn btn-success btn-sm float-end me-2"><i class="fa fa-file-excel"></i> Excel</a>
    <a href="<?= $this->Url->build(['action' => 'exportPdf']) ?>" class="btn btn-danger btn-sm float-end me-2"><i class="fa fa-file-pdf"></i> PDF</a></h3>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <td colspan="12">
<?php
        use Cake\I18n\FrozenDate;
        use Cake\I18n\Number;
        $start = FrozenDate::today();
        $end = FrozenDate::today()->subDays(365);

        echo $this->Form->control('from_period', ['options' => $options ?? [], 'value' => $from_period, 'label' => 'From Period', 'empty' => '-- Chọn --', 'OnChange' => 'from_period_chg();', 'class' => 'form-control']);
        echo $this->Form->control('to_period', ['options' => $options ?? [], 'value' => $to_period, 'label' => 'To Period', 'empty' => '-- Chọn --', 'OnChange' => 'to_period_chg();', 'class' => 'form-control']);
?>
                </td>
            </tr>
            <tr>
                <th>Mã ID</th>
                <th>số phiếu</th>
                <th>ngày chứng từ</th>
                <th>ngày hạch toán</th>
                <th>người nộp tiền</th>
                <th>lý do</th>
                <th>đơn vị tiền tệ</th>
                <th>tỉ giá hối đoái</th>
                <th>số tiền</th>
                <th>số tiền VNĐ</th>
                <th>tài khoản ngân hàng</th>
                <th>Tác vụ</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($records as $r): ?>
            <tr>
                <td><?= h($r->id ?? '') ?></td>
                <td><?= h($r->voucher_number ?? '') ?></td>
                <td><?= h($r->voucher_date ?? '') ?></td>
                <td><?= h($r->accounting_date ?? '') ?></td>
                <td><?= h($r->payer_name ?? '') ?></td>
                <td><?= h($r->reason ?? '') ?></td>
                <td><?= (!empty($r->currency_id))? $r->currency->code:'' ?></td>
                <td><?= h($r->exchange_rate ?? '') ?></td>
                <td><?= Number::format($r->amount ?? '') ?></td>
                <td><?= Number::format($r->amount_vnd ?? '') ?></td>
                <td><?= (!empty($r->bank_account_id))? $r->bank_account->account_number.' ('.$r->bank_account->bank_name.')':'' ?></td>
                <td>
                    <?= $this->Form->postLink('Xóa', ['action' => 'delete', $r->id], ['confirm' => 'Xóa?', 'class' => 'btn btn-sm btn-danger']) ?>
                    <?= $this->Html->link('Sửa', ['action' => 'edit', $r->id], ['class' => 'btn btn-sm btn-warning']) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator"><?= $this->Paginator->numbers() ?></div>
</div>
<script>
function from_period_chg() {
    window.location.href = '/bank-receipts?from_period='+$('#from-period').val()+'&to_period='+$('#to-period').val()+'&time='+$.now();
}
function to_period_chg() {
    window.location.href = '/bank-receipts?from_period='+$('#from-period').val()+'&to_period='+$('#to-period').val()+'&time='+$.now();
}
</script>