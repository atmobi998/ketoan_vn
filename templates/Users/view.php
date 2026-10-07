<div class="users view">
    <h3>Chi tiết Users: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>username</th><td><?= h($record->username ?? '') ?></td></tr>
        <tr><th>email</th><td><?= h($record->email ?? '') ?></td></tr>
        <tr><th>password</th><td><?= h($record->password ?? '') ?></td></tr>
        <tr><th>họ và tên</th><td><?= h($record->full_name ?? '') ?></td></tr>
        <tr><th>role</th><td><?= h($record->role ?? '') ?></td></tr>
        <tr><th>department_id</th><td><?= h($record->department_id ?? '') ?></td></tr>
        <tr><th>is_active</th><td><?= h($record->is_active ?? '') ?></td></tr>
        <tr><th>last_login</th><td><?= h($record->last_login ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
