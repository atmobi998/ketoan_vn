<div class="boms form">
    <h3>Thêm Boms</h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('bom_code', ['label' => 'Mã BOM', 'class' => 'form-control']) ?>
        <?= $this->Form->control('product_id', ['label' => 'Sản phẩm', 'options' => $related['Products'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('version', ['label' => 'Version', 'class' => 'form-control']) ?>
        <?= $this->Form->control('quantity_produced', ['label' => 'Số lượng sản xuất', 'class' => 'form-control']) ?>
        <?= $this->Form->control('effective_date', ['label' => 'Ngày hiệu lực', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('expiry_date', ['label' => 'Ngày hết hạn', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('status', ['label' => 'Trạng thái', 'type' => 'select', 'options' => ['draft' => 'draft', 'active' => 'active', 'inactive' => 'inactive'], 'class' => 'form-control']) ?>
        <?= $this->Form->control('description', ['label' => 'Diễn giải', 'type' => 'textarea', 'class' => 'form-control']) ?>
        <?= $this->Form->control('created_by', ['label' => 'Người tạo', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Lưu', ['class' => 'btn btn-primary']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
