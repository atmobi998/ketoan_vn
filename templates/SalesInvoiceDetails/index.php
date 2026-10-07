<?php
        use Cake\I18n\FrozenDate;
        use Cake\I18n\Number;
?>
<div class="sales_invoice_details index">
    <h3>SalesInvoiceDetails <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
    <a href="<?= $this->Url->build(['action' => 'exportExcel']) ?>" class="btn btn-success btn-sm float-end me-2"><i class="fa fa-file-excel"></i> Excel</a>
    <a href="<?= $this->Url->build(['action' => 'exportPdf']) ?>" class="btn btn-danger btn-sm float-end me-2"><i class="fa fa-file-pdf"></i> PDF</a></h3>
    <table class="table table-bordered table-striped">
        <thead><tr>
                <th>Mã ID</th>
                <th>sales_invoice_id</th>
                <th>mã sản phẩm</th>
                <th>số lượng</th>
                <th>đơn giá</th>
                <th>thành tiền</th>
                <th>thuế suất VAT</th>
                <th>Tác vụ</th>
        </tr></thead>
        <tbody>
        <?php foreach ($records as $r): ?>
            <tr>
                <td><?= h($r->id ?? '') ?></td>
                <td><?= h($r->sales_invoice_id ?? '') ?></td>
                <td><?= h($r->product_id ?? '') ?></td>
                <td><?= h($r->quantity ?? '') ?></td>
                <td><?= Number::format($r->unit_price ?? '') ?></td>
                <td><?= Number::format($r->amount ?? '') ?></td>
                <td><?= h($r->vat_rate ?? '') ?></td>
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
