<div class="employment_contracts view">
    <h3>Chi tiết EmploymentContracts: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>số hợp đồng</th><td><?= h($record->contract_number ?? '') ?></td></tr>
        <tr><th>employee_id</th><td><?= h($record->employee_id ?? '') ?></td></tr>
        <tr><th>loại hợp đồng</th><td><?= h($record->contract_type ?? '') ?></td></tr>
        <tr><th>Ngày BĐ</th><td><?= h($record->start_date ?? '') ?></td></tr>
        <tr><th>Ngày KT</th><td><?= h($record->end_date ?? '') ?></td></tr>
        <tr><th>Lương</th><td><?= h($record->salary ?? '') ?></td></tr>
        <tr><th>Trạng thái</th><td><?= h($record->status ?? '') ?></td></tr>
        <tr><th>notes</th><td><?= h($record->notes ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
