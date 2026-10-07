<div class="stock_adjustment_details form">
    <h3>Sửa StockAdjustmentDetails: <?= h($record->id) ?></h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('stock_adjustment_id', ['label' => 'Phiếu điều chỉnh tồn kho', 'options' => $related['StockAdjustments'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('product_id', ['label' => 'Sản phẩm', 'options' => $related['Products'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('quantity_system', ['label' => 'Số lượng hệ thống', 'class' => 'form-control']) ?>
        <?= $this->Form->control('quantity_actual', ['label' => 'Số lượng thực tế', 'class' => 'form-control']) ?>
        <?= $this->Form->control('quantity_diff', ['label' => 'Chênh lệch', 'class' => 'form-control']) ?>
        <?= $this->Form->control('unit_price', ['label' => 'Đơn giá', 'class' => 'form-control']) ?>
        <?= $this->Form->control('amount', ['label' => 'Số tiền', 'class' => 'form-control']) ?>

    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
