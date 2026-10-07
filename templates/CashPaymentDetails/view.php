<div class="cash_payment_details view">
    <h3>Chi tiết CashPaymentDetails: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>mã thanh toán tiền mặt</th><td><?= h($record->cash_payment_id ?? '') ?></td></tr>
        <tr><th>diễn giải</th><td><?= h($record->description ?? '') ?></td></tr>
        <tr><th>Tài khoản KT</th><td><?= h($record->chart_of_account_id ?? '') ?></td></tr>
        <tr><th>số lượng</th><td><?= h($record->amount ?? '') ?></td></tr>
        <tr><th>trung tâm chi phí</th><td><?= h($record->cost_center_id ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
