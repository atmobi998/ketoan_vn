<div class="exchange_rates index">
    <h3>ExchangeRates <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
    <a href="<?= $this->Url->build(['action' => 'exportExcel']) ?>" class="btn btn-success btn-sm float-end me-2"><i class="fa fa-file-excel"></i> Excel</a>
    <a href="<?= $this->Url->build(['action' => 'exportPdf']) ?>" class="btn btn-danger btn-sm float-end me-2"><i class="fa fa-file-pdf"></i> PDF</a></h3>
    <table class="table table-bordered table-striped">
        <thead><tr>
                <th>Mã ID</th>
                <th>loại tiền tệ nguồn</th>
                <th>đến loại tiền tệ</th>
                <th>tỷ giá hối đoái</th>
                <th>ngày có hiệu lực</th>
                <th>TGian Tạo</th>
                <th>TGian sửa</th>
                <th>Tác vụ</th>
        </tr></thead>
        <tbody>
        <?php foreach ($records as $r): ?>
            <tr>
                <td><?= h($r->id ?? '') ?></td>
                <td><?= (!empty($r->from_currency_id))? $currency_ary[$r->from_currency_id]:'' ?></td>
                <td><?= (!empty($r->to_currency_id))? $currency_ary[$r->to_currency_id]:'' ?></td>
                <td><?= h($r->rate ?? '') ?></td>
                <td><?= h($r->effective_date ?? '') ?></td>
                <td><?= h($r->created ?? '') ?></td>
                <td><?= h($r->modified ?? '') ?></td>
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
