<div class="cost_calculations view">
    <h3>Chi tiết CostCalculations: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>mã tính toán</th><td><?= h($record->calculation_code ?? '') ?></td></tr>
        <tr><th>mã lệnh sản xuất</th><td><?= h($record->production_order_id ?? '') ?></td></tr>
        <tr><th>chi phí vật liệu</th><td><?= h($record->material_cost ?? '') ?></td></tr>
        <tr><th>chi phí nhân công</th><td><?= h($record->labor_cost ?? '') ?></td></tr>
        <tr><th>chi phí chung</th><td><?= h($record->overhead_cost ?? '') ?></td></tr>
        <tr><th>tổng chi phí</th><td><?= h($record->total_cost ?? '') ?></td></tr>
        <tr><th>chi phí mỗi đơn vị</th><td><?= h($record->unit_cost ?? '') ?></td></tr>
        <tr><th>calculation_date</th><td><?= h($record->calculation_date ?? '') ?></td></tr>
        <tr><th>trạng thái</th><td><?= h($record->status ?? '') ?></td></tr>
        <tr><th>notes</th><td><?= h($record->notes ?? '') ?></td></tr>
        <tr><th>created_by</th><td><?= h($record->created_by ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
