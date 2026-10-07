<div class="tool_allocations form">
    <h3>Sửa ToolAllocations: <?= h($record->id) ?></h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('tool_id', ['label' => 'Công cụ', 'options' => $related['Tools'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('employee_id', ['label' => 'Nhân viên', 'options' => $related['Employees'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('department_id', ['label' => 'Phòng ban', 'options' => $related['Departments'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('allocation_date', ['label' => 'Ngày phân bổ', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('quantity', ['label' => 'Số lượng', 'class' => 'form-control']) ?>
        <?= $this->Form->control('amount', ['label' => 'Số tiền', 'class' => 'form-control']) ?>
        <?= $this->Form->control('monthly_allocation', ['label' => 'Phân bổ hàng tháng', 'class' => 'form-control']) ?>
        <?= $this->Form->control('remaining_months', ['label' => 'Tháng còn lại', 'class' => 'form-control']) ?>
        <?= $this->Form->control('status', ['label' => 'Trạng thái', 'type' => 'select', 'options' => ['active' => 'active', 'completed' => 'completed', 'cancelled' => 'cancelled'], 'class' => 'form-control']) ?>
        <?= $this->Form->control('notes', ['label' => 'Ghi chú', 'type' => 'textarea', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
