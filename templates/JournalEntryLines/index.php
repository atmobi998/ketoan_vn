<div class="journal_entry_lines index">
    <h3>JournalEntryLines <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
    <a href="<?= $this->Url->build(['action' => 'exportExcel']) ?>" class="btn btn-success btn-sm float-end me-2"><i class="fa fa-file-excel"></i> Excel</a>
    <a href="<?= $this->Url->build(['action' => 'exportPdf']) ?>" class="btn btn-danger btn-sm float-end me-2"><i class="fa fa-file-pdf"></i> PDF</a></h3>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <td colspan="8">
<?php
        use Cake\I18n\FrozenDate;
        $start = FrozenDate::today();
        $end = FrozenDate::today()->subDays(365);

        echo $this->Form->control('from_period', ['options' => $options ?? [], 'value' => $from_period, 'label' => 'From Period', 'empty' => '-- Chọn --', 'OnChange' => 'from_period_chg();', 'class' => 'form-control']);
        echo $this->Form->control('to_period', ['options' => $options ?? [], 'value' => $to_period, 'label' => 'To Period', 'empty' => '-- Chọn --', 'OnChange' => 'to_period_chg();', 'class' => 'form-control']);
?>
                </td>
            </tr>
            <tr>
                <th>Mã ID</th>
                <th>ID bản ghi nhật ký</th>
                <th>Tài khoản KT</th>
                <th>Nợ</th>
                <th>Có</th>
                <th>diễn giải</th>
                <th>trung tâm chi phí</th>
                <th>Tác vụ</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($records as $r): ?>
            <tr>
                <td><?= h($r->id ?? '') ?></td>
                <td><?= (!empty($r->journal_entry_id))? $r->journal_entry->entry_number:'' ?></td>
                <td><?= (!empty($r->chart_of_account_id))? $r->chart_of_account->full_name:'' ?></td>
                <td><?= h($r->debit ?? '') ?></td>
                <td><?= h($r->credit ?? '') ?></td>
                <td><?= h($r->description ?? '') ?></td>
                <td><?= h($r->cost_center_id ?? '') ?></td>
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
<script>
function from_period_chg() {
    window.location.href = '/journal-entry-lines?from_period='+$('#from-period').val()+'&to_period='+$('#to-period').val()+'&time='+$.now();
}
function to_period_chg() {
    window.location.href = '/journal-entry-lines?from_period='+$('#from-period').val()+'&to_period='+$('#to-period').val()+'&time='+$.now();
}
</script>