<div class="bank_receipts form">
    <h3>Thêm BankReceipts</h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('voucher_number', ['label' => 'Voucher Number', 'class' => 'form-control']) ?>
        <?= $this->Form->control('voucher_date', ['label' => 'Voucher Date', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('accounting_date', ['label' => 'Ngày hạch toán', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('payer_name', ['label' => 'Người nộp tiền', 'class' => 'form-control']) ?>
        <?= $this->Form->control('reason', ['label' => 'Lý do', 'type' => 'textarea', 'class' => 'form-control']) ?>
        <?= $this->Form->control('bank_account_id', ['label' => 'Tài khoản ngân hàng', 'options' => $related['BankAccounts'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('chart_of_account_id', ['label' => 'Tài khoản kế toán', 'options' => $related['ChartOfAccounts'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('currency_id', ['label' => 'Tiền tệ', 'options' => $related['Currencies'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('amount', ['label' => 'Số tiền', 'class' => 'form-control']) ?>
        <?= $this->Form->control('exchange_rate', ['label' => 'Tỷ giá', 'class' => 'form-control']) ?>
        <?= $this->Form->control('amount_vnd', ['label' => 'Số tiền (VND)', 'class' => 'form-control']) ?>
        <?= $this->Form->control('status', ['label' => 'Trạng thái', 'type' => 'select', 'options' => ['draft' => 'draft', 'approved' => 'approved', 'cancelled' => 'cancelled'], 'class' => 'form-control']) ?>
        <?= $this->Form->control('created_by', ['label' => 'Người tạo', 'class' => 'form-control']) ?>
        <?= $this->Form->control('accounting_period_id', ['label' => 'Kỳ kế toán', 'options' => $related['AccountingPeriods'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Lưu', ['class' => 'btn btn-primary']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
