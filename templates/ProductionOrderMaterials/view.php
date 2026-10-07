<div class="production_order_materials view">
    <h3>Chi tiết ProductionOrderMaterials: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>mã lệnh sản xuất</th><td><?= h($record->production_order_id ?? '') ?></td></tr>
        <tr><th>mã sản phẩm</th><td><?= h($record->product_id ?? '') ?></td></tr>
        <tr><th>số lượng yêu cầu</th><td><?= h($record->quantity_required ?? '') ?></td></tr>
        <tr><th>số lượng đã sử dụng</th><td><?= h($record->quantity_used ?? '') ?></td></tr>
        <tr><th>đơn giá</th><td><?= h($record->unit_price ?? '') ?></td></tr>
        <tr><th>tổng chi phí</th><td><?= h($record->total_cost ?? '') ?></td></tr>
        <tr><th>warehouse_id</th><td><?= h($record->warehouse_id ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
