<div class="products index">
    <h3>Products <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
    <a href="<?= $this->Url->build(['action' => 'exportExcel']) ?>" class="btn btn-success btn-sm float-end me-2"><i class="fa fa-file-excel"></i> Excel</a>
    <a href="<?= $this->Url->build(['action' => 'exportPdf']) ?>" class="btn btn-danger btn-sm float-end me-2"><i class="fa fa-file-pdf"></i> PDF</a></h3>
    <table class="table table-bordered table-striped">
        <thead><tr>
                <th>Mã ID</th>
                <th>Mã Code</th>
                <th>Tên</th>
                <th>Danh mục sản phẩm</th>
                <th>đơn vị</th>
                <th>diễn giải</th>
                <th>giá mua</th>
                <th>Tác vụ</th>
        </tr></thead>
        <tbody>
        <?php foreach ($records as $r): ?>
            <tr>
                <td><?= h($r->id ?? '') ?></td>
                <td><?= h($r->code ?? '') ?></td>
                <td><?= h($r->name ?? '') ?></td>
                <td><?= (!empty($r->product_category_id))? $r->product_category->name.' ('.$r->product_category->code.')':'' ?></td>
                <td><?= (!empty($r->unit_id))? $r->unit->name:'' ?></td>
                <td><?= h($r->description ?? '') ?></td>
                <td><?= h($r->price_buy ?? '') ?></td>
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
