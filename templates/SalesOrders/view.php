<div class="sales_orders view">
    <h3>Chi tiết SalesOrders: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>số đơn đặt hàng</th><td><?= h($record->so_number ?? '') ?></td></tr>
        <tr><th>ngày đặt hàng</th><td><?= h($record->order_date ?? '') ?></td></tr>
        <tr><th>customer_id</th><td><?= h($record->customer_id ?? '') ?></td></tr>
        <tr><th>currency_id</th><td><?= h($record->currency_id ?? '') ?></td></tr>
        <tr><th>tổng số tiền</th><td><?= h($record->total_amount ?? '') ?></td></tr>
        <tr><th>Số tiền thuế GTGT</th><td><?= h($record->vat_amount ?? '') ?></td></tr>
        <tr><th>số tiền giảm giá</th><td><?= h($record->discount_amount ?? '') ?></td></tr>
        <tr><th>Tổng cộng chung</th><td><?= h($record->grand_total ?? '') ?></td></tr>
        <tr><th>trạng thái</th><td><?= h($record->status ?? '') ?></td></tr>
        <tr><th>notes</th><td><?= h($record->notes ?? '') ?></td></tr>
        <tr><th>created_by</th><td><?= h($record->created_by ?? '') ?></td></tr>
        <tr><th>accounting_period_id</th><td><?= h($record->accounting_period_id ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
