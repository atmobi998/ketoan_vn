<div class="delivery_notes form">
    <h3>Thêm DeliveryNotes</h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('dn_number', ['label' => 'Số phiếu giao hàng', 'class' => 'form-control']) ?>
        <?= $this->Form->control('delivery_date', ['label' => 'Ngày giao hàng', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('sales_order_id', ['label' => 'Đơn bán hàng', 'options' => $related['SalesOrders'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('customer_id', ['label' => 'Khách hàng', 'options' => $related['Customers'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('warehouse_id', ['label' => 'Warehouse Id', 'options' => $related['Warehouses'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('total_amount', ['label' => 'Tổng tiền', 'class' => 'form-control','OnChange'=>'upd_total_amt();']) ?>
        <?= $this->Form->control('vat_amount', ['label' => 'Vat Amount', 'class' => 'form-control']) ?>
        <?= $this->Form->control('discount_amount', ['label' => 'Số tiền chiết khấu', 'class' => 'form-control','OnChange'=>'upd_total_amt();']) ?>
        <?= $this->Form->control('grand_total', ['label' => 'Tổng cộng', 'class' => 'form-control']) ?>
        <?= $this->Form->control('status', ['label' => 'Trạng thái', 'type' => 'select', 'options' => ['draft' => 'draft', 'approved' => 'approved', 'cancelled' => 'cancelled'], 'class' => 'form-control']) ?>
        <?= $this->Form->control('notes', ['label' => 'Ghi chú', 'type' => 'textarea', 'class' => 'form-control']) ?>
        <?= $this->Form->control('created_by', ['label' => 'Người tạo', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Lưu', ['class' => 'btn btn-primary']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
<script>
function upd_total_amt() {
    var vat_rate=10.00;
    var total_amount = parseFloat($('#total-amount').val());
    var discount_amount = parseFloat($('#discount-amount').val());
    var vat_amount = total_amount*(vat_rate/100);
    var grand_total = total_amount + vat_amount - discount_amount;
    $('#vat-amount').val(vat_amount.toFixed(2));
    $('#grand-total').val(grand_total.toFixed(2));
}
</script>