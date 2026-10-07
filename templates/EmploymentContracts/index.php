<div class="employment_contracts index">
    <h3>EmploymentContracts <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
    <a href="<?= $this->Url->build(['action' => 'exportExcel']) ?>" class="btn btn-success btn-sm float-end me-2"><i class="fa fa-file-excel"></i> Excel</a>
    <a href="<?= $this->Url->build(['action' => 'exportPdf']) ?>" class="btn btn-danger btn-sm float-end me-2"><i class="fa fa-file-pdf"></i> PDF</a></h3>
    <table class="table table-bordered table-striped">
        <thead><tr>
                <th>Mã ID</th>
                <th>số hợp đồng</th>
                <th>người lao động</th>
                <th>loại hợp đồng</th>
                <th>Ngày BĐ</th>
                <th>Ngày KT</th>
                <th>Lương</th>
                <th>Tác vụ</th>
        </tr></thead>
        <tbody>
        <?php foreach ($records as $r): ?>
            <tr>
                <td><?= h($r->id ?? '') ?></td>
                <td><?= h($r->contract_number ?? '') ?></td>
                <td><?= (!empty($r->employee_id))? $r->employee->full_name:'' ?></td>
                <td><?= h($r->contract_type ?? '') ?></td>
                <td><?= h($r->start_date ?? '') ?></td>
                <td><?= h($r->end_date ?? '') ?></td>
                <td><?= h($r->salary ?? '') ?></td>
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
