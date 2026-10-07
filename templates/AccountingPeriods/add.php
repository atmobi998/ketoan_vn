<div class="accounting_periods form">
    <h3>Thêm AccountingPeriods</h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('code', ['label' => 'Mã', 'class' => 'form-control']) ?>
        <?= $this->Form->control('name', ['label' => 'Tên', 'class' => 'form-control']) ?>
        <?= $this->Form->control('start_date', ['label' => 'Ngày bắt đầu', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('end_date', ['label' => 'Ngày kết thúc', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('status', ['label' => 'Trạng thái', 'type' => 'select', 'options' => ['open' => 'open', 'closed' => 'closed', 'locked' => 'locked'], 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Lưu', ['class' => 'btn btn-primary']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
