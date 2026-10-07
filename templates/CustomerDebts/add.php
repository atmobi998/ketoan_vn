<div class="customer_debts form">
    <h3>Thêm Công nợ Khách hàng</h3>
    <?= $this->Form->create($record) ?>
        <?= $this->Form->control('customer_id', ['label' => 'Khách hàng', 'options' => $related['Customers'] ?? [], 'empty' => '-- Chọn Khách hàng --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('document_type', ['label' => 'Loại chứng từ', 'type' => 'select', 'options' => ['SalesOrder' => 'Đơn bán hàng', 'SalesInvoice' => 'Hóa đơn bán', 'DeliveryNote' => 'Phiếu xuất', 'CustomerPayment' => 'Phiếu thu KH', 'Other' => 'Khác'], 'empty' => '-- Loại chứng từ --', 'class' => 'form-control']) ?>
        <?= $this->Form->control('document_id', ['type' => 'text', 'class' => 'form-control', 'label' => 'Chứng từ']) ?>
        <?= $this->Form->control('document_number', ['class' => 'form-control', 'label' => 'Số chứng từ']) ?>
        <?= $this->Form->control('document_date', ['type' => 'date', 'class' => 'form-control', 'label' => 'Ngày chứng từ']) ?>
        <?= $this->Form->control('due_date', ['type' => 'date', 'class' => 'form-control', 'label' => 'Ngày đến hạn']) ?>
        <?= $this->Form->control('amount', ['class' => 'form-control', 'label' => 'Số tiền']) ?>
        <?= $this->Form->control('paid_amount', ['class' => 'form-control', 'label' => 'Đã thanh toán']) ?>
        <?= $this->Form->control('remaining_amount', ['class' => 'form-control', 'label' => 'Số tiền còn lại']) ?>
        <?= $this->Form->control('status', ['type' => 'select', 'options' => ['unpaid' => 'Chưa thu', 'partial' => 'Thu 1 phần', 'paid' => 'Đã thu đủ'], 'class' => 'form-control', 'label' => 'Trạng thái']) ?>
    <div class="clearfix bg-light p-3"></div>
    <?= $this->Form->button('Lưu', ['class' => 'btn btn-primary']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
<script>
$( function() {

    if ($('#document-type').val() !== 'Other') {
        var postdataee={};
        var ssurlee = '/journal-entries/refdropdown/'+$('#document-type').val();
        $.get(ssurlee, postdataee,
            function(retdata) {
                var jsondata = jQuery.parseJSON(retdata);
                $('#document-id').autocomplete({source: jsondata}).focus(function () {$(this).autocomplete("search");});
            }
        );	
    }

    $('#document-type').on('change', function() {
        if ($('#document-type').val() !== 'Other') {
            $('#document-id').val('');
            $('#document-number').val('');
            var postdataee={};
            var ssurlee = '/journal-entries/refdropdown/'+$('#document-type').val()+'/';
            $.get(ssurlee, postdataee,
                function(retdata) {
                    var jsondata = jQuery.parseJSON(retdata);
                    $('#document-id').autocomplete({source: jsondata}).focus(function () {$(this).autocomplete("search");});
                }
            );	
        }
    });

});
</script>