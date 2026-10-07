<?php
        use Cake\I18n\FrozenDate;
        use Cake\I18n\Number;
?>
<div class="sales_invoices form">
    <h3>Sửa SalesInvoices: <?= h($record->id) ?>
        <?= $this->Html->link('In', ['action' => 'view', $record->id], ['class' => 'btn btn-sm btn-success','target'=>'_new']) ?>
    </h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('invoice_number', ['label' => 'Số hóa đơn', 'class' => 'form-control']) ?>
        <?= $this->Form->control('invoice_date', ['label' => 'Ngày hóa đơn', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('customer_id', ['label' => 'Khách hàng', 'options' => $related['Customers'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('delivery_note_id', ['label' => 'Phiếu xuất kho', 'options' => $related['DeliveryNotes'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('total_amount', ['label' => 'Tổng tiền', 'class' => 'form-control','OnChange'=>'upd_total_amt();']) ?>
        <?= $this->Form->control('vat_amount', ['label' => 'Vat Amount', 'class' => 'form-control']) ?>
        <?= $this->Form->control('discount_amount', ['label' => 'Số tiền chiết khấu', 'class' => 'form-control','OnChange'=>'upd_total_amt();']) ?>
        <?= $this->Form->control('grand_total', ['label' => 'Tổng cộng', 'class' => 'form-control']) ?>
        <?= $this->Form->control('payment_due_date', ['label' => 'Hạn thanh toán', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('status', ['label' => 'Trạng thái', 'type' => 'select', 'options' => ['draft' => 'draft', 'approved' => 'approved', 'paid' => 'paid', 'cancelled' => 'cancelled'], 'class' => 'form-control']) ?>
        <?= $this->Form->control('created_by', ['label' => 'Người tạo', 'class' => 'form-control']) ?>
        <?= $this->Form->control('accounting_period_id', ['label' => 'Kỳ kế toán', 'options' => $related['AccountingPeriods'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
<div class="clearfix bg-light p-3"></div>
<div class="sales_invoice_details index">
    <h3>SalesInvoiceDetails <a href="<?= $this->Url->build(['action' => 'adddetail',$record->id]) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
    <a href="<?= $this->Url->build(['controller' => 'SalesInvoiceDetails','action' => 'exportExcel']) ?>" class="btn btn-success btn-sm float-end me-2"><i class="fa fa-file-excel"></i> Excel</a>
    <a href="<?= $this->Url->build(['controller' => 'SalesInvoiceDetails','action' => 'exportPdf']) ?>" class="btn btn-danger btn-sm float-end me-2"><i class="fa fa-file-pdf"></i> PDF</a></h3>
    <table class="table table-bordered table-striped">
        <thead><tr>
                <th>Mã ID</th>
                <th>sales_invoice_id</th>
                <th>mã sản phẩm</th>
                <th>số lượng</th>
                <th>đơn vị</th>
                <th>đơn giá</th>
                <th>thành tiền</th>
                <th>thuế suất VAT</th>
                <th>Số tiền thuế GTGT</th>
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
                <td><?= (!empty($r->sales_invoice_id))? $r->sales_invoice->id.' ('.$r->sales_invoice->invoice_number.')':'' ?></td>
                <td><?= (!empty($r->product_id))? $r->product->name.' ('.$r->product->code.')':'' ?></td>
                <td><?= h($r->quantity ?? '') ?></td>
                <td><?= (!empty($r->unit_id))? $r->unit->name:'' ?></td>
                <td><?= Number::format($r->unit_price ?? '') ?></td>
                <td><?= Number::format($r->amount ?? '') ?></td>
                <td><?= h($r->vat_rate ?? '') ?></td>
                <td><?= Number::format($r->vat_amount ?? '') ?></td>
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