<div class="payrolls index">
    <h3>Payrolls <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
    <a href="<?= $this->Url->build(['action' => 'exportExcel']) ?>" class="btn btn-success btn-sm float-end me-2"><i class="fa fa-file-excel"></i> Excel</a>
    <a href="<?= $this->Url->build(['action' => 'exportPdf']) ?>" class="btn btn-danger btn-sm float-end me-2"><i class="fa fa-file-pdf"></i> PDF</a></h3>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <td colspan="12">
<?php
        use Cake\I18n\FrozenDate;
        use Cake\I18n\Number;
        $start = FrozenDate::today();
        $end = FrozenDate::today()->subDays(365);

        echo $this->Form->control('from_period', ['options' => $options ?? [], 'value' => $from_period, 'label' => 'From Period', 'empty' => '-- Chọn --', 'OnChange' => 'from_period_chg();', 'class' => 'form-control']);
        echo $this->Form->control('to_period', ['options' => $options ?? [], 'value' => $to_period, 'label' => 'To Period', 'empty' => '-- Chọn --', 'OnChange' => 'to_period_chg();', 'class' => 'form-control']);
        echo $this->Html->link('Cập nhật bảng lương', '#', ['OnClick' => 'updatepayroll();', 'class' => 'btn btn-sm btn-success']);
?>
                </td>
            </tr>
            <tr style="text-align:center;">
                <th>mã tính lương</th>
                <th>tháng trả lương</th>
                <th>năm tính lương</th>
                <th>phòng ban</th>
                <th>tổng số nhân viên</th>
                <th>tổng số tiền</th>
                <th>tổng các khoản khấu trừ</th>
                <th>khoản khấu trừ bảo hiểm</th>
                <th>khoản khấu trừ thuế</th>
                <th>tổng giá trị thực nhận</th>
                <th>Tác vụ</th>
            </tr>
        </thead>
        <tbody>
        <?php 
            $total_amount=0;
            $total_deduction=0;
            $insurance_deduction=0;
            $tax_deduction=0;
            $total_net=0;
            $total_employees=0;
            foreach ($records as $r): 
                $total_amount+=$r->total_amount;
                $total_deduction+=$r->total_deduction;
                $insurance_deduction+=$r->insurance_deduction;
                $tax_deduction+=$r->tax_deduction;
                $total_net+=$r->total_net;
                $total_employees+=$r->total_employees;
        ?>
            <tr>
                <td style="text-align:center;"><?= h($r->payroll_code ?? '') ?></td>
                <td style="text-align:center;"><?= h($r->payroll_month ?? '') ?></td>
                <td style="text-align:center;"><?= h($r->payroll_year ?? '') ?></td>
                <td style="text-align:center;"><?= (!empty($r->department_id))? $r->department->full_name:'' ?></td>
                <td style="text-align:center;"><?= h($r->total_employees ?? '') ?></td>
                <td style="text-align:right;"><?= Number::format((int)$r->total_amount ?? '') ?></td>
                <td style="text-align:right;"><?= Number::format((int)$r->total_deduction ?? '') ?></td>
                <td style="text-align:right;"><?= Number::format((int)$r->insurance_deduction ?? '') ?></td>
                <td style="text-align:right;"><?= Number::format((int)$r->tax_deduction ?? '') ?></td>
                <td style="text-align:right;"><?= Number::format((int)$r->total_net ?? '') ?></td>
                <td>
                    <?= $this->Form->postLink('Xóa', ['action' => 'delete', $r->id], ['confirm' => 'Xóa?', 'class' => 'btn btn-sm btn-danger']) ?>
                    <?= $this->Html->link('In', ['action' => 'view', $r->id], ['class' => 'btn btn-sm btn-success','target'=>'_new']) ?>
                    <?= $this->Html->link('Chi qua NH', ['action' => 'payViaBankIdx', $r->id], ['class' => 'btn btn-success']);?>
                    <?= $this->Html->link('Sửa', ['action' => 'edit', $r->id], ['class' => 'btn btn-sm btn-warning']) ?>
                </td>
            </tr>
        <?php endforeach; ?>
            <tr style="font-weight:bold;text-align:right;">
                <td colspan="4"></td>
                <td style="text-align:center;"><?= h($total_employees ?? '') ?></td>
                <td><?= Number::format((int)$total_amount ?? '') ?></td>
                <td><?= Number::format((int)$total_deduction ?? '') ?></td>
                <td><?= Number::format((int)$insurance_deduction ?? '') ?></td>
                <td><?= Number::format((int)$tax_deduction ?? '') ?></td>
                <td><?= Number::format((int)$total_net ?? '') ?></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <div class="paginator"><?= $this->Paginator->numbers() ?></div>
</div>
<script>
function updatepayroll() {
	var postdata={};
    postdata['from_period']=$('#from-period').val();
    postdata['to_period']=$('#to-period').val();
	var ssurl = '/payrolls/updatepayroll/'+$('#from-period').val();
    $('#ajaxdoing').show();
	$.post(ssurl, postdata,
		function(retdata) {
            $('#ajaxdoing').hide();
            setTimeout(function() {
                alert('Đã cập nhật bảng lương kỳ '+postdata['from_period']);
                window.location.reload();
            }, 200);
		}
	);
} 

function from_period_chg() {
    window.location.href = '/payrolls?from_period='+$('#from-period').val()+'&to_period='+$('#to-period').val()+'&time='+$.now();
}
function to_period_chg() {
    window.location.href = '/payrolls?from_period='+$('#from-period').val()+'&to_period='+$('#to-period').val()+'&time='+$.now();
}
</script>
