<?php
        use Cake\I18n\FrozenDate;
        use Cake\I18n\Number;
?>
<div class="cash_receipt_details index">
    <h3>CashReceiptDetails <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
    <a href="<?= $this->Url->build(['action' => 'exportExcel']) ?>" class="btn btn-success btn-sm float-end me-2"><i class="fa fa-file-excel"></i> Excel</a>
    <a href="<?= $this->Url->build(['action' => 'exportPdf']) ?>" class="btn btn-danger btn-sm float-end me-2"><i class="fa fa-file-pdf"></i> PDF</a></h3>
    <table class="table table-bordered table-striped">
        <thead><tr>
                <th>Mã ID</th>
                <th>cash_receipt_id</th>
                <th>diễn giải</th>
                <th>Tài khoản KT</th>
                <th>số tiền</th>
                <th>trung tâm chi phí</th>
                <th>TGian Tạo</th>
                <th>Tác vụ</th>
        </tr></thead>
        <tbody>
        <?php foreach ($records as $r): ?>
            <tr>
                <td><?= h($r->id ?? '') ?></td>
                <td><?= h($r->cash_receipt_id ?? '') ?></td>
                <td><?= h($r->description ?? '') ?></td>
                <td><?= h($r->chart_of_account_id ?? '') ?></td>
                <td><?= Number::format($r->amount ?? '') ?></td>
                <td><?= h($r->cost_center_id ?? '') ?></td>
                <td><?= h($r->created ?? '') ?></td>
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
