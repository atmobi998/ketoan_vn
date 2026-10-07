<?php
        use Cake\I18n\FrozenDate;
        use Cake\I18n\Number;
?>
<div class="production_orders form">
    <h3>Sửa ProductionOrders: <?= h($record->id) ?></h3>
    <?= $this->Form->create($record,['id'=>'production-orders-form']) ?>
        <?= $this->Form->control('po_number', ['label' => 'Số đơn mua hàng', 'class' => 'form-control']) ?>
        <?= $this->Form->control('bom_id', ['label' => 'Định mức BOM', 'options' => $related['Boms'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control','OnChange'=>'form_submit();']) ?>
        <?= $this->Form->control('product_id', ['label' => 'Sản phẩm', 'options' => $related['Products'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('quantity_planned', ['label' => 'Số lượng kế hoạch', 'class' => 'form-control']) ?>
        <?= $this->Form->control('quantity_produced', ['label' => 'Số lượng sản xuất', 'class' => 'form-control']) ?>
        <?= $this->Form->control('start_date', ['label' => 'Ngày bắt đầu', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('end_date', ['label' => 'Ngày kết thúc', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('status', ['label' => 'Trạng thái', 'type' => 'select', 'options' => ['planned' => 'planned', 'in_progress' => 'in_progress', 'completed' => 'completed', 'cancelled' => 'cancelled'], 'class' => 'form-control']) ?>
        <?= $this->Form->control('cost_center_id', ['label' => 'Trung tâm chi phí', 'options' => $related['CostCenters'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('created_by', ['label' => 'Người tạo', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
<script>
    function form_submit() {
        $('#production-orders-form').submit();
    }
</script>
<div class="clearfix bg-light p-3"></div>
<div class="production_order_materials index">
    <h3>ProductionOrderMaterials <a href="<?= $this->Url->build(['action' => 'adddetail',$record->id]) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
    <a href="<?= $this->Url->build(['controller' => 'ProductionOrderMaterials','action' => 'exportExcel']) ?>" class="btn btn-success btn-sm float-end me-2"><i class="fa fa-file-excel"></i> Excel</a>
    <a href="<?= $this->Url->build(['controller' => 'ProductionOrderMaterials','action' => 'exportPdf']) ?>" class="btn btn-danger btn-sm float-end me-2"><i class="fa fa-file-pdf"></i> PDF</a></h3>
    <table class="table table-bordered table-striped">
        <thead><tr>
                <th>Mã ID</th>
                <th>Mã lệnh sản xuất</th>
                <th>sản phẩm</th>
                <th>số lượng yêu cầu</th>
                <th>số lượng đã sử dụng</th>
                <th>đơn vị</th>
                <th>đơn giá</th>
                <th>tổng chi phí</th>
                <th>Tác vụ</th>
        </tr></thead>
        <tbody>
        <?php 
            $total_cost=0;
            foreach ($records as $r): 
                $total_cost+=$r->total_cost;
        ?>
            <tr>
                <td><?= h($r->id ?? '') ?></td>
                <td><?= (!empty($r->production_order_id))? $r->production_order->full_name:'' ?></td>
                <td><?= (!empty($r->product_id))? $r->product->full_name:'' ?></td>
                <td><?= h($r->quantity_required ?? '') ?></td>
                <td><?= h($r->quantity_used ?? '') ?></td>
                 <td><?= (!empty($r->unit_id))? $r->unit->name:'' ?></td>
                <td><?= Number::format($r->unit_price ?? '') ?></td>
                <td><?= Number::format($r->total_cost ?? '') ?></td>
                <td>
                    <?= $this->Form->postLink('Xóa', ['action' => 'deletedetail', $r->id], ['confirm' => 'Xóa?', 'class' => 'btn btn-sm btn-danger']) ?>
                    <?= $this->Html->link('Sửa', ['action' => 'editdetail', $r->id], ['class' => 'btn btn-sm btn-warning']) ?>
                </td>
            </tr>
        <?php 
            endforeach; 
        ?>
        <?php
            if ($total_cost > 0) {
        ?>
            <tr>
                <td colspan="7"></td>
                <td><?= Number::format($total_cost ?? '') ?></td>
                <td></td>
        <?php
            }
        ?>
        </tbody>
    </table>
    <div class="paginator"><?= $this->Paginator->numbers() ?></div>
</div>
<div class="clearfix bg-light p-3"></div>
<div class="production_order_costs index">
    <h3>ProductionOrderCosts <a href="<?= $this->Url->build(['action' => 'addcost',$record->id]) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
    <a href="<?= $this->Url->build(['controller' => 'ProductionOrderCosts','action' => 'exportExcel']) ?>" class="btn btn-success btn-sm float-end me-2"><i class="fa fa-file-excel"></i> Excel</a>
    <a href="<?= $this->Url->build(['controller' => 'ProductionOrderCosts','action' => 'exportPdf']) ?>" class="btn btn-danger btn-sm float-end me-2"><i class="fa fa-file-pdf"></i> PDF</a></h3>
    <table class="table table-bordered table-striped">
        <thead><tr>
                <th>Mã ID</th>
                <th>Mã lệnh sản xuất</th>
                <th>cost_type</th>
                <th>số tiền</th>
                <th>diễn giải</th>
                <th>trung tâm chi phí</th>
                <th>TGian Tạo</th>
                <th>Tác vụ</th>
        </tr></thead>
        <tbody>
        <?php 
            $amount=0;
            foreach ($recordcosts as $r): 
                $amount+=$r->amount;
        ?>
            <tr>
                <td><?= h($r->id ?? '') ?></td>
                <td><?= (!empty($r->production_order_id))? $r->production_order->full_name:'' ?></td>
                <td><?= h($r->cost_type ?? '') ?></td>
                <td><?= Number::format($r->amount ?? '') ?></td>
                <td><?= h($r->description ?? '') ?></td>
                <td><?= (!empty($r->cost_center_id))? $r->cost_center->full_name:'' ?></td>
                <td><?= h($r->created ?? '') ?></td>
                <td>
                    <?= $this->Form->postLink('Xóa', ['action' => 'deletecost', $r->id], ['confirm' => 'Xóa?', 'class' => 'btn btn-sm btn-danger']) ?>
                    <?= $this->Html->link('Sửa', ['action' => 'editcost', $r->id], ['class' => 'btn btn-sm btn-warning']) ?>
                </td>
            </tr>
        <?php 
            endforeach; 
        ?>
        <?php
            if ($amount > 0) {
        ?>
            <tr>
                <td colspan="3"></td>
                <td><?= Number::format($amount ?? '') ?></td>
                <td colspan="4"></td>
        <?php
            }
        ?>
        </tbody>
    </table>
    <div class="paginator"><?= $this->Paginator->numbers() ?></div>
</div>
<div class="clearfix bg-light p-3"></div>
<div class="bom_details index">
    <h3>BomDetails 
        <?= $this->Html->link('Sửa', ['controller' => 'Boms','action' => 'edit', $record->bom_id], ['class' => 'btn btn-sm btn-warning']) ?>
    </h3>
    <table class="table table-bordered table-striped">
        <thead><tr>
                <th>Mã ID</th>
                <th>BOM</th>
                <th>nguyên vật liệu</th>
                <th>số lượng</th>
                <th>đơn vị</th>
                <th>tỷ lệ lãng phí</th>
                <th>chi phí mỗi đơn vị</th>
                <th>tổng chi phí</th>
                <th>Tác vụ</th>
        </tr></thead>
        <tbody>
        <?php 
            $total_cost=0;
            foreach ($bomrecords as $r): 
                $total_cost+=$r->total_cost;
        ?>
            <tr>
                <td><?= h($r->id ?? '') ?></td>
                <td><?= (!empty($r->bom_id))? $r->bom->bom_code:'' ?></td>
                <td><?= (!empty($r->material_id))? $r->product->full_name:'' ?></td>
                <td><?= h($r->quantity ?? '') ?></td>
                <td><?= (!empty($r->unit_id))? $r->unit->name:'' ?></td>
                <td><?= h($r->waste_rate ?? '') ?></td>
                <td style="text-align:right;"><?= Number::format($r->unit_cost ?? '') ?></td>
                <td style="text-align:right;"><?= Number::format($r->total_cost ?? '') ?></td>
                <td>
                    <?= $this->Form->postLink('Xóa', ['action' => 'deletedetail', $r->id], ['confirm' => 'Xóa?', 'class' => 'btn btn-sm btn-danger']) ?>
                    <?= $this->Html->link('Sửa', ['action' => 'editdetail', $r->id], ['class' => 'btn btn-sm btn-warning']) ?>
                </td>
            </tr>
        <?php 
            endforeach; 
        ?>
        <?php 
            if ($total_cost>0) {
        ?>
            <tr>
                <td colspan="7"></td>
                <td style="text-align:right;"><b><?= Number::format($total_cost ?? '') ?></b></td>
                <td></td>
            </tr>
        <?php 
            }
        ?>
        </tbody>
    </table>
    <div class="paginator"><?= $this->Paginator->numbers() ?></div>
</div>
<div class="clearfix bg-light p-3"></div>
<div class="routings index">
    <h3>Routings 
    <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
    <a href="<?= $this->Url->build(['action' => 'exportExcel']) ?>" class="btn btn-success btn-sm float-end me-2"><i class="fa fa-file-excel"></i> Excel</a>
    <a href="<?= $this->Url->build(['action' => 'exportPdf']) ?>" class="btn btn-danger btn-sm float-end me-2"><i class="fa fa-file-pdf"></i> PDF</a></h3>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Mã ID</th>
                <th>sản phẩm</th>
                <th>trình tự vận hành</th>
                <th>trung tâm làm việc</th>
                <th>thời gian thiết lập</th>
                <th>thời gian chạy</th>
                <th>tên thao tác</th>
                <th>chi phí</th>
                <th></th>
        </tr></thead>
        <tbody>
        <?php 
            $cost=0;
            foreach ($routerecords as $r): 
                $cost+=$r->cost;
        ?>
            <tr>
                <td><?= h($r->id ?? '') ?></td>
                <td><?= (!empty($r->product_id))? $r->product->full_name:'' ?></td>
                <td><?= h($r->operation_sequence ?? '') ?></td>
                <td><?= (!empty($r->work_center_id))? $r->work_center->full_name:'' ?></td>
                <td><?= h($r->setup_time ?? '') ?></td>
                <td><?= h($r->run_time ?? '') ?></td>
                <td><?= h($r->operation_name ?? '') ?></td>
                <td><?= Number::format($r->cost ?? '') ?></td>
                <td></td>
            </tr>
        <?php 
            endforeach; 
        ?>
        <?php 
            if ($cost>0) {
        ?>
            <tr>
                <td colspan="7"></td>
                <td><b><?= Number::format($cost ?? '') ?></b></td>
                <td></td>
        <?php 
            }
        ?>
        </tbody>
    </table>
    <div class="paginator"><?= $this->Paginator->numbers() ?></div>
</div>