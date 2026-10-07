<div class="tool_allocations view">
    <h3>Chi tiết ToolAllocations: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>tool_id</th><td><?= h($record->tool_id ?? '') ?></td></tr>
        <tr><th>employee_id</th><td><?= h($record->employee_id ?? '') ?></td></tr>
        <tr><th>department_id</th><td><?= h($record->department_id ?? '') ?></td></tr>
        <tr><th>ngày phân bổ</th><td><?= h($record->allocation_date ?? '') ?></td></tr>
        <tr><th>số lượng</th><td><?= h($record->quantity ?? '') ?></td></tr>
        <tr><th>số tiền</th><td><?= h($record->amount ?? '') ?></td></tr>
        <tr><th>monthly_allocation</th><td><?= h($record->monthly_allocation ?? '') ?></td></tr>
        <tr><th>remaining_months</th><td><?= h($record->remaining_months ?? '') ?></td></tr>
        <tr><th>trạng thái</th><td><?= h($record->status ?? '') ?></td></tr>
        <tr><th>notes</th><td><?= h($record->notes ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
