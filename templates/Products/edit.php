<div class="products form">
    <h3>Sửa Products: <?= h($record->id) ?></h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('code', ['label' => 'Mã', 'class' => 'form-control']) ?>
        <?= $this->Form->control('name', ['label' => 'Tên', 'class' => 'form-control']) ?>
        <?= $this->Form->control('product_category_id', ['label' => 'Nhóm sản phẩm', 'options' => $related['ProductCategories'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('unit_id', ['label' => 'Unit Id', 'options' => $related['Units'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('description', ['label' => 'Diễn giải', 'type' => 'textarea', 'class' => 'form-control']) ?>
        <?= $this->Form->control('price_buy', ['label' => 'Giá mua', 'class' => 'form-control']) ?>
        <?= $this->Form->control('price_sell', ['label' => 'Giá bán', 'class' => 'form-control']) ?>
        <?= $this->Form->control('vat_rate', ['label' => 'Vat Rate', 'class' => 'form-control']) ?>
        <?= $this->Form->control('stock_min', ['label' => 'Tồn tối thiểu', 'class' => 'form-control']) ?>
        <?= $this->Form->control('stock_max', ['label' => 'Tồn tối đa', 'class' => 'form-control']) ?>
        <?= $this->Form->control('image', ['label' => 'Hình ảnh', 'class' => 'form-control']) ?>
        <?= $this->Form->control('is_active', ['label' => 'Kích hoạt', 'type' => 'checkbox']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
