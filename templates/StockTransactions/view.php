<div class="stock_transactions view">
    <h3>Chi tiết StockTransactions: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>số giao dịch</th><td><?= h($record->transaction_number ?? '') ?></td></tr>
        <tr><th>ngày giao dịch</th><td><?= h($record->transaction_date ?? '') ?></td></tr>
        <tr><th>loại giao dịch</th><td><?= h($record->transaction_type ?? '') ?></td></tr>
        <tr><th>warehouse_id</th><td><?= h($record->warehouse_id ?? '') ?></td></tr>
        <tr><th>warehouse_to_id</th><td><?= h($record->warehouse_to_id ?? '') ?></td></tr>
        <tr><th>mã sản phẩm</th><td><?= h($record->product_id ?? '') ?></td></tr>
        <tr><th>thành tiền</th><td><?= h($record->quantity ?? '') ?></td></tr>
        <tr><th>đơn giá</th><td><?= h($record->unit_price ?? '') ?></td></tr>
        <tr><th>tổng số tiền</th><td><?= h($record->total_amount ?? '') ?></td></tr>
        <tr><th>loại tham chiếu</th><td><?= h($record->reference_type ?? '') ?></td></tr>
        <tr><th>reference_id</th><td><?= h($record->reference_id ?? '') ?></td></tr>
        <tr><th>notes</th><td><?= h($record->notes ?? '') ?></td></tr>
        <tr><th>created_by</th><td><?= h($record->created_by ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
