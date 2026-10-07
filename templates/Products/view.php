<div class="products view">
    <h3>Chi tiết Products: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>Mã Code</th><td><?= h($record->code ?? '') ?></td></tr>
        <tr><th>Tên</th><td><?= h($record->name ?? '') ?></td></tr>
        <tr><th>product_category_id</th><td><?= h($record->product_category_id ?? '') ?></td></tr>
        <tr><th>unit_id</th><td><?= h($record->unit_id ?? '') ?></td></tr>
        <tr><th>diễn giải</th><td><?= h($record->description ?? '') ?></td></tr>
        <tr><th>giá mua</th><td><?= h($record->price_buy ?? '') ?></td></tr>
        <tr><th>price_sell</th><td><?= h($record->price_sell ?? '') ?></td></tr>
        <tr><th>thuế suất VAT</th><td><?= h($record->vat_rate ?? '') ?></td></tr>
        <tr><th>stock_min</th><td><?= h($record->stock_min ?? '') ?></td></tr>
        <tr><th>stock_max</th><td><?= h($record->stock_max ?? '') ?></td></tr>
        <tr><th>image</th><td><?= h($record->image ?? '') ?></td></tr>
        <tr><th>is_active</th><td><?= h($record->is_active ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
