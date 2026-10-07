<div class="users form">
    <h3>Thêm Users</h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('username', ['label' => 'Username', 'class' => 'form-control']) ?>
        <?= $this->Form->control('email', ['label' => 'Email', 'class' => 'form-control']) ?>
        <?= $this->Form->control('password', ['label' => 'Mật khẩu', 'class' => 'form-control']) ?>
        <?= $this->Form->control('full_name', ['label' => 'Họ và tên', 'class' => 'form-control']) ?>
        <?= $this->Form->control('role', ['label' => 'Vai trò', 'type' => 'select', 'options' => ['superadmin' => 'superadmin', 'admin' => 'admin', 'user' => 'user'], 'class' => 'form-control']) ?>
        <?= $this->Form->control('department_id', ['label' => 'Phòng ban', 'options' => $related['Departments'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('is_active', ['label' => 'Kích hoạt', 'type' => 'checkbox']) ?>
        <?= $this->Form->control('last_login', ['label' => 'Đăng nhập cuối', 'type' => 'date', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Lưu', ['class' => 'btn btn-primary']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
