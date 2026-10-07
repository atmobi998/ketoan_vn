<div class="warehouses form">
    <h3>Sửa Warehouses: <?= h($record->id) ?></h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('code', ['label' => 'Mã', 'class' => 'form-control']) ?>
        <?= $this->Form->control('name', ['label' => 'Tên', 'class' => 'form-control']) ?>
        <?= $this->Form->control('address', ['label' => 'Địa chỉ', 'class' => 'form-control']) ?>
        <?= $this->Form->control('manager_id', ['label' => 'Người quản lý', 'options' => $related['Employees'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('is_active', ['label' => 'Kích hoạt', 'type' => 'checkbox']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
