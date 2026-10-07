<?php
        use Cake\I18n\FrozenDate;
        use Cake\I18n\Number;
?>
<div class="stock_adjustments form">
    <h3>Sửa StockAdjustments: <?= h($record->id) ?></h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('adjustment_number', ['label' => 'Số phiếu điều chỉnh', 'class' => 'form-control']) ?>
        <?= $this->Form->control('adjustment_date', ['label' => 'Ngày điều chỉnh', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('warehouse_id', ['label' => 'Warehouse Id', 'options' => $related['Warehouses'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('adjustment_type', ['label' => 'Loại điều chỉnh', 'type' => 'select', 'options' => ['increase' => 'increase', 'decrease' => 'decrease'], 'class' => 'form-control']) ?>
        <?= $this->Form->control('reason', ['label' => 'Lý do', 'type' => 'textarea', 'class' => 'form-control']) ?>
        <?= $this->Form->control('total_amount', ['label' => 'Tổng tiền', 'class' => 'form-control']) ?>
        <?= $this->Form->control('status', ['label' => 'Trạng thái', 'type' => 'select', 'options' => ['draft' => 'draft', 'approved' => 'approved', 'cancelled' => 'cancelled'], 'class' => 'form-control']) ?>
        <?= $this->Form->control('created_by', ['label' => 'Người tạo', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
<div class="clearfix bg-light p-3"></div>
<div class="stock_adjustment_details index">
    <h3>StockAdjustmentDetails <a href="<?= $this->Url->build(['action' => 'adddetail',$record->id]) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
    <a href="<?= $this->Url->build(['controller' => 'StockAdjustmentDetails','action' => 'exportExcel']) ?>" class="btn btn-success btn-sm float-end me-2"><i class="fa fa-file-excel"></i> Excel</a>
    <a href="<?= $this->Url->build(['controller' => 'StockAdjustmentDetails','action' => 'exportPdf']) ?>" class="btn btn-danger btn-sm float-end me-2"><i class="fa fa-file-pdf"></i> PDF</a></h3>
    <table class="table table-bordered table-striped">
        <thead><tr>
                <th>Mã ID</th>
                <th>stock_adjustment</th>
                <th>sản phẩm</th>
                <th>quantity_system</th>
                <th>quantity_actual</th>
                <th>quantity_diff</th>
                <th>đơn giá</th>
                <th>Tác vụ</th>
        </tr></thead>
        <tbody>
        <?php foreach ($records as $r): ?>
            <tr>
                <td><?= h($r->id ?? '') ?></td>
                <td><?= (!empty($r->stock_adjustment_id))? $r->stock_adjustment->full_name:'' ?></td>
                <td><?= (!empty($r->product_id))? $r->product->name.' ('.$r->product->code.')':'' ?></td>
                <td><?= h($r->quantity_system ?? '') ?></td>
                <td><?= h($r->quantity_actual ?? '') ?></td>
                <td><?= h($r->quantity_diff ?? '') ?></td>
                <td><?= Number::format($r->unit_price ?? '') ?></td>
                <td>
                    <?= $this->Form->postLink('Xóa', ['action' => 'deletedetail', $r->id], ['confirm' => 'Xóa?', 'class' => 'btn btn-sm btn-danger']) ?>
                    <?= $this->Html->link('Sửa', ['action' => 'editdetail', $r->id], ['class' => 'btn btn-sm btn-warning']) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator"><?= $this->Paginator->numbers() ?></div>
</div>
