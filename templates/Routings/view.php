<div class="routings view">
    <h3>Chi tiết Routings: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>mã sản phẩm</th><td><?= h($record->product_id ?? '') ?></td></tr>
        <tr><th>trình tự vận hành</th><td><?= h($record->operation_sequence ?? '') ?></td></tr>
        <tr><th>work_center_id</th><td><?= h($record->work_center_id ?? '') ?></td></tr>
        <tr><th>thời gian thiết lập</th><td><?= h($record->setup_time ?? '') ?></td></tr>
        <tr><th>thời gian chạy</th><td><?= h($record->run_time ?? '') ?></td></tr>
        <tr><th>tên thao tác</th><td><?= h($record->operation_name ?? '') ?></td></tr>
        <tr><th>diễn giải</th><td><?= h($record->description ?? '') ?></td></tr>
        <tr><th>chi phí</th><td><?= h($record->cost ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
