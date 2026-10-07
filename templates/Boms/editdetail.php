<div class="bom_details form">
    <h3>Sửa BomDetails: <?= h($record->id) ?></h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('bom_id', ['label' => 'Định mức BOM', 'options' => $related['Boms'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('material_id', ['label' => 'Nguyên vật liệu', 'options' => $related['Products'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('quantity', ['label' => 'Số lượng', 'class' => 'form-control','OnChange'=>'upd_total_cost();']) ?>
        <?= $this->Form->control('unit_id', ['label' => 'Đơn vị tính', 'options' => $related['Units'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('waste_rate', ['label' => 'Waste Rate', 'class' => 'form-control']) ?>
        <?= $this->Form->control('unit_cost', ['label' => 'Unit Cost', 'class' => 'form-control','OnChange'=>'upd_total_cost();']) ?>
        <?= $this->Form->control('total_cost', ['label' => 'Tổng chi phí', 'class' => 'form-control']) ?>
        <?= $this->Form->control('notes', ['label' => 'Ghi chú', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
<script>
function upd_total_cost() {
    var quantity=parseFloat($('#quantity').val());
    var unit_cost=parseFloat($('#unit-cost').val());
    var total_cost=parseFloat(quantity*unit_cost).toFixed(2);
    $('#total-cost').val(total_cost);
}

$(function() {  
    upd_total_cost();  
});
</script>