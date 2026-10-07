<div class="chart_of_accounts view">
    <h3>Chi tiết ChartOfAccounts: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>Mã Code</th><td><?= h($record->code ?? '') ?></td></tr>
        <tr><th>Tên</th><td><?= h($record->name ?? '') ?></td></tr>
        <tr><th>loại tài khoản</th><td><?= h($record->account_type ?? '') ?></td></tr>
        <tr><th>ID cha</th><td><?= h($record->parent_id ?? '') ?></td></tr>
        <tr><th>là chi tiết</th><td><?= h($record->is_detail ?? '') ?></td></tr>
        <tr><th>loại số dư</th><td><?= h($record->balance_type ?? '') ?></td></tr>
        <tr><th>diễn giải</th><td><?= h($record->description ?? '') ?></td></tr>
        <tr><th>is_active</th><td><?= h($record->is_active ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
