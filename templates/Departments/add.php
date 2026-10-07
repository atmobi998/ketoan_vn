<div class="departments form">
    <h3>Thêm Departments</h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('code', ['label' => 'Mã', 'class' => 'form-control']) ?>
        <?= $this->Form->control('name', ['label' => 'Tên', 'class' => 'form-control']) ?>
        <?= $this->Form->control('description', ['label' => 'Diễn giải', 'type' => 'textarea', 'class' => 'form-control']) ?>
        <?= $this->Form->control('parent_id', ['label' => 'Tài khoản cha', 'options' => $related['Parents'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('manager_id', ['label' => 'Người quản lý', 'options' => $related['Managers'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Lưu', ['class' => 'btn btn-primary']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
