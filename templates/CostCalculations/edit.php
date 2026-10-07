<div class="cost_calculations form">
    <h3>Sửa CostCalculations: <?= h($record->id) ?></h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('calculation_code', ['label' => 'Mã tính giá', 'class' => 'form-control']) ?>
        <?= $this->Form->control('production_order_id', ['label' => 'Lệnh sản xuất', 'options' => $related['ProductionOrders'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control','OnChange'=>'updateprodord();']) ?>
        <?= $this->Form->control('units', ['label' => 'Units', 'class' => 'form-control','value'=>$rec->quantity_produced]) ?>
        <?= $this->Form->control('material_cost', ['label' => 'Chi phí vật liệu', 'class' => 'form-control','OnChange'=>'upd_unit_cost();','value' => $material_cost]) ?>
        <?= $this->Form->control('labor_cost', ['label' => 'Chi phí nhân công', 'class' => 'form-control','OnChange'=>'upd_unit_cost();','value' => $labor_cost]) ?>
        <?= $this->Form->control('overhead_cost', ['label' => 'Chi phí chung', 'class' => 'form-control','OnChange'=>'upd_unit_cost();','value' => $overhead_cost]) ?>
        <?= $this->Form->control('total_cost', ['label' => 'Tổng chi phí', 'class' => 'form-control']) ?>
        <?= $this->Form->control('unit_cost', ['label' => 'Unit Cost', 'class' => 'form-control']) ?>
        <?= $this->Form->control('calculation_date', ['label' => 'Ngày tính giá', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('status', ['label' => 'Trạng thái', 'type' => 'select', 'options' => ['draft' => 'draft', 'approved' => 'approved'], 'class' => 'form-control']) ?>
        <?= $this->Form->control('notes', ['label' => 'Ghi chú', 'type' => 'textarea', 'class' => 'form-control']) ?>
        <?= $this->Form->control('created_by', ['label' => 'Người tạo', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
<script>
function upd_unit_cost() {
    var material_cost = parseFloat($('#material-cost').val());
    var labor_cost = parseFloat($('#labor-cost').val());
    var overhead_cost = parseFloat($('#overhead-cost').val());
    var total_cost = parseFloat(material_cost+labor_cost+overhead_cost).toFixed(2);
    $('#total-cost').val(total_cost);
    var units = parseFloat($('#units').val());
    if (units > 0) {
        var unit_cost = parseFloat(total_cost/units).toFixed(2);
        $('#unit-cost').val(unit_cost);
    }
}

function updateprodord() {
    if ($('#production-order-id').val() != '') {
        var postdata={};
        var ssurl = '/production-orders/getprodord/'+$('#production-order-id').val();
        $('#ajaxdoing').show();
        $.post(ssurl, postdata,
            function(retdata) {
                var retobj = JSON.parse(retdata);
                $('#ajaxdoing').hide();
                setTimeout(function() {
                    var material_cost=parseFloat(retobj.material_cost);
                    var labor_cost=parseFloat(retobj.labor_cost);
                    var overhead_cost=parseFloat(retobj.overhead_cost);
                    var total_cost=parseFloat(material_cost+labor_cost+overhead_cost);
                    $('#units').val(retobj.quantity_produced);
                    $('#material-cost').val(material_cost.toFixed(2));
                    $('#labor-cost').val(labor_cost.toFixed(2));
                    $('#overhead-cost').val(overhead_cost.toFixed(2));
                    $('#total-cost').val(total_cost.toFixed(2));
                    if (retobj.quantity_produced > 0) {
                        var unit_cost=parseFloat((total_cost)/retobj.quantity_produced);
                        $('#unit-cost').val(unit_cost.toFixed(2));
                    }
                }, 200);
            }
        );
    }
} 

$(function() {
    upd_unit_cost();
    updateprodord();
});
</script>