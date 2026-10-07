<div class="sales_order_details form">
    <h3>Sửa SalesOrderDetails: <?= h($record->id) ?></h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('sales_order_id', ['label' => 'Đơn bán hàng', 'options' => $related['SalesOrders'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('product_id', ['label' => 'Sản phẩm', 'options' => $related['Products'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('quantity', ['label' => 'Số lượng', 'class' => 'form-control']) ?>
        <?= $this->Form->control('unit_id', ['label' => 'Unit Id', 'options' => $related['Units'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('unit_price', ['label' => 'Đơn giá', 'class' => 'form-control']) ?>
        <?= $this->Form->control('amount', ['label' => 'Số tiền', 'class' => 'form-control']) ?>
        <?= $this->Form->control('vat_rate', ['label' => 'Vat Rate', 'class' => 'form-control']) ?>
        <?= $this->Form->control('vat_amount', ['label' => 'Vat Amount', 'class' => 'form-control']) ?>
        <?= $this->Form->control('description', ['label' => 'Diễn giải', 'class' => 'form-control']) ?>

    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
