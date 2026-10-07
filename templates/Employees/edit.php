<div class="employees form">
    <h3>Sửa Employees: <?= h($record->id) ?></h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('code', ['label' => 'Mã', 'class' => 'form-control']) ?>
        <?= $this->Form->control('full_name', ['label' => 'Họ và tên', 'class' => 'form-control']) ?>
        <?= $this->Form->control('gender', ['label' => 'Giới tính', 'type' => 'select', 'options' => ['male' => 'male', 'female' => 'female', 'other' => 'other'], 'class' => 'form-control']) ?>
        <?= $this->Form->control('birth_date', ['label' => 'Ngày sinh', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('phone', ['label' => 'Điện thoại', 'class' => 'form-control']) ?>
        <?= $this->Form->control('email', ['label' => 'Email', 'class' => 'form-control']) ?>
        <?= $this->Form->control('address', ['label' => 'Địa chỉ', 'type' => 'textarea', 'class' => 'form-control']) ?>
        <?= $this->Form->control('department_id', ['label' => 'Phòng ban', 'options' => $related['Departments'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('position_id', ['label' => 'Chức vụ', 'options' => $related['Positions'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('join_date', ['label' => 'Ngày vào làm', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('basic_salary', ['label' => 'Lương cơ bản', 'class' => 'form-control']) ?>
        <?= $this->Form->control('bonus', ['label' => 'Thưởng', 'class' => 'form-control']) ?>
        <?= $this->Form->control('bank_account', ['label' => 'Tài khoản ngân hàng', 'class' => 'form-control']) ?>
        <?= $this->Form->control('bank_name', ['label' => 'Tên ngân hàng', 'class' => 'form-control']) ?>
        <?= $this->Form->control('is_active', ['label' => 'Kích hoạt', 'type' => 'checkbox']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
