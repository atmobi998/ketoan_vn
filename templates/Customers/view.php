<div class="customers view">
    <h3>Chi tiết Customers: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>Mã Code</th><td><?= h($record->code ?? '') ?></td></tr>
        <tr><th>Tên</th><td><?= h($record->name ?? '') ?></td></tr>
        <tr><th>MS thuế</th><td><?= h($record->tax_code ?? '') ?></td></tr>
        <tr><th>địa chỉ</th><td><?= h($record->address ?? '') ?></td></tr>
        <tr><th>SĐT</th><td><?= h($record->phone ?? '') ?></td></tr>
        <tr><th>email</th><td><?= h($record->email ?? '') ?></td></tr>
        <tr><th>contact_person</th><td><?= h($record->contact_person ?? '') ?></td></tr>
        <tr><th>Tài khoản KT</th><td><?= h($record->chart_of_account_id ?? '') ?></td></tr>
        <tr><th>debt_account</th><td><?= h($record->debt_account ?? '') ?></td></tr>
        <tr><th>is_active</th><td><?= h($record->is_active ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
