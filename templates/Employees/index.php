<div class="employees index">
    <h3>Employees <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
    <a href="<?= $this->Url->build(['controller' => 'Employees','action' => 'exportExcel']) ?>" class="btn btn-success btn-sm float-end me-2"><i class="fa fa-file-excel"></i> Excel</a>
    <a href="<?= $this->Url->build(['controller' => 'Employees','action' => 'exportPdf']) ?>" class="btn btn-danger btn-sm float-end me-2"><i class="fa fa-file-pdf"></i> PDF</a></h3>
    <table class="table table-bordered table-striped">
        <thead><tr>
                <th>Mã ID</th>
                <th>Mã Code</th>
                <th>họ và tên</th>
                <th>phòng ban</th>
                <th>chức vụ</th>
                <th>giới tính</th>
                <th>birth_date</th>
                <th>SĐT</th>
                <th>email</th>
                <th>ngày bắt đầu</th>
                <th>Tác vụ</th>
        </tr></thead>
        <tbody>
        <?php foreach ($records as $r): ?>
            <tr>
                <td><?= h($r->id ?? '') ?></td>
                <td><?= h($r->code ?? '') ?></td>
                <td><?= h($r->full_name ?? '') ?></td>
                <td><?= (!empty($r->department_id))? $r->department->full_name:'' ?></td>
                <td><?= (!empty($r->position_id))? $r->position->full_name:'' ?></td>
                <td><?= h($r->gender ?? '') ?></td>
                <td><?= h($r->birth_date ?? '') ?></td>
                <td><?= h($r->phone ?? '') ?></td>
                <td><?= h($r->email ?? '') ?></td>
                <td><?= h($r->join_date ?? '') ?></td>
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