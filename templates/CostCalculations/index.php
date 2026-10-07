<div class="cost_calculations index">
    <h3>CostCalculations <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
    <a href="<?= $this->Url->build(['action' => 'exportExcel']) ?>" class="btn btn-success btn-sm float-end me-2"><i class="fa fa-file-excel"></i> Excel</a>
    <a href="<?= $this->Url->build(['action' => 'exportPdf']) ?>" class="btn btn-danger btn-sm float-end me-2"><i class="fa fa-file-pdf"></i> PDF</a></h3>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <td colspan="9">
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
                <th>mã tính toán</th>
                <th>Mã lệnh sản xuất</th>
                <th>chi phí vật liệu</th>
                <th>chi phí nhân công</th>
                <th>chi phí chung</th>
                <th>tổng chi phí</th>
                <th>số đơn vị</th>
                <th>chi phí mỗi đơn vị</th>
                <th>Tác vụ</th>
        </tr></thead>
        <tbody>
        <?php foreach ($records as $r): ?>
            <tr>
                <td><?= h($r->id ?? '') ?></td>
                <td><?= h($r->calculation_code ?? '') ?></td>
                <td><?= (!empty($r->production_order_id))? $r->production_order->full_name:'' ?></td>
                <td><?= Number::format((int)$r->material_cost ?? '') ?></td>
                <td><?= Number::format((int)$r->labor_cost ?? '') ?></td>
                <td><?= Number::format((int)$r->overhead_cost ?? '') ?></td>
                <td><?= Number::format((int)$r->total_cost ?? '') ?></td>
                <td><?= Number::format((int)$r->units ?? '') ?></td>
                <td><b><?= Number::format((int)$r->unit_cost ?? '') ?></b></td>
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
    window.location.href = '/cost-calculations?from_period='+$('#from-period').val()+'&to_period='+$('#to-period').val()+'&time='+$.now();
}
function to_period_chg() {
    window.location.href = '/cost-calculations?from_period='+$('#from-period').val()+'&to_period='+$('#to-period').val()+'&time='+$.now();
}
</script>
