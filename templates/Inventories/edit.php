<div class="inventories form">
    <h3>Sửa Inventories: <?= h($record->id) ?></h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('product_id', ['label' => 'Sản phẩm', 'options' => $related['Products'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('warehouse_id', ['label' => 'Warehouse Id', 'options' => $related['Warehouses'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('quantity', ['label' => 'Số lượng', 'class' => 'form-control','OnChange' => 'upd_quantity();']) ?>
        <?= $this->Form->control('quantity_available', ['label' => 'Số lượng khả dụng', 'class' => 'form-control']) ?>
        <?= $this->Form->control('quantity_reserved', ['label' => 'Số lượng giữ chỗ', 'class' => 'form-control','OnChange' => 'upd_quantity();']) ?>
        <?= $this->Form->control('unit_id', ['label' => 'Unit Id', 'options' => $related['Units'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('last_import_price', ['label' => 'Giá nhập cuối', 'class' => 'form-control']) ?>
        <?= $this->Form->control('average_price', ['label' => 'Giá trung bình', 'class' => 'form-control']) ?>
        <?= $this->Form->control('last_updated', ['label' => 'Cập nhật cuối', 'type' => 'date', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
<script>
    function upd_quantity() {
        var quantity=parseFloat($('#quantity').val());
        var quantity_reserved=parseFloat($('#quantity-reserved').val());
        var quantity_available=(quantity-quantity_reserved).toFixed(2);
        $('#quantity-available').val(quantity_available);
    }
</script>