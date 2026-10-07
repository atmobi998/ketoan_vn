<div class="production_order_materials form">
    <h3>Thêm ProductionOrderMaterials</h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('production_order_id', ['label' => 'Lệnh sản xuất', 'options' => $related['ProductionOrders'] ?? [], 'value' => $id_master, 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('product_id', ['label' => 'Sản phẩm', 'options' => $related['Products'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('quantity_required', ['label' => 'Số lượng yêu cầu', 'class' => 'form-control','OnChange'=>'upd_total_amt();']) ?>
        <?= $this->Form->control('quantity_used', ['label' => 'Số lượng sử dụng', 'class' => 'form-control','OnChange'=>'upd_total_amt();']) ?>
        <?= $this->Form->control('unit_id', ['label' => 'Đơn vị tính', 'options' => $related['Units'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('unit_price', ['label' => 'Đơn giá', 'class' => 'form-control','OnChange'=>'upd_total_amt();']) ?>
        <?= $this->Form->control('total_cost', ['label' => 'Tổng chi phí', 'class' => 'form-control']) ?>
        <?= $this->Form->control('warehouse_id', ['label' => 'Kho', 'options' => $related['Warehouses'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Lưu', ['class' => 'btn btn-primary']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'edit',$id_master], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
<script>
function upd_total_amt() {
    var unit_price = parseFloat($('#unit-price').val());
    var quantity = parseFloat($('#quantity-used').val());
    var total_cost = unit_price*quantity;
    $('#total-cost').val(total_cost.toFixed(2));
}
</script>

