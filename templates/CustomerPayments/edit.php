<div class="customer_payments form">
    <h3>Sửa CustomerPayments: <?= h($record->id) ?></h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('payment_number', ['label' => 'Số phiếu thanh toán', 'class' => 'form-control']) ?>
        <?= $this->Form->control('payment_date', ['label' => 'Ngày thanh toán', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('customer_id', ['label' => 'Khách hàng', 'options' => $related['Customers'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('amount', ['label' => 'Số tiền', 'class' => 'form-control']) ?>
        <?= $this->Form->control('bank_account_id', ['label' => 'Tài khoản ngân hàng', 'options' => $related['BankAccounts'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('payment_method', ['label' => 'Phương thức thanh toán', 'type' => 'select', 'options' => ['cash' => 'cash', 'bank' => 'bank', 'transfer' => 'transfer'], 'class' => 'form-control']) ?>
        <?= $this->Form->control('reference', ['label' => 'Tham chiếu', 'class' => 'form-control']) ?>
        <?= $this->Form->control('notes', ['label' => 'Ghi chú', 'type' => 'textarea', 'class' => 'form-control']) ?>
        <?= $this->Form->control('created_by', ['label' => 'Người tạo', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
