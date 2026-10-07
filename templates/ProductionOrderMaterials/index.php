<div class="production_order_materials index">
    <h3>ProductionOrderMaterials <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
    <a href="<?= $this->Url->build(['action' => 'exportExcel']) ?>" class="btn btn-success btn-sm float-end me-2"><i class="fa fa-file-excel"></i> Excel</a>
    <a href="<?= $this->Url->build(['action' => 'exportPdf']) ?>" class="btn btn-danger btn-sm float-end me-2"><i class="fa fa-file-pdf"></i> PDF</a></h3>
    <table class="table table-bordered table-striped">
        <thead><tr>
                <th>Mã ID</th>
                <th>Mã lệnh sản xuất</th>
                <th>sản phẩm</th>
                <th>số lượng yêu cầu</th>
                <th>số lượng đã sử dụng</th>
                <th>đơn giá</th>
                <th>tổng chi phí</th>
                <th>Tác vụ</th>
        </tr></thead>
        <tbody>
        <?php foreach ($records as $r): ?>
            <tr>
                <td><?= h($r->id ?? '') ?></td>
                <td><?= (!empty($r->production_order_id))? $r->production_order->full_name:'' ?></td>
                <td><?= (!empty($r->product_id))? $r->product->full_name:'' ?></td>
                <td><?= h($r->quantity_required ?? '') ?></td>
                <td><?= h($r->quantity_used ?? '') ?></td>
                <td><?= h($r->unit_price ?? '') ?></td>
                <td><?= h($r->total_cost ?? '') ?></td>
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
