<div class="customer_debts view">
    <h3>Chi tiết CustomerDebts: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>customer_id</th><td><?= h($record->customer_id ?? '') ?></td></tr>
        <tr><th>loại chứng từ</th><td><?= h($record->document_type ?? '') ?></td></tr>
        <tr><th>ID chứng từ</th><td><?= h($record->document_id ?? '') ?></td></tr>
        <tr><th>số chứng từ</th><td><?= h($record->document_number ?? '') ?></td></tr>
        <tr><th>ngày chứng từ</th><td><?= h($record->document_date ?? '') ?></td></tr>
        <tr><th>ngày đến hạn</th><td><?= h($record->due_date ?? '') ?></td></tr>
        <tr><th>số lượng</th><td><?= h($record->amount ?? '') ?></td></tr>
        <tr><th>số tiền đã thanh toán</th><td><?= h($record->paid_amount ?? '') ?></td></tr>
        <tr><th>số tiền còn lại</th><td><?= h($record->remaining_amount ?? '') ?></td></tr>
        <tr><th>trạng thái</th><td><?= h($record->status ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
