<h3>So cai <a href="?export=excel" class="btn btn-success btn-sm">Excel</a> <a href="?export=pdf" class="btn btn-danger btn-sm">PDF</a></h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <td colspan="5">
<?php
        use Cake\I18n\FrozenDate;
        $start = FrozenDate::today();
        $end = FrozenDate::today()->subDays(365);

        echo $this->Form->control('from_period', ['options' => $options ?? [], 'value' => $from_period, 'label' => 'From Period', 'empty' => '-- Chọn --', 'OnChange' => 'from_period_chg();', 'class' => 'form-control']);
        echo $this->Form->control('to_period', ['options' => $options ?? [], 'value' => $to_period, 'label' => 'To Period', 'empty' => '-- Chọn --', 'OnChange' => 'to_period_chg();', 'class' => 'form-control']);
?>
            </td>
        </tr>
        <tr><th>Ma TK</th>
            <th>Tên</th>
            <th>Nợ</th>
            <th>Có</th>
            <th>Số dư</th>
        </tr>
    </thead>
    <tbody><?php foreach ($grouped as $g): ?>
        <tr>
            <td><?= h($g['code']) ?></td>
            <td><?= h($g['name']) ?></td>
            <td class="text-end"><?= number_format($g['debit']) ?></td>
            <td class="text-end"><?= number_format($g['credit']) ?></td>
            <td class="text-end"><?= number_format($g['balance']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script>
function from_period_chg() {
    window.location.href = '/reports/general-ledger?from_period='+$('#from-period').val()+'&to_period='+$('#to-period').val()+'&time='+$.now();
}
function to_period_chg() {
    window.location.href = '/reports/general-ledger?from_period='+$('#from-period').val()+'&to_period='+$('#to-period').val()+'&time='+$.now();
}
</script>