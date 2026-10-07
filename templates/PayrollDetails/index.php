<div class="payroll_details index">
    <h3>PayrollDetails <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
    <a href="<?= $this->Url->build(['action' => 'exportExcel']) ?>" class="btn btn-success btn-sm float-end me-2"><i class="fa fa-file-excel"></i> Excel</a>
    <a href="<?= $this->Url->build(['action' => 'exportPdf']) ?>" class="btn btn-danger btn-sm float-end me-2"><i class="fa fa-file-pdf"></i> PDF</a></h3>
    <table class="table table-bordered table-striped">
        <thead><tr>
                <th>Mã ID</th>
                <th>mã bảng lương</th>
                <th>người lao động</th>
                <th>lương cơ bản</th>
                <th>khoản phụ cấp</th>
                <th>tiền làm thêm giờ</th>
                <th>thưởng</th>
                <th>Tác vụ</th>
        </tr></thead>
        <tbody>
        <?php foreach ($records as $r): ?>
            <tr>
                <td><?= h($r->id ?? '') ?></td>
                <td><?= (!empty($r->payroll_id))? $r->payroll->full_name:'' ?></td>
                <td><?= (!empty($r->employee_id))? $r->employee->full_name:'' ?></td>
                <td><?= h($r->basic_salary ?? '') ?></td>
                <td><?= h($r->allowance ?? '') ?></td>
                <td><?= h($r->overtime_amount ?? '') ?></td>
                <td><?= h($r->bonus ?? '') ?></td>
                <td>
                    <?= $this->Form->postLink('Xóa', ['action' => 'delete', $r->id], ['confirm' => 'Xóa?', 'class' => 'btn btn-sm btn-danger']) ?>
                    <?= $this->Html->link('Sửa', ['action' => 'edit', $r->id], ['class' => 'btn btn-sm btn-warning']) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator"><?= $this->Paginator->numbers() ?></div>
</div>
