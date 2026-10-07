<div class="payrolls view">
    <h3>Chi tiết Payrolls: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>mã tính lương</th><td><?= h($record->payroll_code ?? '') ?></td></tr>
        <tr><th>tháng trả lương</th><td><?= h($record->payroll_month ?? '') ?></td></tr>
        <tr><th>năm tính lương</th><td><?= h($record->payroll_year ?? '') ?></td></tr>
        <tr><th>department_id</th><td><?= h($record->department_id ?? '') ?></td></tr>
        <tr><th>tổng số nhân viên</th><td><?= h($record->total_employees ?? '') ?></td></tr>
        <tr><th>tổng số tiền</th><td><?= h($record->total_amount ?? '') ?></td></tr>
        <tr><th>tổng các khoản khấu trừ</th><td><?= h($record->total_deduction ?? '') ?></td></tr>
        <tr><th>tổng giá trị thực nhận</th><td><?= h($record->total_net ?? '') ?></td></tr>
        <tr><th>Trạng thái</th><td><?= h($record->status ?? '') ?></td></tr>
        <tr><th>created_by</th><td><?= h($record->created_by ?? '') ?></td></tr>
        <tr><th>accounting_period_id</th><td><?= h($record->accounting_period_id ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
