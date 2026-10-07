<div class="goods_receipts index">
    <h3>GoodsReceipts <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
    <a href="<?= $this->Url->build(['action' => 'exportExcel']) ?>" class="btn btn-success btn-sm float-end me-2"><i class="fa fa-file-excel"></i> Excel</a>
    <a href="<?= $this->Url->build(['action' => 'exportPdf']) ?>" class="btn btn-danger btn-sm float-end me-2"><i class="fa fa-file-pdf"></i> PDF</a></h3>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <td colspan="11">
<?php
        use Cake\I18n\FrozenDate;
        use Cake\I18n\Number;
        $start = FrozenDate::today();
        $end = FrozenDate::today()->subDays(365);

        echo $this->Form->control('from_period', ['options' => $options ?? [], 'value' => $from_period, 'label' => 'From Period', 'empty' => '-- Chọn --', 'OnChange' => 'from_period_chg();', 'class' => 'form-control']);
        echo $this->Form->control('to_period', ['options' => $options ?? [], 'value' => $to_period, 'label' => 'To Period', 'empty' => '-- Chọn --', 'OnChange' => 'to_period_chg();', 'class' => 'form-control']);
?>
                </td>
            </tr>
            <tr>
                <th>Mã ID</th>
                <th>gr_number</th>
                <th>receipt_date</th>
                <th>ID đơn đặt hàng</th>
                <th>NCC</th>
                <th>kho</th>
                <th>tổng số tiền</th>
                <th>Số tiền thuế GTGT</th>
                <th>số tiền giảm giá</th>
                <th>Tổng cộng chung</th>
                <th>Tác vụ</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($records as $r): ?>
            <tr>
                <td><?= h($r->id ?? '') ?></td>
                <td><?= h($r->gr_number ?? '') ?></td>
                <td><?= h($r->receipt_date ?? '') ?></td>
                <td><?= (!empty($r->purchase_order_id))? $r->purchase_order->id.' ('.$r->purchase_order->po_number.')':'' ?></td>
                <td><?= (!empty($r->supplier_id))? $r->supplier->name.' ('.$r->supplier->code.')':'' ?></td>
                <td><?= (!empty($r->warehouse_id))? $r->warehouse->name.' ('.$r->warehouse->code.')':'' ?></td>
                <td><?= Number::format((int)$r->total_amount ?? '') ?></td>
                <td><?= Number::format((int)$r->vat_amount ?? '') ?></td>
                <td><?= Number::format((int)$r->discount_amount ?? '') ?></td>
                <td><?= Number::format((int)$r->grand_total ?? '') ?></td>
                <td>
                    <?= $this->Form->postLink('Xóa', ['action' => 'delete', $r->id], ['confirm' => 'Xóa?', 'class' => 'btn btn-sm btn-danger']) ?>
                    <?= $this->Html->link('In', ['action' => 'view', $r->id], ['class' => 'btn btn-sm btn-success','target'=>'_new']) ?>
                    <?= $this->Html->link('Sửa', ['action' => 'edit', $r->id], ['class' => 'btn btn-sm btn-warning']) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator"><?= $this->Paginator->numbers() ?></div>
</div>
<script>
function from_period_chg() {
    window.location.href = '/goods-receipts?from_period='+$('#from-period').val()+'&to_period='+$('#to-period').val()+'&time='+$.now();
}
function to_period_chg() {
    window.location.href = '/goods-receipts?from_period='+$('#from-period').val()+'&to_period='+$('#to-period').val()+'&time='+$.now();
}
</script>
