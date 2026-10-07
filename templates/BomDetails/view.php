<div class="bom_details view">
    <h3>Chi tiết BomDetails: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>bom_id</th><td><?= h($record->bom_id ?? '') ?></td></tr>
        <tr><th>material_id</th><td><?= h($record->material_id ?? '') ?></td></tr>
        <tr><th>số lượng</th><td><?= h($record->quantity ?? '') ?></td></tr>
        <tr><th>unit_id</th><td><?= h($record->unit_id ?? '') ?></td></tr>
        <tr><th>tỷ lệ lãng phí</th><td><?= h($record->waste_rate ?? '') ?></td></tr>
        <tr><th>chi phí mỗi đơn vị</th><td><?= h($record->unit_cost ?? '') ?></td></tr>
        <tr><th>tổng chi phí</th><td><?= h($record->total_cost ?? '') ?></td></tr>
        <tr><th>notes</th><td><?= h($record->notes ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
