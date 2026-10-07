<div class="stock_transfer_details view">
    <h3>Chi tiết StockTransferDetails: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>stock_transfer</th><td><?= h($record->stock_transfer->full_name ?? '') ?></td></tr>
        <tr><th>sản phẩm</th><td><?= h($record->product->name ?? '') ?></td></tr>
        <tr><th>số lượng</th><td><?= h($record->quantity ?? '') ?></td></tr>
        <tr><th>đơn vị</th><td><?= h($record->unit->name ?? '') ?></td></tr>
        <tr><th>notes</th><td><?= h($record->notes ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
