<div class="inventories view">
    <h3>Chi tiết Inventories: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>mã sản phẩm</th><td><?= h($record->product_id ?? '') ?></td></tr>
        <tr><th>warehouse_id</th><td><?= h($record->warehouse_id ?? '') ?></td></tr>
        <tr><th>thành tiền</th><td><?= h($record->quantity ?? '') ?></td></tr>
        <tr><th>Số lượng hiện có</th><td><?= h($record->quantity_available ?? '') ?></td></tr>
        <tr><th>số lượng đặt trước</th><td><?= h($record->quantity_reserved ?? '') ?></td></tr>
        <tr><th>giá nhập gần nhất</th><td><?= h($record->last_import_price ?? '') ?></td></tr>
        <tr><th>average_price</th><td><?= h($record->average_price ?? '') ?></td></tr>
        <tr><th>last_updated</th><td><?= h($record->last_updated ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
