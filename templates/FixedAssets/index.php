<div class="fixed_assets index">
    <h3>FixedAssets <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
    <a href="<?= $this->Url->build(['action' => 'exportExcel']) ?>" class="btn btn-success btn-sm float-end me-2"><i class="fa fa-file-excel"></i> Excel</a>
    <a href="<?= $this->Url->build(['action' => 'exportPdf']) ?>" class="btn btn-danger btn-sm float-end me-2"><i class="fa fa-file-pdf"></i> PDF</a></h3>
    <table class="table table-bordered table-striped">
        <thead><tr>
                <th>Mã ID</th>
                <th>Mã Code</th>
                <th>Tên</th>
                <th>nhóm tài sản</th>
                <th>ngày mua lại</th>
                <th>chi phí ban đầu</th>
                <th>phương pháp khấu hao</th>
                <th>khấu hao lũy kế</th>
                <th>giá trị còn lại</th>
                <th>Tài khoản KT</th>
                <th>phòng ban</th>
                <th>tuổi thọ hữu ích</th>
                <th>Tác vụ</th>
        </tr></thead>
        <tbody>
        <?php foreach ($records as $r): ?>
            <tr>
                <td><?= h($r->id ?? '') ?></td>
                <td><?= h($r->code ?? '') ?></td>
                <td><?= h($r->name ?? '') ?></td>
                <td><?= (!empty($r->asset_category_id))? $r->asset_category->name:'' ?></td>
                <td><?= h($r->acquisition_date ?? '') ?></td>
                <td><?= h($r->original_cost ?? '') ?></td>
                <td><?= h($r->depreciation_method ?? '') ?></td>
                <td><?= h($r->accumulated_depreciation ?? '') ?></td>
                <td><?= h($r->remaining_value ?? '') ?></td>
                <td><?= (!empty($r->chart_of_account_id))? $r->chart_of_account->full_name:'' ?></td>
                <td><?= (!empty($r->department_id))? $r->department->full_name:'' ?></td>
                <td><?= h($r->useful_life ?? '') ?></td>
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
