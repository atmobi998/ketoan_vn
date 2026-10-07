<div class="attendances form">
    <h3>Sửa Attendances: <?= h($record->id) ?></h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('employee_id', ['label' => 'Nhân viên', 'options' => $related['Employees'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('work_date', ['label' => 'Work Date', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('check_in', ['label' => 'Giờ vào', 'class' => 'form-control']) ?>
        <?= $this->Form->control('check_out', ['label' => 'Giờ ra', 'class' => 'form-control']) ?>
        <?= $this->Form->control('work_hours', ['label' => 'Work Hours', 'class' => 'form-control']) ?>
        <?= $this->Form->control('overtime_hours', ['label' => 'Giờ tăng ca', 'class' => 'form-control']) ?>
        <?= $this->Form->control('status', ['label' => 'Trạng thái', 'type' => 'select', 'options' => ['present' => 'present', 'absent' => 'absent', 'late' => 'late', 'leave' => 'leave'], 'class' => 'form-control']) ?>
        <?= $this->Form->control('notes', ['label' => 'Ghi chú', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
