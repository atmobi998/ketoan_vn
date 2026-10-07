<?php
        use Cake\I18n\FrozenDate;
        use Cake\I18n\Number;
?>
<div class="journal_entries form">
    <h3>Sửa JournalEntries: <?= h($record->id) ?></h3>
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
    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
<div class="clearfix bg-light p-3"></div>
<div class="journal_entry_lines index">
    <h3>JournalEntryLines <a href="<?= $this->Url->build(['action' => 'adddetail',$record->id]) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
    <a href="<?= $this->Url->build(['controller' => 'JournalEntryLines','action' => 'exportExcel']) ?>" class="btn btn-success btn-sm float-end me-2"><i class="fa fa-file-excel"></i> Excel</a>
    <a href="<?= $this->Url->build(['controller' => 'JournalEntryLines','action' => 'exportPdf']) ?>" class="btn btn-danger btn-sm float-end me-2"><i class="fa fa-file-pdf"></i> PDF</a></h3>
    <table class="table table-bordered table-striped">
        <thead><tr>
                <th>Mã ID</th>
                <th>ID bản ghi nhật ký</th>
                <th>Tài khoản KT</th>
                <th>Nợ</th>
                <th>Có</th>
                <th>diễn giải</th>
                <th>trung tâm chi phí</th>
                <th>Tác vụ</th>
        </tr></thead>
        <tbody>
        <?php 
            $debit=0;
            $credit=0;
            foreach ($records as $r): 
                $debit+=$r->debit;
                $credit+=$r->credit;
        ?>
            <tr>
                <td><?= h($r->id ?? '') ?></td>
                <td><?= (!empty($r->journal_entry_id))? $r->journal_entry->entry_number:'' ?></td>
                <td><?= (!empty($r->chart_of_account_id))? $r->chart_of_account->full_name:'' ?></td>
                <td><?= Number::format($r->debit ?? '') ?></td>
                <td><?= Number::format($r->credit ?? '') ?></td>
                <td><?= h($r->description ?? '') ?></td>
                <td><?= h($r->cost_center_id ?? '') ?></td>
                <td>
                    <?= $this->Form->postLink('Xóa', ['action' => 'deletedetail', $r->id], ['confirm' => 'Xóa?', 'class' => 'btn btn-sm btn-danger']) ?>
                    <?= $this->Html->link('Sửa', ['action' => 'editdetail', $r->id], ['class' => 'btn btn-sm btn-warning']) ?>
                </td>
            </tr>
        <?php 
            endforeach; 
        ?>
        <?php 
           if ($debit > 0 || $credit > 0) {
        ?>
            <tr>
                <td colspan="3"></td>
                <td><b><?= Number::format($debit ?? '') ?></b></td>
                <td><b><?= Number::format($credit ?? '') ?></b></td>
                <td colspan="3"></td>
            </tr>
        <?php 
           }
        ?>
        </tbody>
    </table>
    <div class="paginator"><?= $this->Paginator->numbers() ?></div>
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
            // $('#reference-id').val('');
            var postdataee={};
            var ssurlee = '/journal-entries/refdropdown/'+$('#reference-type').val()+'/';
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