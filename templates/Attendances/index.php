<div class="attendances index">
    <h3>Attendances <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
    <a href="<?= $this->Url->build(['action' => 'exportExcel']) ?>" class="btn btn-success btn-sm float-end me-2"><i class="fa fa-file-excel"></i> Excel</a>
    <a href="<?= $this->Url->build(['action' => 'exportPdf']) ?>" class="btn btn-danger btn-sm float-end me-2"><i class="fa fa-file-pdf"></i> PDF</a></h3>
    <div class="paginator"><?= $this->Paginator->numbers() ?></div>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <td colspan="9">
<?php
        use Cake\I18n\FrozenDate;
        $start = FrozenDate::today();
        $end = FrozenDate::today()->subDays(365);
        $dates = [];
        $datesv = [];
        $datest = [];
        $wkdays = [1 => 'Monday',2 => 'Tuesday',3 => 'Wednesday',4 => 'Thursday',5 => 'Friday',6 => 'Saturday',7 => 'Sunday'];
        for ($date = $start; $date >= $end ; $date = $date->subDays(1)) {
            $cnt = $dbattsobj->find('list')->where(['Attendances.work_date' => $date->format('Y-m-d')])->count();
            $dates[] = $date->format('Y-m-d');
            $datesv[] = $date->format('d-m-Y').' ['.$wkdays[$date->dayOfWeek].'] ('.$cnt.')';
            $datest[] = $date->format('d-m-Y').' ['.$wkdays[$date->dayOfWeek].']';
        }
        $options = array_combine($dates, $datesv);
        $optionst = array_combine($dates, $datest);
        echo $this->Form->control('filter_date', ['options' => $options, 'value' => $filter_date, 'label' => 'From Date', 'empty' => '-- Chọn --', 'OnChange' => 'filter_date_chg();', 'class' => 'form-control']);
        echo $this->Form->control('to_date', ['options' => $optionst, 'value' => $to_date, 'label' => 'To Date', 'empty' => '-- Chọn --', 'OnChange' => 'filter_date_chg();', 'class' => 'form-control']);
        echo $this->Form->control('employee', ['options' => $employees, 'value' => $employee, 'empty' => '-- Tất cả --', 'OnChange' => 'filter_emp_chg();', 'class' => 'form-control']);
?>
                </td>
            </tr>
            <tr>
                <th>người lao động</th>
                <th>ngày làm việc</th>
                <th>giờ vào</th>
                <th>giờ ra</th>
                <th>số giờ làm việc</th>
                <th>số giờ làm thêm</th>
                <th>trạng thái</th>
                <th>notes</th>
                <th>Tác vụ</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($records as $r): ?>
            <tr>
                <td><?= (!empty($r->employee_id))? $r->employee->full_name:'' ?></td>
                <td><?= h($r->work_date ?? '') ?></td>
                <td><?= h($r->check_in ?? '') ?></td>
                <td><?= h($r->check_out ?? '') ?></td>
                <td><?= h($r->work_hours ?? '') ?></td>
                <td><?= h($r->overtime_hours ?? '') ?></td>
                <td><?= h($r->status ?? '') ?></td>
                <td><?= h($r->notes ?? '') ?></td>
                <td>
                    <?= $this->Form->postLink('Xóa', ['action' => 'delete', $r->id], ['confirm' => 'Xóa?', 'class' => 'btn btn-sm btn-danger']) ?>
                    <?= $this->Html->link('Sửa', ['action' => 'edit', $r->id], ['class' => 'btn btn-sm btn-warning']) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator"><?= $this->Paginator->numbers() ?></div>
</div>
<script>
function filter_date_chg() {
    window.location.href = '/attendances?filter_date='+$('#filter-date').val()+'&to_date='+$('#to-date').val()+'&employee='+$('#employee').val()+'&time='+$.now();
}
function filter_emp_chg() {
    window.location.href = '/attendances?filter_date='+$('#filter-date').val()+'&to_date='+$('#to-date').val()+'&employee='+$('#employee').val()+'&time='+$.now();
}
</script>