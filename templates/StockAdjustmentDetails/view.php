<div class="stock_adjustment_details view">
    <h3>Chi tiết StockAdjustmentDetails: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>stock_adjustment_id</th><td><?= h($record->stock_adjustment_id ?? '') ?></td></tr>
        <tr><th>mã sản phẩm</th><td><?= h($record->product_id ?? '') ?></td></tr>
        <tr><th>quantity_system</th><td><?= h($record->quantity_system ?? '') ?></td></tr>
        <tr><th>quantity_actual</th><td><?= h($record->quantity_actual ?? '') ?></td></tr>
        <tr><th>quantity_diff</th><td><?= h($record->quantity_diff ?? '') ?></td></tr>
        <tr><th>đơn giá</th><td><?= h($record->unit_price ?? '') ?></td></tr>
        <tr><th>số lượng</th><td><?= h($record->amount ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
