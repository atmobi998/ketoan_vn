<div class="payrolls form">
    <h3>Thêm Payrolls</h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('payroll_code', ['label' => 'Mã bảng lương', 'class' => 'form-control']) ?>
        <?= $this->Form->control('payroll_month', ['label' => 'Tháng lương', 'class' => 'form-control']) ?>
        <?= $this->Form->control('payroll_year', ['label' => 'Năm lương', 'class' => 'form-control']) ?>
        <?= $this->Form->control('department_id', ['label' => 'Phòng ban', 'options' => $related['Departments'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('total_employees', ['label' => 'Tổng nhân viên', 'class' => 'form-control']) ?>
        <?= $this->Form->control('total_amount', ['label' => 'Tổng tiền', 'class' => 'form-control']) ?>
        <?= $this->Form->control('total_deduction', ['label' => 'Tổng trừ', 'class' => 'form-control']) ?>
        <?= $this->Form->control('insurance_deduction', ['label' => 'Trừ BHXH', 'class' => 'form-control']) ?>
        <?= $this->Form->control('tax_deduction', ['label' => 'Thuế TNCN', 'class' => 'form-control']) ?>
        <?= $this->Form->control('total_net', ['label' => 'Tổng thực nhận', 'class' => 'form-control']) ?>
        <?= $this->Form->control('status', ['label' => 'Trạng thái', 'type' => 'select', 'options' => ['draft' => 'draft', 'approved' => 'approved', 'paid' => 'paid'], 'class' => 'form-control']) ?>
        <?= $this->Form->control('created_by', ['label' => 'Người tạo', 'class' => 'form-control']) ?>
        <?= $this->Form->control('accounting_period_id', ['label' => 'Kỳ kế toán', 'options' => $related['AccountingPeriods'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Lưu', ['class' => 'btn btn-primary']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
