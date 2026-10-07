<div class="production_order_materials form">
    <h3>Thêm ProductionOrderMaterials</h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('production_order_id', ['label' => 'Lệnh sản xuất', 'options' => $related['ProductionOrders'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('product_id', ['label' => 'Sản phẩm', 'options' => $related['Products'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('quantity_required', ['label' => 'Số lượng yêu cầu', 'class' => 'form-control']) ?>
        <?= $this->Form->control('quantity_used', ['label' => 'Số lượng sử dụng', 'class' => 'form-control']) ?>
        <?= $this->Form->control('unit_price', ['label' => 'Đơn giá', 'class' => 'form-control']) ?>
        <?= $this->Form->control('total_cost', ['label' => 'Tổng chi phí', 'class' => 'form-control']) ?>
        <?= $this->Form->control('warehouse_id', ['label' => 'Warehouse Id', 'options' => $related['Warehouses'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Lưu', ['class' => 'btn btn-primary']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
