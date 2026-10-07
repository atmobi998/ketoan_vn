<div class="departments form">
    <h3>Sửa Departments: <?= h($record->id) ?></h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('code', ['label' => 'Mã', 'class' => 'form-control']) ?>
        <?= $this->Form->control('name', ['label' => 'Tên', 'class' => 'form-control']) ?>
        <?= $this->Form->control('description', ['label' => 'Diễn giải', 'type' => 'textarea', 'class' => 'form-control']) ?>
        <?= $this->Form->control('parent_id', ['label' => 'Tài khoản cha', 'options' => $related['Parents'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('manager_id', ['label' => 'Người quản lý', 'options' => $related['Managers'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
<div class="clearfix bg-light p-3"></div>
<div class="employees index">
    <h3>Employees <a href="<?= $this->Url->build(['action' => 'adddetail',$record->id]) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
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
                <th>Tác vụ</th>
        </tr></thead>
        <tbody>
        <?php foreach ($records as $r): ?>
            <tr>
                <td><?= h($r->id ?? '') ?></td>
                <td><?= h($r->code ?? '') ?></td>
                <td><?= h($r->full_name ?? '') ?></td>
                <td><?= (!empty($r->department_id))? $r->department->full_name:'' ?></td>
                <td><?= (!empty($r->position_id))? $r->position->name:'' ?></td>
                <td><?= h($r->gender ?? '') ?></td>
                <td><?= h($r->birth_date ?? '') ?></td>
                <td><?= h($r->phone ?? '') ?></td>
                <td><?= h($r->email ?? '') ?></td>
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
