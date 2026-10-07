<?php
        use Cake\I18n\FrozenDate;
        use Cake\I18n\Number;

?>
<div class="payrolls form">
    <h3>Sửa Payrolls: <?= h($record->id) ?>
        <?= $this->Html->link('In', ['action' => 'view', $record->id], ['class' => 'btn btn-sm btn-success','target'=>'_new']) ?>
    </h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('payroll_code', ['label' => 'Mã bảng lương', 'class' => 'form-control']) ?>
        <?= $this->Form->control('payroll_month', ['label' => 'Tháng lương', 'class' => 'form-control']) ?>
        <?= $this->Form->control('payroll_year', ['label' => 'Năm lương', 'class' => 'form-control']) ?>
        <?= $this->Form->control('department_id', ['label' => 'Phòng ban', 'options' => $related['Departments'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('total_employees', ['label' => 'Tổng nhân viên', 'class' => 'form-control']) ?>
        <?= $this->Form->control('total_amount', ['label' => 'Tổng tiền', 'class' => 'form-control']) ?>
        <?= $this->Form->control('total_deduction', ['label' => 'Tổng trừ', 'class' => 'form-control']) ?>
        <?= $this->Form->control('insurance_deduction', ['label' => 'Trừ BHXH', 'class' => 'form-control']) ?>
        <?= $this->Form->control('tax_deduction', ['label' => 'Thuế TNCN', 'class' => 'form-control']) ?>
        <?= $this->Form->control('total_net', ['label' => 'Tổng thực nhận', 'class' => 'form-control']) ?>
        <?= $this->Form->control('status', ['label' => 'Trạng thái', 'type' => 'select', 'options' => ['draft' => 'draft', 'approved' => 'approved', 'paid' => 'paid'], 'class' => 'form-control']) ?>
        <?= $this->Form->control('created_by', ['label' => 'Người tạo', 'class' => 'form-control']) ?>
        <?= $this->Form->control('accounting_period_id', ['label' => 'Kỳ kế toán', 'options' => $related['AccountingPeriods'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
<div class="clearfix bg-light p-3"></div>
<div class="payroll_details index">
    <h3>PayrollDetails <a href="<?= $this->Url->build(['action' => 'adddetail',$record->id]) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
    <a href="<?= $this->Url->build(['controller' => 'PayrollDetails','action' => 'exportExcel']) ?>" class="btn btn-success btn-sm float-end me-2"><i class="fa fa-file-excel"></i> Excel</a>
    <a href="<?= $this->Url->build(['controller' => 'PayrollDetails','action' => 'exportPdf']) ?>" class="btn btn-danger btn-sm float-end me-2"><i class="fa fa-file-pdf"></i> PDF</a></h3>
    <table class="table table-bordered table-striped">
        <thead><tr>
                <th>Mã ID</th>
                <th>mã bảng lương</th>
                <th>người lao động</th>
                <th>lương cơ bản</th>
                <th>khoản phụ cấp</th>
                <th>tiền làm thêm giờ</th>
                <th>thưởng</th>
                <th>lương thực nhận</th>
                <th>khấu trừ bảo hiểm</th>
                <th>khấu trừ thuế</th>
                <th>khấu trừ khác</th>
                <th>Tác vụ</th>
        </tr></thead>
        <tbody>
        <?php foreach ($records as $r): ?>
            <tr>
                <td><?= h($r->id ?? '') ?></td>
                <td><?= (!empty($r->payroll_id))? $r->payroll->full_name:'' ?></td>
                <td><?= (!empty($r->employee_id))? $r->employee->full_name:'' ?></td>
                <td><?= Number::format((int)$r->basic_salary ?? '') ?></td>
                <td><?= Number::format((int)$r->allowance ?? '') ?></td>
                <td><?= Number::format((int)$r->overtime_amount ?? '') ?></td>
                <td><?= Number::format((int)$r->bonus ?? '') ?></td>
                <td><?= Number::format((int)$r->net_salary ?? '') ?></td>
                <td><?= Number::format((int)$r->insurance_deduction ?? '') ?></td>
                <td><?= Number::format((int)$r->tax_deduction ?? '') ?></td>
                <td><?= Number::format((int)$r->other_deduction ?? '') ?></td>
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
