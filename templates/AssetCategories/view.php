<div class="asset_categories view">
    <h3>Chi tiết AssetCategories: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>Mã Code</th><td><?= h($record->code ?? '') ?></td></tr>
        <tr><th>Tên</th><td><?= h($record->name ?? '') ?></td></tr>
        <tr><th>Tỷ lệ khấu hao</th><td><?= h($record->depreciation_rate ?? '') ?></td></tr>
        <tr><th>Số tháng hữu ích</th><td><?= h($record->useful_life_months ?? '') ?></td></tr>
        <tr><th>TK Tài sản</th><td><?= h($record->chart_account_asset ?? '') ?></td></tr>
        <tr><th>TK khấu hao</th><td><?= h($record->chart_account_depreciation ?? '') ?></td></tr>
        <tr><th>chart_account_expense</th><td><?= h($record->chart_account_expense ?? '') ?></td></tr>
        <tr><th>diễn giải</th><td><?= h($record->description ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
