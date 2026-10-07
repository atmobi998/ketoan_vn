<div class="production_order_materials form">
    <h3>Sửa ProductionOrderMaterials: <?= h($record->id) ?></h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('production_order_id', ['label' => 'Lệnh sản xuất', 'options' => $related['ProductionOrders'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('product_id', ['label' => 'Sản phẩm', 'options' => $related['Products'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('quantity_required', ['label' => 'Số lượng yêu cầu', 'class' => 'form-control']) ?>
        <?= $this->Form->control('quantity_used', ['label' => 'Số lượng sử dụng', 'class' => 'form-control','OnChange' => 'upd_total_cost();']) ?>
        <?= $this->Form->control('unit_id', ['label' => 'Đơn vị tính', 'options' => $related['Units'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('unit_price', ['label' => 'Đơn giá', 'class' => 'form-control','OnChange' => 'upd_total_cost();']) ?>
        <?= $this->Form->control('total_cost', ['label' => 'Tổng chi phí', 'class' => 'form-control']) ?>
        <?= $this->Form->control('warehouse_id', ['label' => 'Kho', 'options' => $related['Warehouses'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'edit',$record->id], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
<script>
function upd_total_cost() {
    var quantity_used = $('#quantity-used').val();
    var unit_price = $('#unit-price').val();
    var total_cost = parseFloat(quantity_used*unit_price).toFixed(2);
    $('#total-cost').val(total_cost);
}

$(function() {  
    upd_total_cost();  
});
</script>
