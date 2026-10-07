<div class="journal_entry_lines form">
    <h3>Sửa JournalEntryLines: <?= h($record->id) ?></h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('journal_entry_id', ['label' => 'Bút toán', 'options' => $related['JournalEntries'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('chart_of_account_id', ['label' => 'Tài khoản kế toán', 'options' => $related['ChartOfAccounts'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('debit', ['label' => 'Nợ', 'class' => 'form-control']) ?>
        <?= $this->Form->control('credit', ['label' => 'Có', 'class' => 'form-control']) ?>
        <?= $this->Form->control('description', ['label' => 'Diễn giải', 'class' => 'form-control']) ?>
        <?= $this->Form->control('cost_center_id', ['label' => 'Trung tâm chi phí', 'options' => $related['CostCenters'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('customer_id', ['label' => 'Khách hàng', 'options' => $related['Customers'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('supplier_id', ['label' => 'Nhà cung cấp', 'options' => $related['Suppliers'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('product_id', ['label' => 'Sản phẩm', 'options' => $related['Products'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('employee_id', ['label' => 'Nhân viên', 'options' => $related['Employees'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>

    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
