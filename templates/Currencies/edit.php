<div class="currencies form">
    <h3>Sửa Currencies: <?= h($record->id) ?></h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('code', ['label' => 'Mã', 'class' => 'form-control']) ?>
        <?= $this->Form->control('name', ['label' => 'Tên', 'class' => 'form-control']) ?>
        <?= $this->Form->control('symbol', ['label' => 'Ký hiệu', 'class' => 'form-control']) ?>
        <?= $this->Form->control('exchange_rate', ['label' => 'Tỷ giá', 'class' => 'form-control']) ?>
        <?= $this->Form->control('is_default', ['label' => 'Mặc định', 'type' => 'checkbox']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
