<div class="tools form">
    <h3>Sửa Tools: <?= h($record->id) ?></h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('code', ['label' => 'Mã', 'class' => 'form-control']) ?>
        <?= $this->Form->control('name', ['label' => 'Tên', 'class' => 'form-control']) ?>
        <?= $this->Form->control('tool_category_id', ['label' => 'Loại công cụ', 'options' => $related['ToolCategories'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('quantity', ['label' => 'Số lượng', 'class' => 'form-control']) ?>
        <?= $this->Form->control('unit_id', ['label' => 'Unit Id', 'options' => $related['Units'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('unit_price', ['label' => 'Đơn giá', 'class' => 'form-control']) ?>
        <?= $this->Form->control('total_value', ['label' => 'Tổng giá trị', 'class' => 'form-control']) ?>
        <?= $this->Form->control('allocation_months', ['label' => 'Số tháng phân bổ', 'class' => 'form-control']) ?>
        <?= $this->Form->control('remaining_value', ['label' => 'Giá trị còn lại', 'class' => 'form-control']) ?>
        <?= $this->Form->control('status', ['label' => 'Trạng thái', 'type' => 'select', 'options' => ['in_use' => 'in_use', 'allocated' => 'allocated', 'disposed' => 'disposed'], 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
