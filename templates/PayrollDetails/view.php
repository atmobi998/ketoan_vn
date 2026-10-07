<div class="payroll_details view">
    <h3>Chi tiết PayrollDetails: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>payroll_id</th><td><?= h($record->payroll_id ?? '') ?></td></tr>
        <tr><th>employee_id</th><td><?= h($record->employee_id ?? '') ?></td></tr>
        <tr><th>lương cơ bản</th><td><?= h($record->basic_salary ?? '') ?></td></tr>
        <tr><th>khoản phụ cấp</th><td><?= h($record->allowance ?? '') ?></td></tr>
        <tr><th>tiền làm thêm giờ</th><td><?= h($record->overtime_amount ?? '') ?></td></tr>
        <tr><th>thưởng</th><td><?= h($record->bonus ?? '') ?></td></tr>
        <tr><th>khoản khấu trừ bảo hiểm</th><td><?= h($record->insurance_deduction ?? '') ?></td></tr>
        <tr><th>khoản khấu trừ thuế</th><td><?= h($record->tax_deduction ?? '') ?></td></tr>
        <tr><th>other_deduction</th><td><?= h($record->other_deduction ?? '') ?></td></tr>
        <tr><th>lương thực nhận</th><td><?= h($record->net_salary ?? '') ?></td></tr>
        <tr><th>notes</th><td><?= h($record->notes ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
