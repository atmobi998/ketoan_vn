<div class="customer_payments view">
    <h3>Chi tiết CustomerPayments: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>Mã thanh tóan</th><td><?= h($record->payment_number ?? '') ?></td></tr>
        <tr><th>ngày thanh toán</th><td><?= h($record->payment_date ?? '') ?></td></tr>
        <tr><th>customer_id</th><td><?= h($record->customer_id ?? '') ?></td></tr>
        <tr><th>thành tiền</th><td><?= h($record->amount ?? '') ?></td></tr>
        <tr><th>bank_account_id</th><td><?= h($record->bank_account_id ?? '') ?></td></tr>
        <tr><th>phương thức thanh toán</th><td><?= h($record->payment_method ?? '') ?></td></tr>
        <tr><th>reference</th><td><?= h($record->reference ?? '') ?></td></tr>
        <tr><th>notes</th><td><?= h($record->notes ?? '') ?></td></tr>
        <tr><th>created_by</th><td><?= h($record->created_by ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
