<div class="asset_depreciations view">
    <h3>Chi tiết AssetDepreciations: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>fixed_asset_id</th><td><?= h($record->fixed_asset_id ?? '') ?></td></tr>
        <tr><th>Ngày khấu hao</th><td><?= h($record->depreciation_date ?? '') ?></td></tr>
        <tr><th>Kỳ</th><td><?= h($record->period ?? '') ?></td></tr>
        <tr><th>giá trị khấu hao</th><td><?= h($record->depreciation_amount ?? '') ?></td></tr>
        <tr><th>khấu hao lũy kế</th><td><?= h($record->accumulated_depreciation ?? '') ?></td></tr>
        <tr><th>giá trị còn lại</th><td><?= h($record->remaining_value ?? '') ?></td></tr>
        <tr><th>accounting_period_id</th><td><?= h($record->accounting_period_id ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
