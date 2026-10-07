<div class="tool_allocations index">
    <h3>ToolAllocations <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
    <a href="<?= $this->Url->build(['action' => 'exportExcel']) ?>" class="btn btn-success btn-sm float-end me-2"><i class="fa fa-file-excel"></i> Excel</a>
    <a href="<?= $this->Url->build(['action' => 'exportPdf']) ?>" class="btn btn-danger btn-sm float-end me-2"><i class="fa fa-file-pdf"></i> PDF</a></h3>
    <table class="table table-bordered table-striped">
        <thead><tr>
                <th>Mã ID</th>
                <th>tool</th>
                <th>người lao động</th>
                <th>phòng ban</th>
                <th>ngày phân bổ</th>
                <th>số lượng</th>
                <th>số lượng</th>
                <th>Tác vụ</th>
        </tr></thead>
        <tbody>
        <?php foreach ($records as $r): ?>
            <tr>
                <td><?= h($r->id ?? '') ?></td>
                <td><?= (!empty($r->tool_id))? $r->tool->full_name:'' ?></td>
                <td><?= (!empty($r->employee_id))? $r->employee->full_name:'' ?></td>
                <td><?= (!empty($r->department_id))? $r->department->full_name:'' ?></td>
                <td><?= h($r->allocation_date ?? '') ?></td>
                <td><?= h($r->quantity ?? '') ?></td>
                <td><?= h($r->amount ?? '') ?></td>
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
