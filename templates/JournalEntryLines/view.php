<div class="journal_entry_lines view">
    <h3>Chi tiết JournalEntryLines: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>journal_entry_id</th><td><?= h($record->journal_entry_id ?? '') ?></td></tr>
        <tr><th>Tài khoản KT</th><td><?= h($record->chart_of_account_id ?? '') ?></td></tr>
        <tr><th>Nợ</th><td><?= h($record->debit ?? '') ?></td></tr>
        <tr><th>Có</th><td><?= h($record->credit ?? '') ?></td></tr>
        <tr><th>diễn giải</th><td><?= h($record->description ?? '') ?></td></tr>
        <tr><th>trung tâm chi phí</th><td><?= h($record->cost_center_id ?? '') ?></td></tr>
        <tr><th>customer_id</th><td><?= h($record->customer_id ?? '') ?></td></tr>
        <tr><th>supplier_id</th><td><?= h($record->supplier_id ?? '') ?></td></tr>
        <tr><th>mã sản phẩm</th><td><?= h($record->product_id ?? '') ?></td></tr>
        <tr><th>employee_id</th><td><?= h($record->employee_id ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
