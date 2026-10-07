<div class="exchange_rates view">
    <h3>Chi tiết ExchangeRates: <?= h($record->id) ?></h3>
    <table class="table table-bordered">
        <tr><th>Mã ID</th><td><?= h($record->id ?? '') ?></td></tr>
        <tr><th>from_currency_id</th><td><?= h($record->from_currency_id ?? '') ?></td></tr>
        <tr><th>to_currency_id</th><td><?= h($record->to_currency_id ?? '') ?></td></tr>
        <tr><th>rate</th><td><?= h($record->rate ?? '') ?></td></tr>
        <tr><th>ngày có hiệu lực</th><td><?= h($record->effective_date ?? '') ?></td></tr>
        <tr><th>TGian Tạo</th><td><?= h($record->created ?? '') ?></td></tr>
        <tr><th>TGian sửa</th><td><?= h($record->modified ?? '') ?></td></tr>
    </table>
    <?= $this->Html->link('Sửa', ['action' => 'edit', $record->id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Danh sách', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>
