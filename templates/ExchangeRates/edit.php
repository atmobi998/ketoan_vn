<div class="exchange_rates form">
    <h3>Sửa ExchangeRates: <?= h($record->id) ?></h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('from_currency_id', ['label' => 'Từ tiền tệ', 'options' => $related['FromCurrencies'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('to_currency_id', ['label' => 'Đến tiền tệ', 'options' => $related['ToCurrencies'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('rate', ['label' => 'Tỷ lệ', 'class' => 'form-control']) ?>
        <?= $this->Form->control('effective_date', ['label' => 'Ngày hiệu lực', 'type' => 'date', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
