<div class="purchase_order_details view">
    <h3>Chi tiết PurchaseOrderDetails: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>ID đơn đặt hàng</th><td><?= h($record->purchase_order_id ?? '') ?></td></tr>
        <tr><th>mã sản phẩm</th><td><?= h($record->product_id ?? '') ?></td></tr>
        <tr><th>số lượng</th><td><?= h($record->quantity ?? '') ?></td></tr>
        <tr><th>unit_id</th><td><?= h($record->unit_id ?? '') ?></td></tr>
        <tr><th>đơn giá</th><td><?= h($record->unit_price ?? '') ?></td></tr>
        <tr><th>số lượng</th><td><?= h($record->amount ?? '') ?></td></tr>
        <tr><th>thuế suất VAT</th><td><?= h($record->vat_rate ?? '') ?></td></tr>
        <tr><th>Số tiền thuế GTGT</th><td><?= h($record->vat_amount ?? '') ?></td></tr>
        <tr><th>diễn giải</th><td><?= h($record->description ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
