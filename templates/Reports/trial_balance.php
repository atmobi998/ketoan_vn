<h3>Can doi thu <a href="?export=excel" class="btn btn-success btn-sm">Excel</a> <a href="?export=pdf" class="btn btn-danger btn-sm">PDF</a></h3>
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
        <tr>
            <th>Ma</th>
            <th>Tên</th>
            <th>Nợ</th>
            <th>Có</th>
            <th>Dư</th>
        </tr>
    </thead>
    <tbody><?php foreach ($trial as $t): ?>
        <tr>
            <td><?= h($t['code']) ?></td>
            <td><?= h($t['name']) ?></td>
            <td class="text-end"><?= number_format($t['debit']) ?></td>
            <td class="text-end"><?= number_format($t['credit']) ?></td>
            <td class="text-end"><?= number_format($t['balance']) ?></td>
        </tr><?php endforeach; ?>
    </tbody>
</table>
<script>
function from_period_chg() {
    window.location.href = '/reports/trial-balance?from_period='+$('#from-period').val()+'&to_period='+$('#to-period').val()+'&time='+$.now();
}
function to_period_chg() {
    window.location.href = '/reports/trial-balance?from_period='+$('#from-period').val()+'&to_period='+$('#to-period').val()+'&time='+$.now();
}
</script>