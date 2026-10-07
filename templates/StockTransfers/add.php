<div class="stock_transfers form">
    <h3>Thêm StockTransfers</h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('transfer_number', ['label' => 'Số phiếu chuyển', 'class' => 'form-control']) ?>
        <?= $this->Form->control('from_warehouse_id', ['label' => 'Từ kho', 'options' => $related['FromWarehouses'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('to_warehouse_id', ['label' => 'Đến kho', 'options' => $related['ToWarehouses'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('transfer_date', ['label' => 'Ngày chuyển', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('status', ['label' => 'Trạng thái', 'type' => 'select', 'options' => ['draft' => 'draft', 'approved' => 'approved', 'completed' => 'completed', 'cancelled' => 'cancelled'], 'class' => 'form-control']) ?>
        <?= $this->Form->control('notes', ['label' => 'Ghi chú', 'type' => 'textarea', 'class' => 'form-control']) ?>
        <?= $this->Form->control('created_by', ['label' => 'Người tạo', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Lưu', ['class' => 'btn btn-primary']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
