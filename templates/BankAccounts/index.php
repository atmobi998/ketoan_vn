<div class="bank_accounts index">
    <h3>BankAccounts <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
    <a href="<?= $this->Url->build(['action' => 'exportExcel']) ?>" class="btn btn-success btn-sm float-end me-2"><i class="fa fa-file-excel"></i> Excel</a>
    <a href="<?= $this->Url->build(['action' => 'exportPdf']) ?>" class="btn btn-danger btn-sm float-end me-2"><i class="fa fa-file-pdf"></i> PDF</a></h3>
    <table class="table table-bordered table-striped">
        <thead><tr>
                <th>Mã ID</th>
                <th>số tài khoản</th>
                <th>tên ngân hàng</th>
                <th>chi nhánh</th>
                <th>tiền tệ</th>
                <th>Tài khoản KT</th>
                <th>số dư</th>
                <th>Tác vụ</th>
        </tr></thead>
        <tbody>
        <?php foreach ($records as $r): ?>
            <tr>
                <td><?= h($r->id ?? '') ?></td>
                <td><?= h($r->account_number ?? '') ?></td>
                <td><?= h($r->bank_name ?? '') ?></td>
                <td><?= h($r->branch ?? '') ?></td>
                <td><?= (!empty($r->currency_id))? $r->currency->code:'' ?></td>
                <td><?= (!empty($r->chart_of_account_id))? $r->chart_of_account->full_name:'' ?></td>
                <td><?= h($r->balance ?? '') ?></td>
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
