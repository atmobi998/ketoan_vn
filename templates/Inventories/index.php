<div class="inventories index">
    <h3>Inventories <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
    <a href="<?= $this->Url->build(['action' => 'exportExcel']) ?>" class="btn btn-success btn-sm float-end me-2"><i class="fa fa-file-excel"></i> Excel</a>
    <a href="<?= $this->Url->build(['action' => 'exportPdf']) ?>" class="btn btn-danger btn-sm float-end me-2"><i class="fa fa-file-pdf"></i> PDF</a></h3>
    <table class="table table-bordered table-striped">
        <thead><tr>
                <th>Mã ID</th>
                <th>sản phẩm</th>
                <th>kho</th>
                <th>số lượng</th>
                <th>Số lượng hiện có</th>
                <th>số lượng đặt trước</th>
                <th>đơn vị</th>
                <th>giá nhập gần nhất</th>
                <th>Tác vụ</th>
        </tr></thead>
        <tbody>
        <?php foreach ($records as $r): ?>
            <tr>
                <td><?= h($r->id ?? '') ?></td>
                <td><?= (!empty($r->product_id))? $r->product->name.' ('.$r->product->code.')':'' ?></td>
                <td><?= (!empty($r->warehouse_id))? $r->warehouse->name.' ('.$r->warehouse->code.')':'' ?></td>
                <td><?= (!empty($r->quantity))? $r->quantity:'' ?></td>
                <td><?= (!empty($r->quantity_available))? $r->quantity_available:'' ?></td>
                <td><?= (!empty($r->quantity_reserved))? $r->quantity_reserved:'' ?></td>
                <td><?= h($r->unit->name ?? '') ?></td>
                <td><?= h($r->last_import_price ?? '') ?></td>
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
