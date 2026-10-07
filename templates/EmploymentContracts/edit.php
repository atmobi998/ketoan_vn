<div class="employment_contracts form">
    <h3>Sửa EmploymentContracts: <?= h($record->id) ?></h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('contract_number', ['label' => 'Số hợp đồng', 'class' => 'form-control']) ?>
        <?= $this->Form->control('employee_id', ['label' => 'Nhân viên', 'options' => $related['Employees'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('contract_type', ['label' => 'Loại hợp đồng', 'type' => 'select', 'options' => ['probation' => 'probation', 'definite' => 'definite', 'indefinite' => 'indefinite'], 'class' => 'form-control']) ?>
        <?= $this->Form->control('start_date', ['label' => 'Ngày bắt đầu', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('end_date', ['label' => 'Ngày kết thúc', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('salary', ['label' => 'Lương', 'class' => 'form-control']) ?>
        <?= $this->Form->control('status', ['label' => 'Trạng thái', 'type' => 'select', 'options' => ['active' => 'active', 'expired' => 'expired', 'terminated' => 'terminated'], 'class' => 'form-control']) ?>
        <?= $this->Form->control('notes', ['label' => 'Ghi chú', 'type' => 'textarea', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
