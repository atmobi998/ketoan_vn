<div class="stock_adjustments form">
    <h3>Thêm StockAdjustments</h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('adjustment_number', ['label' => 'Số phiếu điều chỉnh', 'class' => 'form-control']) ?>
        <?= $this->Form->control('adjustment_date', ['label' => 'Ngày điều chỉnh', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('warehouse_id', ['label' => 'Warehouse Id', 'options' => $related['Warehouses'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('adjustment_type', ['label' => 'Loại điều chỉnh', 'type' => 'select', 'options' => ['increase' => 'increase', 'decrease' => 'decrease'], 'class' => 'form-control']) ?>
        <?= $this->Form->control('reason', ['label' => 'Lý do', 'type' => 'textarea', 'class' => 'form-control']) ?>
        <?= $this->Form->control('total_amount', ['label' => 'Tổng tiền', 'class' => 'form-control']) ?>
        <?= $this->Form->control('status', ['label' => 'Trạng thái', 'type' => 'select', 'options' => ['draft' => 'draft', 'approved' => 'approved', 'cancelled' => 'cancelled'], 'class' => 'form-control']) ?>
        <?= $this->Form->control('created_by', ['label' => 'Người tạo', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Lưu', ['class' => 'btn btn-primary']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
