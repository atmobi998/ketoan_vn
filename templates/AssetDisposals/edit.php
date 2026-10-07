<div class="asset_disposals form">
    <h3>Sửa AssetDisposals: <?= h($record->id) ?></h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('fixed_asset_id', ['label' => 'Tài sản cố định', 'options' => $related['FixedAssets'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('disposal_date', ['label' => 'Ngày thanh lý', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('disposal_method', ['label' => 'Phương thức thanh lý', 'class' => 'form-control']) ?>
        <?= $this->Form->control('disposal_amount', ['label' => 'Giá trị thanh lý', 'class' => 'form-control']) ?>
        <?= $this->Form->control('loss_gain', ['label' => 'Lãi/lỗ', 'class' => 'form-control']) ?>
        <?= $this->Form->control('reason', ['label' => 'Lý do', 'type' => 'textarea', 'class' => 'form-control']) ?>
        <?= $this->Form->control('created_by', ['label' => 'Người tạo', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
