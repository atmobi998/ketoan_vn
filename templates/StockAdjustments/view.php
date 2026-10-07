<div class="stock_adjustments view">
    <h3>Chi tiết StockAdjustments: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>số hiệu điều chỉnh</th><td><?= h($record->adjustment_number ?? '') ?></td></tr>
        <tr><th>ngày điều chỉnh</th><td><?= h($record->adjustment_date ?? '') ?></td></tr>
        <tr><th>warehouse_id</th><td><?= h($record->warehouse_id ?? '') ?></td></tr>
        <tr><th>loại điều chỉnh</th><td><?= h($record->adjustment_type ?? '') ?></td></tr>
        <tr><th>lý do</th><td><?= h($record->reason ?? '') ?></td></tr>
        <tr><th>tổng số tiền</th><td><?= h($record->total_amount ?? '') ?></td></tr>
        <tr><th>Trạng thái</th><td><?= h($record->status ?? '') ?></td></tr>
        <tr><th>created_by</th><td><?= h($record->created_by ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
