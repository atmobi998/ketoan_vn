<div class="customers form">
    <h3>Sửa Customers: <?= h($record->id) ?></h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('code', ['label' => 'Mã', 'class' => 'form-control']) ?>
        <?= $this->Form->control('name', ['label' => 'Tên', 'class' => 'form-control']) ?>
        <?= $this->Form->control('tax_code', ['label' => 'Mã thuế', 'class' => 'form-control']) ?>
        <?= $this->Form->control('address', ['label' => 'Địa chỉ', 'type' => 'textarea', 'class' => 'form-control']) ?>
        <?= $this->Form->control('phone', ['label' => 'Điện thoại', 'class' => 'form-control']) ?>
        <?= $this->Form->control('email', ['label' => 'Email', 'class' => 'form-control']) ?>
        <?= $this->Form->control('contact_person', ['label' => 'Người liên hệ', 'class' => 'form-control']) ?>
        <?= $this->Form->control('chart_of_account_id', ['label' => 'Tài khoản kế toán', 'options' => $related['ChartOfAccounts'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('debt_account', ['label' => 'Tài khoản công nợ', 'class' => 'form-control']) ?>
        <?= $this->Form->control('is_active', ['label' => 'Kích hoạt', 'type' => 'checkbox']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
