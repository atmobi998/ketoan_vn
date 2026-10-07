<div class="production_orders form">
    <h3>Thêm ProductionOrders</h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('po_number', ['label' => 'Số đơn mua hàng', 'class' => 'form-control']) ?>
        <?= $this->Form->control('bom_id', ['label' => 'Định mức BOM', 'options' => $related['Boms'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('product_id', ['label' => 'Sản phẩm', 'options' => $related['Products'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('quantity_planned', ['label' => 'Số lượng kế hoạch', 'class' => 'form-control']) ?>
        <?= $this->Form->control('quantity_produced', ['label' => 'Số lượng sản xuất', 'class' => 'form-control']) ?>
        <?= $this->Form->control('start_date', ['label' => 'Ngày bắt đầu', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('end_date', ['label' => 'Ngày kết thúc', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('status', ['label' => 'Trạng thái', 'type' => 'select', 'options' => ['planned' => 'planned', 'in_progress' => 'in_progress', 'completed' => 'completed', 'cancelled' => 'cancelled'], 'class' => 'form-control']) ?>
        <?= $this->Form->control('cost_center_id', ['label' => 'Trung tâm chi phí', 'options' => $related['CostCenters'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('created_by', ['label' => 'Người tạo', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Lưu', ['class' => 'btn btn-primary']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
