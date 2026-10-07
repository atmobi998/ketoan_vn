<div class="employees view">
    <h3>Chi tiết Employees: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>Mã Code</th><td><?= h($record->code ?? '') ?></td></tr>
        <tr><th>họ và tên</th><td><?= h($record->full_name ?? '') ?></td></tr>
        <tr><th>giới tính</th><td><?= h($record->gender ?? '') ?></td></tr>
        <tr><th>birth_date</th><td><?= h($record->birth_date ?? '') ?></td></tr>
        <tr><th>SĐT</th><td><?= h($record->phone ?? '') ?></td></tr>
        <tr><th>email</th><td><?= h($record->email ?? '') ?></td></tr>
        <tr><th>địa chỉ</th><td><?= h($record->address ?? '') ?></td></tr>
        <tr><th>department_id</th><td><?= h($record->department_id ?? '') ?></td></tr>
        <tr><th>position_id</th><td><?= h($record->position_id ?? '') ?></td></tr>
        <tr><th>ngày bắt đầu</th><td><?= h($record->join_date ?? '') ?></td></tr>
        <tr><th>lương cơ bản</th><td><?= h($record->basic_salary ?? '') ?></td></tr>
        <tr><th>tài khoản ngân hàng</th><td><?= h($record->bank_account ?? '') ?></td></tr>
        <tr><th>tên ngân hàng</th><td><?= h($record->bank_name ?? '') ?></td></tr>
        <tr><th>is_active</th><td><?= h($record->is_active ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
