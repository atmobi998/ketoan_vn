<?php
        use Cake\I18n\FrozenDate;
        use Cake\I18n\Number;
?>
<div class="asset_depreciations index">
    <h3>AssetDepreciations <a href="<?= $this->Url->build(['action' => 'add',$fixed_asset_id]) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
    <a href="<?= $this->Url->build(['action' => 'exportExcel']) ?>" class="btn btn-success btn-sm float-end me-2"><i class="fa fa-file-excel"></i> Excel</a>
    <a href="<?= $this->Url->build(['action' => 'exportPdf']) ?>" class="btn btn-danger btn-sm float-end me-2"><i class="fa fa-file-pdf"></i> PDF</a></h3>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <td colspan="7">
<?php
        echo $this->Form->control('fixed_asset_id', ['options' => $options ?? [], 'value' => $fixed_asset_id, 'label' => 'Product', 'empty' => '-- Chọn --', 'OnChange' => 'fixed_asset_chg();', 'class' => 'form-control']);
?>
                </td>
            </tr>
            <tr>
                <th>TSCĐ</th>
                <th>Ngày khấu hao</th>
                <th>Kỳ</th>
                <th>giá trị khấu hao</th>
                <th>khấu hao lũy kế</th>
                <th>giá trị còn lại</th>
                <th>kỳ kế toán</th>
                <th>Tác vụ</th>
        </tr></thead>
        <tbody>
        <?php foreach ($records as $r): ?>
            <tr>
                <td><?= (!empty($r->fixed_asset_id))? $r->fixed_asset->full_name:'' ?></td>
                <td><?= h($r->depreciation_date ?? '') ?></td>
                <td><?= h($r->period ?? '') ?></td>
                <td><?= Number::format($r->depreciation_amount ?? '') ?></td>
                <td><?= Number::format($r->accumulated_depreciation ?? '') ?></td>
                <td><?= Number::format($r->remaining_value ?? '') ?></td>
                <td><?= (!empty($r->accounting_period_id))? $r->accounting_period->full_name:'' ?></td>
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
function fixed_asset_chg() {
    window.location.href = '/asset_depreciations?fixed_asset_id='+$('#fixed-asset-id').val()+'&time='+$.now();
}
</script>
