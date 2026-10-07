<div class="production_orders view">
    <h3>Chi tiết ProductionOrders: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>Số đơn đặt hàng</th><td><?= h($record->po_number ?? '') ?></td></tr>
        <tr><th>bom_id</th><td><?= h($record->bom_id ?? '') ?></td></tr>
        <tr><th>mã sản phẩm</th><td><?= h($record->product_id ?? '') ?></td></tr>
        <tr><th>số lượng theo kế hoạch</th><td><?= h($record->quantity_planned ?? '') ?></td></tr>
        <tr><th>số lượng sản xuất</th><td><?= h($record->quantity_produced ?? '') ?></td></tr>
        <tr><th>Ngày BĐ</th><td><?= h($record->start_date ?? '') ?></td></tr>
        <tr><th>Ngày KT</th><td><?= h($record->end_date ?? '') ?></td></tr>
        <tr><th>trạng thái</th><td><?= h($record->status ?? '') ?></td></tr>
        <tr><th>trung tâm chi phí</th><td><?= h($record->cost_center_id ?? '') ?></td></tr>
        <tr><th>created_by</th><td><?= h($record->created_by ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
