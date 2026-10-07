<div class="stock_adjustments index">
    <h3>StockAdjustments <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
    <a href="<?= $this->Url->build(['action' => 'exportExcel']) ?>" class="btn btn-success btn-sm float-end me-2"><i class="fa fa-file-excel"></i> Excel</a>
    <a href="<?= $this->Url->build(['action' => 'exportPdf']) ?>" class="btn btn-danger btn-sm float-end me-2"><i class="fa fa-file-pdf"></i> PDF</a></h3>
    <table class="table table-bordered table-striped">
        <thead><tr>
                <th>Mã ID</th>
                <th>số hiệu điều chỉnh</th>
                <th>ngày điều chỉnh</th>
                <th>kho</th>
                <th>loại điều chỉnh</th>
                <th>lý do</th>
                <th>tổng số tiền</th>
                <th>Tác vụ</th>
        </tr></thead>
        <tbody>
        <?php foreach ($records as $r): ?>
            <tr>
                <td><?= h($r->id ?? '') ?></td>
                <td><?= h($r->adjustment_number ?? '') ?></td>
                <td><?= h($r->adjustment_date ?? '') ?></td>
                <td><?= (!empty($r->warehouse_id))? $r->warehouse->name.' ('.$r->warehouse->code.')':'' ?></td>
                <td><?= h($r->adjustment_type ?? '') ?></td>
                <td><?= h($r->reason ?? '') ?></td>
                <td><?= h($r->total_amount ?? '') ?></td>
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
