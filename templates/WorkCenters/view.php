<div class="work_centers view">
    <h3>Chi tiết WorkCenters: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>Mã Code</th><td><?= h($record->code ?? '') ?></td></tr>
        <tr><th>Tên</th><td><?= h($record->name ?? '') ?></td></tr>
        <tr><th>chi phí mỗi giờ</th><td><?= h($record->cost_per_hour ?? '') ?></td></tr>
        <tr><th>Công suất</th><td><?= h($record->capacity ?? '') ?></td></tr>
        <tr><th>department_id</th><td><?= h($record->department_id ?? '') ?></td></tr>
        <tr><th>diễn giải</th><td><?= h($record->description ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
