<div class="journal_entries view">
    <h3>Chi tiết JournalEntries: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>số thứ tự mục</th><td><?= h($record->entry_number ?? '') ?></td></tr>
        <tr><th>ngày nhập liệu</th><td><?= h($record->entry_date ?? '') ?></td></tr>
        <tr><th>ngày hạch toán</th><td><?= h($record->accounting_date ?? '') ?></td></tr>
        <tr><th>diễn giải</th><td><?= h($record->description ?? '') ?></td></tr>
        <tr><th>tổng nợ</th><td><?= h($record->total_debit ?? '') ?></td></tr>
        <tr><th>tổng có</th><td><?= h($record->total_credit ?? '') ?></td></tr>
        <tr><th>Trạng thái</th><td><?= h($record->status ?? '') ?></td></tr>
        <tr><th>created_by</th><td><?= h($record->created_by ?? '') ?></td></tr>
        <tr><th>accounting_period_id</th><td><?= h($record->accounting_period_id ?? '') ?></td></tr>
        <tr><th>loại tham chiếu</th><td><?= h($record->reference_type ?? '') ?></td></tr>
        <tr><th>reference_id</th><td><?= h($record->reference_id ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
