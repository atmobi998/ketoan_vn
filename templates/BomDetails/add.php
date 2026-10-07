<div class="bom_details form">
    <h3>Thêm BomDetails</h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('bom_id', ['label' => 'Định mức BOM', 'options' => $related['Boms'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('material_id', ['label' => 'Nguyên vật liệu', 'options' => $related['Products'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('quantity', ['label' => 'Số lượng', 'class' => 'form-control']) ?>
        <?= $this->Form->control('unit_id', ['label' => 'Unit Id', 'options' => $related['Units'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('waste_rate', ['label' => 'Waste Rate', 'class' => 'form-control']) ?>
        <?= $this->Form->control('unit_cost', ['label' => 'Unit Cost', 'class' => 'form-control']) ?>
        <?= $this->Form->control('total_cost', ['label' => 'Tổng chi phí', 'class' => 'form-control']) ?>
        <?= $this->Form->control('notes', ['label' => 'Ghi chú', 'class' => 'form-control']) ?>

    <?= $this->Form->button('Lưu', ['class' => 'btn btn-primary']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
