<div class="bank_accounts form">
    <h3>Sửa BankAccounts: <?= h($record->id) ?></h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('account_number', ['label' => 'Số tài khoản', 'class' => 'form-control']) ?>
        <?= $this->Form->control('bank_name', ['label' => 'Tên ngân hàng', 'class' => 'form-control']) ?>
        <?= $this->Form->control('branch', ['label' => 'Chi nhánh', 'class' => 'form-control']) ?>
        <?= $this->Form->control('currency_id', ['label' => 'Tiền tệ', 'options' => $related['Currencies'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('chart_of_account_id', ['label' => 'Tài khoản kế toán', 'options' => $related['ChartOfAccounts'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('balance', ['label' => 'Số dư', 'class' => 'form-control']) ?>
        <?= $this->Form->control('is_active', ['label' => 'Kích hoạt', 'type' => 'checkbox']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
