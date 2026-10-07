<div class="bank_transactions form">
    <h3>Sửa BankTransactions: <?= h($record->id) ?></h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('transaction_date', ['label' => 'Ngày giao dịch', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('bank_account_id', ['label' => 'Tài khoản ngân hàng', 'options' => $related['BankAccounts'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('type', ['label' => 'Loại', 'type' => 'select', 'options' => ['in' => 'in', 'out' => 'out'], 'class' => 'form-control']) ?>
        <?= $this->Form->control('amount', ['label' => 'Số tiền', 'class' => 'form-control']) ?>
        <?= $this->Form->control('description', ['label' => 'Diễn giải', 'type' => 'textarea', 'class' => 'form-control']) ?>
        <?= $this->Form->control('reference_type', ['label' => 'Loại tham chiếu', 'type' => 'select', 'options' => ['SalesOrder' => 'Đơn bán hàng', 'SalesInvoice' => 'Hóa đơn bán', 'DeliveryNote' => 'Phiếu xuất', 'CustomerPayment' => 'Phiếu thu KH', 'PurchaseOrder' => 'Đơn đặt mua', 'PurchaseInvoice' => 'Hóa đơn mua', 'GoodsReceipt' => 'Phiếu nhập', 'SupplierPayment' => 'Phiếu chi NCC', 'Payroll' => 'Bảng lương','Other' => 'Khác'], 'empty' => '-- Loại chứng từ --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('reference_id', ['label' => 'Tham chiếu ID', 'type' => 'text', 'class' => 'form-control']) ?>
        <?= $this->Form->control('balance_after', ['label' => 'Số dư sau', 'class' => 'form-control']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
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