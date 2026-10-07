<div class="attendances view">
    <h3>Chi tiết Attendances: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>employee_id</th><td><?= h($record->employee_id ?? '') ?></td></tr>
        <tr><th>ngày làm việc</th><td><?= h($record->work_date ?? '') ?></td></tr>
        <tr><th>đăng ký vào</th><td><?= h($record->check_in ?? '') ?></td></tr>
        <tr><th>đăng ký ra</th><td><?= h($record->check_out ?? '') ?></td></tr>
        <tr><th>số giờ làm việc</th><td><?= h($record->work_hours ?? '') ?></td></tr>
        <tr><th>số giờ làm thêm</th><td><?= h($record->overtime_hours ?? '') ?></td></tr>
        <tr><th>Trạng thái</th><td><?= h($record->status ?? '') ?></td></tr>
        <tr><th>notes</th><td><?= h($record->notes ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
