<div class="asset_categories form">
    <h3>Thêm AssetCategories</h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('code', ['label' => 'Mã', 'class' => 'form-control']) ?>
        <?= $this->Form->control('name', ['label' => 'Tên', 'class' => 'form-control']) ?>
        <?= $this->Form->control('depreciation_rate', ['label' => 'Tỷ lệ khấu hao', 'class' => 'form-control']) ?>
        <?= $this->Form->control('useful_life_months', ['label' => 'Useful Life Months', 'class' => 'form-control']) ?>
        <?= $this->Form->control('chart_account_asset', ['label' => 'TK tài sản', 'class' => 'form-control']) ?>
        <?= $this->Form->control('chart_account_depreciation', ['label' => 'TK hao mòn', 'class' => 'form-control']) ?>
        <?= $this->Form->control('chart_account_expense', ['label' => 'TK chi phí', 'class' => 'form-control']) ?>
        <?= $this->Form->control('description', ['label' => 'Diễn giải', 'type' => 'textarea', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Lưu', ['class' => 'btn btn-primary']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
