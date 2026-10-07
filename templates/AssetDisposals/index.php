<div class="asset_disposals index">
    <h3>AssetDisposals <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
    <a href="<?= $this->Url->build(['action' => 'exportExcel']) ?>" class="btn btn-success btn-sm float-end me-2"><i class="fa fa-file-excel"></i> Excel</a>
    <a href="<?= $this->Url->build(['action' => 'exportPdf']) ?>" class="btn btn-danger btn-sm float-end me-2"><i class="fa fa-file-pdf"></i> PDF</a></h3>
    <table class="table table-bordered table-striped">
        <thead><tr>
                <th>Mã ID</th>
                <th>TSCĐ</th>
                <th>ngày thanh lý</th>
                <th>phương pháp xử lý</th>
                <th>số tiền thanh lý</th>
                <th>Lỗ/lãi</th>
                <th>lý do</th>
                <th>Tác vụ</th>
        </tr></thead>
        <tbody>
        <?php foreach ($records as $r): ?>
            <tr>
                <td><?= h($r->id ?? '') ?></td>
                <td><?= (!empty($r->fixed_asset_id))? $r->fixed_asset->full_name:'' ?></td>
                <td><?= h($r->disposal_date ?? '') ?></td>
                <td><?= h($r->disposal_method ?? '') ?></td>
                <td><?= h($r->disposal_amount ?? '') ?></td>
                <td><?= h($r->loss_gain ?? '') ?></td>
                <td><?= h($r->reason ?? '') ?></td>
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
