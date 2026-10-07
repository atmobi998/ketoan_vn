<div class="asset_depreciations form">
    <h3>Sửa AssetDepreciations: <?= h($record->id) ?></h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('fixed_asset_id', ['label' => 'Tài sản cố định', 'options' => $related['FixedAssets'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('depreciation_date', ['label' => 'Ngày khấu hao', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('period', ['label' => 'Kỳ', 'class' => 'form-control']) ?>
        <?= $this->Form->control('depreciation_amount', ['label' => 'Số tiền khấu hao', 'class' => 'form-control']) ?>
        <?= $this->Form->control('accumulated_depreciation', ['label' => 'Hao mòn lũy kế', 'class' => 'form-control']) ?>
        <?= $this->Form->control('remaining_value', ['label' => 'Giá trị còn lại', 'class' => 'form-control']) ?>
        <?= $this->Form->control('accounting_period_id', ['label' => 'Kỳ kế toán', 'options' => $related['AccountingPeriods'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
