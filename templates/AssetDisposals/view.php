<div class="asset_disposals view">
    <h3>Chi tiết AssetDisposals: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>fixed_asset_id</th><td><?= h($record->fixed_asset_id ?? '') ?></td></tr>
        <tr><th>ngày thanh lý</th><td><?= h($record->disposal_date ?? '') ?></td></tr>
        <tr><th>phương pháp xử lý</th><td><?= h($record->disposal_method ?? '') ?></td></tr>
        <tr><th>số tiền thanh lý</th><td><?= h($record->disposal_amount ?? '') ?></td></tr>
        <tr><th>lỗ_lãi</th><td><?= h($record->loss_gain ?? '') ?></td></tr>
        <tr><th>lý do</th><td><?= h($record->reason ?? '') ?></td></tr>
        <tr><th>created_by</th><td><?= h($record->created_by ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
