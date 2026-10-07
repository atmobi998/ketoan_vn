<div class="stock_transfers view">
    <h3>Chi tiết StockTransfers: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>Mã số chuyển</th><td><?= h($record->transfer_number ?? '') ?></td></tr>
        <tr><th>từ kho</th><td><?= h($related['FromWarehouses'][$record->from_warehouse_id] ?? '') ?></td></tr>
        <tr><th>đến kho</th><td><?= h($related['ToWarehouses'][$record->to_warehouse_id] ?? '') ?></td></tr>
        <tr><th>ngày chuyển</th><td><?= h($record->transfer_date ?? '') ?></td></tr>
        <tr><th>trạng thái</th><td><?= h($record->status ?? '') ?></td></tr>
        <tr><th>notes</th><td><?= h($record->notes ?? '') ?></td></tr>
        <tr><th>created_by</th><td><?= h($record->created_by ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
