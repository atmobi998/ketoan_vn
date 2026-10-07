<div class="purchase_order_details form">
    <h3>Sửa PurchaseOrderDetails: <?= h($record->id) ?></h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('purchase_order_id', ['label' => 'Đơn mua hàng', 'options' => $related['PurchaseOrders'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('product_id', ['label' => 'Sản phẩm', 'options' => $related['Products'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('quantity', ['label' => 'Số lượng', 'class' => 'form-control','OnChange'=>'upd_total_amt();']) ?>
        <?= $this->Form->control('unit_id', ['label' => 'Đơn vị tính', 'options' => $related['Units'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('unit_price', ['label' => 'Đơn giá', 'class' => 'form-control','OnChange'=>'upd_total_amt();']) ?>
        <?= $this->Form->control('amount', ['label' => 'Số tiền', 'class' => 'form-control']) ?>
        <?= $this->Form->control('vat_rate', ['label' => 'Vat Rate', 'class' => 'form-control','OnChange'=>'upd_total_amt();']) ?>
        <?= $this->Form->control('vat_amount', ['label' => 'Vat Amount', 'class' => 'form-control']) ?>
        <?= $this->Form->control('description', ['label' => 'Diễn giải', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
<script>
function upd_total_amt() {
    var vat_rate = parseFloat($('#vat-rate').val());
    var unit_price = parseFloat($('#unit-price').val());
    var quantity = parseFloat($('#quantity').val());
    var amount = unit_price*quantity;
    var vat_amount = amount*(vat_rate/100);
    $('#vat-amount').val(vat_amount.toFixed(2));
    $('#amount').val(amount.toFixed(2));
}
</script>