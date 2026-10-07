<div class="bank_payments view">
    <h3>Chi tiết BankPayments: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>số phiếu</th><td><?= h($record->voucher_number ?? '') ?></td></tr>
        <tr><th>ngày chứng từ</th><td><?= h($record->voucher_date ?? '') ?></td></tr>
        <tr><th>ngày hạch toán</th><td><?= h($record->accounting_date ?? '') ?></td></tr>
        <tr><th>tên người thụ hưởng</th><td><?= h($record->payee_name ?? '') ?></td></tr>
        <tr><th>lý do</th><td><?= h($record->reason ?? '') ?></td></tr>
        <tr><th>bank_account_id</th><td><?= h($record->bank_account_id ?? '') ?></td></tr>
        <tr><th>Tài khoản KT</th><td><?= h($record->chart_of_account_id ?? '') ?></td></tr>
        <tr><th>currency_id</th><td><?= h($record->currency_id ?? '') ?></td></tr>
        <tr><th>thành tiền</th><td><?= h($record->amount ?? '') ?></td></tr>
        <tr><th>tỷ giá hối đoái</th><td><?= h($record->exchange_rate ?? '') ?></td></tr>
        <tr><th>amount_vnd</th><td><?= h($record->amount_vnd ?? '') ?></td></tr>
        <tr><th>trạng thái</th><td><?= h($record->status ?? '') ?></td></tr>
        <tr><th>created_by</th><td><?= h($record->created_by ?? '') ?></td></tr>
        <tr><th>accounting_period_id</th><td><?= h($record->accounting_period_id ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
