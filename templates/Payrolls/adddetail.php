<div class="payroll_details form">
    <h3>Thêm PayrollDetails</h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('payroll_id', ['label' => 'Bảng lương', 'options' => $related['Payrolls'] ?? [], 'value' => $id_master, 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('employee_id', ['label' => 'Nhân viên', 'options' => $related['Employees'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('basic_salary', ['label' => 'Lương cơ bản', 'class' => 'form-control']) ?>
        <?= $this->Form->control('allowance', ['label' => 'Phụ cấp', 'class' => 'form-control']) ?>
        <?= $this->Form->control('overtime_amount', ['label' => 'Tiền tăng ca', 'class' => 'form-control']) ?>
        <?= $this->Form->control('bonus', ['label' => 'Thưởng', 'class' => 'form-control']) ?>
        <?= $this->Form->control('insurance_deduction', ['label' => 'Trừ BHXH', 'class' => 'form-control']) ?>
        <?= $this->Form->control('tax_deduction', ['label' => 'Thuế TNCN', 'class' => 'form-control']) ?>
        <?= $this->Form->control('other_deduction', ['label' => 'Trừ khác', 'class' => 'form-control']) ?>
        <?= $this->Form->control('net_salary', ['label' => 'Lương thực nhận', 'class' => 'form-control']) ?>
        <?= $this->Form->control('notes', ['label' => 'Ghi chú', 'type' => 'textarea', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Lưu', ['class' => 'btn btn-primary']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
