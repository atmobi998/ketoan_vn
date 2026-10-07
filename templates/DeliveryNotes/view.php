<div class="delivery_notes view">
    <h3>Chi tiết DeliveryNotes: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>Số phiếu giao hàng</th><td><?= h($record->dn_number ?? '') ?></td></tr>
        <tr><th>delivery_date</th><td><?= h($record->delivery_date ?? '') ?></td></tr>
        <tr><th>sales_order_id</th><td><?= h($record->sales_order_id ?? '') ?></td></tr>
        <tr><th>customer_id</th><td><?= h($record->customer_id ?? '') ?></td></tr>
        <tr><th>warehouse_id</th><td><?= h($record->warehouse_id ?? '') ?></td></tr>
        <tr><th>tổng số tiền</th><td><?= h($record->total_amount ?? '') ?></td></tr>
        <tr><th>trạng thái</th><td><?= h($record->status ?? '') ?></td></tr>
        <tr><th>notes</th><td><?= h($record->notes ?? '') ?></td></tr>
        <tr><th>created_by</th><td><?= h($record->created_by ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
