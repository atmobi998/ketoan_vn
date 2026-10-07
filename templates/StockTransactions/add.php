<div class="stock_transactions form">
    <h3>Thêm StockTransactions</h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('transaction_number', ['label' => 'Số giao dịch', 'class' => 'form-control']) ?>
        <?= $this->Form->control('transaction_date', ['label' => 'Ngày giao dịch', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('transaction_type', ['label' => 'Loại giao dịch', 'type' => 'select', 'options' => ['import' => 'import', 'export' => 'export', 'transfer' => 'transfer', 'adjustment' => 'adjustment'], 'class' => 'form-control']) ?>
        <?= $this->Form->control('warehouse_id', ['label' => 'Warehouse Id', 'options' => $related['Warehouses'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('warehouse_to_id', ['label' => 'Warehouse To Id', 'options' => $related['ToWarehouses'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('product_id', ['label' => 'Sản phẩm', 'options' => $related['Products'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('quantity', ['label' => 'Số lượng', 'class' => 'form-control']) ?>
        <?= $this->Form->control('unit_id', ['label' => 'Unit Id', 'options' => $related['Units'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('unit_price', ['label' => 'Đơn giá', 'class' => 'form-control']) ?>
        <?= $this->Form->control('total_amount', ['label' => 'Tổng tiền', 'class' => 'form-control']) ?>
        <?= $this->Form->control('reference_type', ['label' => 'Loại tham chiếu', 'type' => 'select', 'options' => ['PurchaseOrder' => 'Đơn đặt mua', 'PurchaseInvoice' => 'Hóa đơn mua', 'GoodsReceipt' => 'Phiếu nhập', 'SupplierPayment' => 'Phiếu chi NCC', 'Other' => 'Khác'],'class' => 'form-control']) ?>
        <?= $this->Form->control('reference_id', ['label' => 'Tham chiếu ID', 'type' => 'text','class' => 'form-control']) ?>
        <?= $this->Form->control('notes', ['label' => 'Ghi chú', 'type' => 'textarea', 'class' => 'form-control']) ?>
        <?= $this->Form->control('created_by', ['label' => 'Người tạo', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Lưu', ['class' => 'btn btn-primary']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
<script>
$( function() {

    if ($('#reference-type').val() !== 'Other') {
        var postdataee={};
        var ssurlee = '/journal-entries/refdropdown/'+$('#reference-type').val();
        $.get(ssurlee, postdataee,
            function(retdata) {
                var jsondata = jQuery.parseJSON(retdata);
                $('#reference-id').autocomplete({source: jsondata}).focus(function () {$(this).autocomplete("search");});
            }
        );	
    }

    $('#reference-type').on('change', function() {
        if ($('#reference-type').val() !== 'Other') {
            $('#reference-id').val('');
            var postdataee={};
            var ssurlee = '/journal-entries/refdropdown/'+$('#reference-type').val();
            $.get(ssurlee, postdataee,
                function(retdata) {
                    var jsondata = jQuery.parseJSON(retdata);
                    $('#reference-id').autocomplete({source: jsondata}).focus(function () {$(this).autocomplete("search");});
                }
            );	
        }
    });

});
</script>