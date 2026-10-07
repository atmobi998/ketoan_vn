<div class="tools view">
    <h3>Chi tiết Tools: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>Mã Code</th><td><?= h($record->code ?? '') ?></td></tr>
        <tr><th>Tên</th><td><?= h($record->name ?? '') ?></td></tr>
        <tr><th>tool_category_id</th><td><?= h($record->tool_category_id ?? '') ?></td></tr>
        <tr><th>số lượng</th><td><?= h($record->quantity ?? '') ?></td></tr>
        <tr><th>unit_id</th><td><?= h($record->unit_id ?? '') ?></td></tr>
        <tr><th>đơn giá</th><td><?= h($record->unit_price ?? '') ?></td></tr>
        <tr><th>total_value</th><td><?= h($record->total_value ?? '') ?></td></tr>
        <tr><th>số tháng phân bổ</th><td><?= h($record->allocation_months ?? '') ?></td></tr>
        <tr><th>giá trị còn lại</th><td><?= h($record->remaining_value ?? '') ?></td></tr>
        <tr><th>trạng thái</th><td><?= h($record->status ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
