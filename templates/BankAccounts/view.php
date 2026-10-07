<div class="bank_accounts view">
    <h3>Chi tiết BankAccounts: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>số tài khoản</th><td><?= h($record->account_number ?? '') ?></td></tr>
        <tr><th>tên ngân hàng</th><td><?= h($record->bank_name ?? '') ?></td></tr>
        <tr><th>chi nhánh</th><td><?= h($record->branch ?? '') ?></td></tr>
        <tr><th>currency_id</th><td><?= h($record->currency_id ?? '') ?></td></tr>
        <tr><th>Tài khoản KT</th><td><?= h($record->chart_of_account_id ?? '') ?></td></tr>
        <tr><th>số dư</th><td><?= h($record->balance ?? '') ?></td></tr>
        <tr><th>is_active</th><td><?= h($record->is_active ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
