<?php
        use Cake\I18n\FrozenDate;
        use Cake\I18n\Number;
?>
<div class="goods_receipts form">
    <h3>Sửa GoodsReceipts: <?= h($record->id) ?>
        <?= $this->Html->link('In', ['action' => 'view', $record->id], ['class' => 'btn btn-sm btn-success','target'=>'_new']) ?>
    </h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('gr_number', ['label' => 'Số phiếu nhập', 'class' => 'form-control']) ?>
        <?= $this->Form->control('receipt_date', ['label' => 'Ngày nhận', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('purchase_order_id', ['label' => 'Đơn mua hàng', 'options' => $related['PurchaseOrders'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('supplier_id', ['label' => 'Nhà cung cấp', 'options' => $related['Suppliers'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('warehouse_id', ['label' => 'Warehouse Id', 'options' => $related['Warehouses'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('total_amount', ['label' => 'Tổng tiền', 'class' => 'form-control','OnChange'=>'upd_total_amt();']) ?>
        <?= $this->Form->control('vat_amount', ['label' => 'Vat Amount', 'class' => 'form-control']) ?>
        <?= $this->Form->control('discount_amount', ['label' => 'Số tiền chiết khấu', 'class' => 'form-control','OnChange'=>'upd_total_amt();']) ?>
        <?= $this->Form->control('grand_total', ['label' => 'Tổng cộng', 'class' => 'form-control']) ?>
        <?= $this->Form->control('status', ['label' => 'Trạng thái', 'type' => 'select', 'options' => ['draft' => 'draft', 'approved' => 'approved', 'cancelled' => 'cancelled'], 'class' => 'form-control']) ?>
        <?= $this->Form->control('notes', ['label' => 'Ghi chú', 'type' => 'textarea', 'class' => 'form-control']) ?>
        <?= $this->Form->control('created_by', ['label' => 'Người tạo', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
<div class="clearfix bg-light p-3"></div>
<div class="goods_receipt_details index">
    <h3>GoodsReceiptDetails <a href="<?= $this->Url->build(['action' => 'adddetail',$record->id]) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
    <a href="<?= $this->Url->build(['controller' => 'GoodsReceiptDetails','action' => 'exportExcel']) ?>" class="btn btn-success btn-sm float-end me-2"><i class="fa fa-file-excel"></i> Excel</a>
    <a href="<?= $this->Url->build(['controller' => 'GoodsReceiptDetails','action' => 'exportPdf']) ?>" class="btn btn-danger btn-sm float-end me-2"><i class="fa fa-file-pdf"></i> PDF</a></h3>
    <table class="table table-bordered table-striped">
        <thead><tr>
                <th>Mã ID</th>
                <th>mã nhập kho</th>
                <th>sản phẩm</th>
                <th>số lượng</th>
                <th>đơn vị</th>
                <th>đơn giá</th>
                <th>thành tiền</th>
                <th>thuế suất VAT</th>
                <th>Số tiền thuế GTGT</th>
                <th>MS LOT</th>
                <th>Tác vụ</th>
        </tr></thead>
        <tbody>
        <?php 
            $vat_rate=0;
            foreach ($records as $r): 
                $vat_rate=($r->vat_rate>0 && $vat_rate<=0)? $r->vat_rate:$vat_rate;
        ?>
            <tr>
                <td><?= h($r->id ?? '') ?></td>
                <td><?= (!empty($r->goods_receipt_id))? $r->goods_receipt->full_name:'' ?></td>
                <td><?= (!empty($r->product_id))? $r->product->name.' ('.$r->product->code.')':'' ?></td>
                <td><?= Number::format($r->quantity ?? '') ?></td>
                <td><?= (!empty($r->unit_id))? $r->unit->name:'' ?></td>
                <td><?= Number::format((int)$r->unit_price ?? '') ?></td>
                <td><?= Number::format((int)$r->amount ?? '') ?></td>
                <td><?= h($r->vat_rate ?? '') ?></td>
                <td><?= Number::format((int)$r->vat_amount ?? '') ?></td>
                <td><?= h($r->lot_number ?? '') ?></td>
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
<script>
function upd_total_amt() {
    var vat_rate=<?= $vat_rate ?>;
    var total_amount = parseFloat($('#total-amount').val());
    var discount_amount = parseFloat($('#discount-amount').val());
    var vat_amount = total_amount*(vat_rate/100);
    var grand_total = total_amount + vat_amount - discount_amount;
    $('#vat-amount').val(vat_amount.toFixed(2));
    $('#grand-total').val(grand_total.toFixed(2));
}
</script>