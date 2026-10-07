<div class="stock_transfers form">
    <h3>Sửa StockTransfers: <?= h($record->id) ?></h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('transfer_number', ['label' => 'Số phiếu chuyển', 'class' => 'form-control']) ?>
        <?= $this->Form->control('from_warehouse_id', ['label' => 'Từ kho', 'options' => $related['FromWarehouses'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('to_warehouse_id', ['label' => 'Đến kho', 'options' => $related['ToWarehouses'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('transfer_date', ['label' => 'Ngày chuyển', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('status', ['label' => 'Trạng thái', 'type' => 'select', 'options' => ['draft' => 'draft', 'approved' => 'approved', 'completed' => 'completed', 'cancelled' => 'cancelled'], 'class' => 'form-control']) ?>
        <?= $this->Form->control('notes', ['label' => 'Ghi chú', 'type' => 'textarea', 'class' => 'form-control']) ?>
        <?= $this->Form->control('created_by', ['label' => 'Người tạo', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
<div class="clearfix bg-light p-3"></div>
<div class="stock_transfer_details index" style="float:left;">
    <h3>StockTransferDetails <a href="<?= $this->Url->build(['action' => 'adddetail',$record->id]) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
    <a href="<?= $this->Url->build(['controller' => 'StockTransferDetails','action' => 'exportExcel']) ?>" class="btn btn-success btn-sm float-end me-2"><i class="fa fa-file-excel"></i> Excel</a>
    <a href="<?= $this->Url->build(['controller' => 'StockTransferDetails','action' => 'exportPdf']) ?>" class="btn btn-danger btn-sm float-end me-2"><i class="fa fa-file-pdf"></i> PDF</a></h3>
    <table class="table table-bordered table-striped">
        <thead><tr>
                <th>Mã ID</th>
                <th>stock_transfer</th>
                <th>sản phẩm</th>
                <th>số lượng</th>
                <th>đơn vị</th>
                <th>notes</th>
                <th>TGian Tạo</th>
                <th>Tác vụ</th>
        </tr></thead>
        <tbody>
        <?php foreach ($records as $r): ?>
            <tr>
                <td><?= h($r->id ?? '') ?></td>
                <td><?= (!empty($r->stock_transfer_id))? $r->stock_transfer->full_name:'' ?></td>
                <td><?= (!empty($r->product_id))? $r->product->name.' ('.$r->product->code.')':'' ?></td>
                <td><?= h($r->quantity ?? '') ?></td>
                <td><?= (!empty($r->unit_id))? $r->unit->name:'' ?></td>
                <td><?= h($r->notes ?? '') ?></td>
                <td><?= h($r->created ?? '') ?></td>
                <td>
                    <?= $this->Form->postLink('Xóa', ['controller' => 'StockTransfers','action' => 'deletedetail', $r->id], ['confirm' => 'Xóa?', 'class' => 'btn btn-sm btn-danger']) ?>
                    <?= $this->Html->link('Sửa', ['controller' => 'StockTransfers','action' => 'editdetail', $r->id], ['class' => 'btn btn-sm btn-warning']) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator"><?= $this->Paginator->numbers() ?></div>
</div>
