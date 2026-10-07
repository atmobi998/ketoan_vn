<div class="fixed_assets form">
    <h3>Sửa FixedAssets: <?= h($record->id) ?></h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('code', ['label' => 'Mã', 'class' => 'form-control']) ?>
        <?= $this->Form->control('name', ['label' => 'Tên', 'class' => 'form-control']) ?>
        <?= $this->Form->control('asset_category_id', ['label' => 'Loại tài sản', 'options' => $related['AssetCategories'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('acquisition_date', ['label' => 'Ngày mua', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('original_cost', ['label' => 'Nguyên giá', 'class' => 'form-control']) ?>
        <?= $this->Form->control('useful_life', ['label' => 'Useful Life', 'class' => 'form-control']) ?>
        <?= $this->Form->control('depreciation_method', ['label' => 'Phương pháp khấu hao', 'type' => 'select', 'options' => ['straight_line' => 'straight_line', 'declining' => 'declining', 'units' => 'units'], 'class' => 'form-control']) ?>
        <?= $this->Form->control('accumulated_depreciation', ['label' => 'Hao mòn lũy kế', 'class' => 'form-control']) ?>
        <?= $this->Form->control('remaining_value', ['label' => 'Giá trị còn lại', 'class' => 'form-control']) ?>
        <?= $this->Form->control('location', ['label' => 'Vị trí', 'class' => 'form-control']) ?>
        <?= $this->Form->control('status', ['label' => 'Trạng thái', 'type' => 'select', 'options' => ['in_use' => 'in_use', 'disposed' => 'disposed', 'maintenance' => 'maintenance'], 'class' => 'form-control']) ?>
        <?= $this->Form->control('employee_id', ['label' => 'Nhân viên', 'options' => $related['Employees'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('department_id', ['label' => 'Phòng ban', 'options' => $related['Departments'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('chart_of_account_id', ['label' => 'Tài khoản kế toán', 'options' => $related['ChartOfAccounts'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
