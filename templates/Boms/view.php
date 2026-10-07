<div class="boms view">
    <h3>Chi tiết Boms: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>Mã BOM</th><td><?= h($record->bom_code ?? '') ?></td></tr>
        <tr><th>mã sản phẩm</th><td><?= h($record->product_id ?? '') ?></td></tr>
        <tr><th>phiên bản</th><td><?= h($record->version ?? '') ?></td></tr>
        <tr><th>số lượng sản xuất</th><td><?= h($record->quantity_produced ?? '') ?></td></tr>
        <tr><th>ngày có hiệu lực</th><td><?= h($record->effective_date ?? '') ?></td></tr>
        <tr><th>ngày hết hạn</th><td><?= h($record->expiry_date ?? '') ?></td></tr>
        <tr><th>trạng thái</th><td><?= h($record->status ?? '') ?></td></tr>
        <tr><th>diễn giải</th><td><?= h($record->description ?? '') ?></td></tr>
        <tr><th>created_by</th><td><?= h($record->created_by ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
