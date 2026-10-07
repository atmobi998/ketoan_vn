<div class="chart_of_accounts form">
    <h3>Sửa ChartOfAccounts: <?= h($record->id) ?></h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('code', ['label' => 'Mã', 'class' => 'form-control']) ?>
        <?= $this->Form->control('name', ['label' => 'Tên', 'class' => 'form-control']) ?>
        <?= $this->Form->control('account_type', ['label' => 'Loại tài khoản', 'type' => 'select', 'options' => ['asset' => 'Tài sản', 'liability' => 'Nợ phải trả', 'equity' => 'Vốn chủ sở hữu', 'revenue' => 'Doanh thu', 'expense' => 'Chi phí'], 'class' => 'form-control']) ?>
        <?= $this->Form->control('parent_id', ['label' => 'Tài khoản cha', 'options' => $related['Parents'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('is_detail', ['label' => 'Là chi tiết', 'type' => 'checkbox']) ?>
        <?= $this->Form->control('balance_type', ['label' => 'Loại số dư', 'type' => 'select', 'options' => ['debit' => 'Dư Nợ', 'credit' => 'Dư Có'], 'class' => 'form-control']) ?>
        <?= $this->Form->control('description', ['label' => 'Diễn giải', 'type' => 'textarea', 'class' => 'form-control']) ?>
        <?= $this->Form->control('is_active', ['label' => 'Kích hoạt', 'type' => 'checkbox']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
