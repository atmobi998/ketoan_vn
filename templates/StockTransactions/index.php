<div class="stock_transactions index">
    <h3>StockTransactions <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
    <a href="<?= $this->Url->build(['action' => 'exportExcel']) ?>" class="btn btn-success btn-sm float-end me-2"><i class="fa fa-file-excel"></i> Excel</a>
    <a href="<?= $this->Url->build(['action' => 'exportPdf']) ?>" class="btn btn-danger btn-sm float-end me-2"><i class="fa fa-file-pdf"></i> PDF</a></h3>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <td colspan="10">
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
                <th>số giao dịch</th>
                <th>ngày giao dịch</th>
                <th>loại giao dịch</th>
                <th>kho</th>
                <th>kho đích</th>
                <th>sản phẩm</th>
                <th>số lượng</th>
                <th>đơn vị</th>
                <th>Tác vụ</th>
        </tr></thead>
        <tbody>
        <?php foreach ($records as $r): ?>
            <tr>
                <td><?= h($r->id ?? '') ?></td>
                <td><?= h($r->transaction_number ?? '') ?></td>
                <td><?= h($r->transaction_date ?? '') ?></td>
                <td><?= h($r->transaction_type ?? '') ?></td>
                <td><?= (!empty($r->warehouse_id))? $r->warehouse->name.' ('.$r->warehouse->code.')':'' ?></td>
                <td><?= (!empty($r->warehouse_to_id))? $related['ToWarehouses'][$r->warehouse_to_id]:'' ?></td>
                <td><?= (!empty($r->product_id))? $r->product->name.' ('.$r->product->code.')':'' ?></td>
                <td><?= (!empty($r->quantity))? $r->quantity.' '.$r->unit->name:'' ?></td>
                <td><?= (!empty($r->unit_id))? $r->unit->name:'' ?></td>
                <td>
                    <?= $this->Form->postLink('Xóa', ['action' => 'delete', $r->id], ['confirm' => 'Xóa?', 'class' => 'btn btn-sm btn-danger']) ?>
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
    window.location.href = '/stock_transactions?from_period='+$('#from-period').val()+'&to_period='+$('#to-period').val()+'&time='+$.now();
}
function to_period_chg() {
    window.location.href = '/stock_transactions?from_period='+$('#from-period').val()+'&to_period='+$('#to-period').val()+'&time='+$.now();
}
</script>