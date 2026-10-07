<div class="fixed_assets view">
    <h3>Chi tiết FixedAssets: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>Mã Code</th><td><?= h($record->code ?? '') ?></td></tr>
        <tr><th>Tên</th><td><?= h($record->name ?? '') ?></td></tr>
        <tr><th>asset_category_id</th><td><?= h($record->asset_category_id ?? '') ?></td></tr>
        <tr><th>ngày mua lại</th><td><?= h($record->acquisition_date ?? '') ?></td></tr>
        <tr><th>chi phí ban đầu</th><td><?= h($record->original_cost ?? '') ?></td></tr>
        <tr><th>tuổi thọ hữu ích</th><td><?= h($record->useful_life ?? '') ?></td></tr>
        <tr><th>phương pháp khấu hao</th><td><?= h($record->depreciation_method ?? '') ?></td></tr>
        <tr><th>khấu hao lũy kế</th><td><?= h($record->accumulated_depreciation ?? '') ?></td></tr>
        <tr><th>giá trị còn lại</th><td><?= h($record->remaining_value ?? '') ?></td></tr>
        <tr><th>location</th><td><?= h($record->location ?? '') ?></td></tr>
        <tr><th>Trạng thái</th><td><?= h($record->status ?? '') ?></td></tr>
        <tr><th>employee_id</th><td><?= h($record->employee_id ?? '') ?></td></tr>
        <tr><th>department_id</th><td><?= h($record->department_id ?? '') ?></td></tr>
        <tr><th>Tài khoản KT</th><td><?= h($record->chart_of_account_id ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
