<div class="journal_entries form">
    <h3>Thêm JournalEntries</h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('entry_number', ['label' => 'Số bút toán', 'class' => 'form-control']) ?>
        <?= $this->Form->control('entry_date', ['label' => 'Ngày ghi sổ', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('accounting_date', ['label' => 'Ngày hạch toán', 'type' => 'date', 'class' => 'form-control']) ?>
        <?= $this->Form->control('description', ['label' => 'Diễn giải', 'type' => 'textarea', 'class' => 'form-control']) ?>
        <?= $this->Form->control('total_debit', ['label' => 'Tổng nợ', 'class' => 'form-control']) ?>
        <?= $this->Form->control('total_credit', ['label' => 'Tổng có', 'class' => 'form-control']) ?>
        <?= $this->Form->control('status', ['label' => 'Trạng thái', 'type' => 'select', 'options' => ['draft' => 'draft', 'posted' => 'posted', 'cancelled' => 'cancelled'], 'class' => 'form-control']) ?>
        <?= $this->Form->control('created_by', ['label' => 'Người tạo', 'class' => 'form-control']) ?>
        <?= $this->Form->control('accounting_period_id', ['label' => 'Kỳ kế toán', 'options' => $related['AccountingPeriods'] ?? [], 'empty' => '-- Chọn --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('reference_type', ['label' => 'Loại tham chiếu', 'type' => 'select', 'options' => ['SalesOrder' => 'Đơn bán hàng', 'SalesInvoice' => 'Hóa đơn bán', 'DeliveryNote' => 'Phiếu xuất', 'CustomerPayment' => 'Phiếu thu KH', 'PurchaseOrder' => 'Đơn đặt mua', 'PurchaseInvoice' => 'Hóa đơn mua', 'GoodsReceipt' => 'Phiếu nhập', 'SupplierPayment' => 'Phiếu chi NCC', 'Payroll' => 'Bảng lương','Other' => 'Khác'], 'empty' => '-- Loại chứng từ --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('reference_id', ['label' => 'Tham chiếu ID', 'type' => 'text', 'class' => 'form-control']) ?>
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
                $('#reference-id').autocomplete({source: jsondata}).focus(function () {
                    $(this).autocomplete("search");
                });
            }
        );	
    }

    $('#reference-type').on('change', function() {
        if ($('#reference-type').val() !== 'Other') {
            $('#reference-id').val('');
            var postdataee={};
            var ssurlee = '/journal-entries/refdropdown/'+$('#reference-type').val()+'/';
            $.get(ssurlee, postdataee,
                function(retdata) {
                    var jsondata = jQuery.parseJSON(retdata);
                    $('#reference-id').autocomplete({source: jsondata}).focus(function () {
                        $(this).autocomplete("search");
                    });
                }
            );	
        }
    });

});
</script>