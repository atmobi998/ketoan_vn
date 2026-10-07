<div class="bank_transactions view">
    <h3>Chi tiết BankTransactions: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>ngày giao dịch</th><td><?= h($record->transaction_date ?? '') ?></td></tr>
        <tr><th>bank_account_id</th><td><?= h($record->bank_account_id ?? '') ?></td></tr>
        <tr><th>kiểu</th><td><?= h($record->type ?? '') ?></td></tr>
        <tr><th>số tiền</th><td><?= h($record->amount ?? '') ?></td></tr>
        <tr><th>diễn giải</th><td><?= h($record->description ?? '') ?></td></tr>
        <tr><th>loại tham chiếu</th><td><?= h($record->reference_type ?? '') ?></td></tr>
        <tr><th>reference_id</th><td><?= h($record->reference_id ?? '') ?></td></tr>
        <tr><th>balance_after</th><td><?= h($record->balance_after ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
