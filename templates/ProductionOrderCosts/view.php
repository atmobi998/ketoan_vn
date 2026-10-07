<div class="production_order_costs view">
    <h3>Chi tiết ProductionOrderCosts: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>mã lệnh sản xuất</th><td><?= h($record->production_order_id ?? '') ?></td></tr>
        <tr><th>cost_type</th><td><?= h($record->cost_type ?? '') ?></td></tr>
        <tr><th>số tiền</th><td><?= h($record->amount ?? '') ?></td></tr>
        <tr><th>diễn giải</th><td><?= h($record->description ?? '') ?></td></tr>
        <tr><th>trung tâm chi phí</th><td><?= h($record->cost_center_id ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
