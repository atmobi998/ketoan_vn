<div class="production_order_costs form">
    <h3>Sửa ProductionOrderCosts: <?= h($record->id) ?></h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('production_order_id', ['label' => 'Lệnh sản xuất', 'options' => $related['ProductionOrders'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('cost_type', ['label' => 'Loại chi phí', 'type' => 'select', 'options' => ['material' => 'material', 'labor' => 'labor', 'overhead' => 'overhead'], 'class' => 'form-control']) ?>
        <?= $this->Form->control('amount', ['label' => 'Số tiền', 'class' => 'form-control']) ?>
        <?= $this->Form->control('description', ['label' => 'Diễn giải', 'class' => 'form-control']) ?>
        <?= $this->Form->control('cost_center_id', ['label' => 'Trung tâm chi phí', 'options' => $related['CostCenters'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
