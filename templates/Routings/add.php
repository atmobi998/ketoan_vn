<div class="routings form">
    <h3>Thêm Routings</h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('product_id', ['label' => 'Sản phẩm', 'options' => $related['Products'] ?? [], 'value' => $product_id, 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('operation_sequence', ['label' => 'Thứ tự công đoạn', 'class' => 'form-control']) ?>
        <?= $this->Form->control('work_center_id', ['label' => 'Work Center Id', 'options' => $related['WorkCenters'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('setup_time', ['label' => 'Thời gian chuẩn bị', 'class' => 'form-control']) ?>
        <?= $this->Form->control('run_time', ['label' => 'Thời gian chạy', 'class' => 'form-control']) ?>
        <?= $this->Form->control('operation_name', ['label' => 'Tên công đoạn', 'class' => 'form-control']) ?>
        <?= $this->Form->control('description', ['label' => 'Diễn giải', 'type' => 'textarea', 'class' => 'form-control']) ?>
        <?= $this->Form->control('cost', ['label' => 'Chi phí', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Lưu', ['class' => 'btn btn-primary']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
