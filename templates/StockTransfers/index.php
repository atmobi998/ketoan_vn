<div class="stock_transfers index">
    <h3>StockTransfers <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
    <a href="<?= $this->Url->build(['action' => 'exportExcel']) ?>" class="btn btn-success btn-sm float-end me-2"><i class="fa fa-file-excel"></i> Excel</a>
    <a href="<?= $this->Url->build(['action' => 'exportPdf']) ?>" class="btn btn-danger btn-sm float-end me-2"><i class="fa fa-file-pdf"></i> PDF</a></h3>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <td colspan="8">
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
                <th>Mã số chuyển</th>
                <th>từ kho</th>
                <th>đến kho</th>
                <th>ngày chuyển</th>
                <th>Trạng thái</th>
                <th>notes</th>
                <th>Tác vụ</th>
        </tr></thead>
        <tbody>
        <?php foreach ($records as $r): ?>
            <tr>
                <td><?= h($r->id ?? '') ?></td>
                <td><?= h($r->transfer_number ?? '') ?></td>
                <td><?= (!empty($r->from_warehouse_id))? $related['FromWarehouses'][$r->from_warehouse_id]:'' ?></td>
                <td><?= (!empty($r->to_warehouse_id))? $related['ToWarehouses'][$r->to_warehouse_id]:'' ?></td>
                <td><?= h($r->transfer_date ?? '') ?></td>
                <td><?= h($r->status ?? '') ?></td>
                <td><?= h($r->notes ?? '') ?></td>
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
    window.location.href = '/stock-transfers?from_period='+$('#from-period').val()+'&to_period='+$('#to-period').val()+'&time='+$.now();
}
function to_period_chg() {
    window.location.href = '/stock-transfers?from_period='+$('#from-period').val()+'&to_period='+$('#to-period').val()+'&time='+$.now();
}
</script>