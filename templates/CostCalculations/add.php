<div class="cost_calculations form">
    <h3>Thêm CostCalculations</h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('calculation_code', ['label' => 'Mã tính giá', 'class' => 'form-control']) ?>
        <?= $this->Form->control('production_order_id', ['label' => 'Lệnh sản xuất', 'options' => $related['ProductionOrders'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('material_cost', ['label' => 'Chi phí vật liệu', 'class' => 'form-control']) ?>
        <?= $this->Form->control('labor_cost', ['label' => 'Chi phí nhân công', 'class' => 'form-control']) ?>
        <?= $this->Form->control('overhead_cost', ['label' => 'Chi phí chung', 'class' => 'form-control']) ?>
        <?= $this->Form->control('total_cost', ['label' => 'Tổng chi phí', 'class' => 'form-control']) ?>
        <?= $this->Form->control('unit_cost', ['label' => 'Unit Cost', 'class' => 'form-control']) ?>
        <?= $this->Form->control('calculation_date', ['label' => 'Ngày tính giá', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('status', ['label' => 'Trạng thái', 'type' => 'select', 'options' => ['draft' => 'draft', 'approved' => 'approved'], 'class' => 'form-control']) ?>
        <?= $this->Form->control('notes', ['label' => 'Ghi chú', 'type' => 'textarea', 'class' => 'form-control']) ?>
        <?= $this->Form->control('created_by', ['label' => 'Người tạo', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Lưu', ['class' => 'btn btn-primary']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
