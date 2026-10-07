<?php
        use Cake\I18n\FrozenDate;
        use Cake\I18n\Number;
?>
<div class="cash_payments form">
    <h3>Sửa CashPayments: <?= h($record->id) ?></h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('voucher_number', ['label' => 'Voucher Number', 'class' => 'form-control']) ?>
        <?= $this->Form->control('voucher_date', ['label' => 'Voucher Date', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('accounting_date', ['label' => 'Ngày hạch toán', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('payee_name', ['label' => 'Người nhận tiền', 'class' => 'form-control']) ?>
        <?= $this->Form->control('reason', ['label' => 'Lý do', 'type' => 'textarea', 'class' => 'form-control']) ?>
        <?= $this->Form->control('chart_of_account_id', ['label' => 'Tài khoản kế toán', 'options' => $related['ChartOfAccounts'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('bank_account_id', ['label' => 'Tài khoản ngân hàng', 'options' => $related['BankAccounts'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('currency_id', ['label' => 'Tiền tệ', 'options' => $related['Currencies'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('amount', ['label' => 'Số tiền', 'class' => 'form-control']) ?>
        <?= $this->Form->control('exchange_rate', ['label' => 'Tỷ giá', 'class' => 'form-control']) ?>
        <?= $this->Form->control('amount_vnd', ['label' => 'Số tiền (VND)', 'class' => 'form-control']) ?>
        <?= $this->Form->control('status', ['label' => 'Trạng thái', 'type' => 'select', 'options' => ['draft' => 'draft', 'approved' => 'approved', 'cancelled' => 'cancelled'], 'class' => 'form-control']) ?>
        <?= $this->Form->control('created_by', ['label' => 'Người tạo', 'class' => 'form-control']) ?>
        <?= $this->Form->control('accounting_period_id', ['label' => 'Kỳ kế toán', 'options' => $related['AccountingPeriods'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
<div class="clearfix bg-light p-3"></div>
<div class="cash_payment_details index">
    <h3>CashPaymentDetails <a href="<?= $this->Url->build(['action' => 'adddetail',$record->id]) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
    <a href="<?= $this->Url->build(['controller' => 'CashPaymentDetails','action' => 'exportExcel']) ?>" class="btn btn-success btn-sm float-end me-2"><i class="fa fa-file-excel"></i> Excel</a>
    <a href="<?= $this->Url->build(['controller' => 'CashPaymentDetails','action' => 'exportPdf']) ?>" class="btn btn-danger btn-sm float-end me-2"><i class="fa fa-file-pdf"></i> PDF</a></h3>
    <table class="table table-bordered table-striped">
        <thead><tr>
                <th>Mã ID</th>
                <th>cash_payment</th>
                <th>diễn giải</th>
                <th>Tài khoản KT</th>
                <th>thành tiền</th>
                <th>cost_center</th>
                <th>TGian Tạo</th>
                <th>Tác vụ</th>
        </tr></thead>
        <tbody>
        <?php foreach ($records as $r): ?>
            <tr>
                <td><?= h($r->id ?? '') ?></td>
                <td><?= (!empty($r->cash_payment_id))? $r->cash_payment->full_name:'' ?></td>
                <td><?= h($r->description ?? '') ?></td>
                <td><?= (!empty($r->chart_of_account_id))? $r->chart_of_account->full_name:'' ?></td>
                <td><?= Number::format($r->amount ?? '') ?></td>
                <td><?= (!empty($r->cost_center_id))? $r->cost_center->full_name:'' ?></td>
                <td><?= h($r->created ?? '') ?></td>
                <td>
                    <?= $this->Form->postLink('Xóa', ['action' => 'deletedetail', $r->id], ['confirm' => 'Xóa?', 'class' => 'btn btn-sm btn-danger']) ?>
                    <?= $this->Html->link('Sửa', ['action' => 'editdetail', $r->id], ['class' => 'btn btn-sm btn-warning']) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator"><?= $this->Paginator->numbers() ?></div>
</div>
