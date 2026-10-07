<?php
        use Cake\I18n\FrozenDate;
        use Cake\I18n\Number;
?>
<div class="routings index">
    <h3>Routings 
    <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
    <a href="<?= $this->Url->build(['action' => 'exportExcel']) ?>" class="btn btn-success btn-sm float-end me-2"><i class="fa fa-file-excel"></i> Excel</a>
    <a href="<?= $this->Url->build(['action' => 'exportPdf']) ?>" class="btn btn-danger btn-sm float-end me-2"><i class="fa fa-file-pdf"></i> PDF</a></h3>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <td colspan="9">
<?php
        echo $this->Form->control('product_id', ['options' => $options ?? [], 'value' => $product_id, 'label' => 'Product', 'empty' => '-- Chọn --', 'OnChange' => 'product_chg();', 'class' => 'form-control']);
?>
                </td>
            </tr>
            <tr>
                <th>Mã ID</th>
                <th>sản phẩm</th>
                <th>trình tự vận hành</th>
                <th>trung tâm làm việc</th>
                <th>thời gian thiết lập</th>
                <th>thời gian chạy</th>
                <th>tên thao tác</th>
                <th>chi phí</th>
                <th>Tác vụ</th>
        </tr></thead>
        <tbody>
        <?php 
            $cost=0;
            foreach ($records as $r): 
                $cost+=$r->cost;
        ?>
            <tr>
                <td><?= h($r->id ?? '') ?></td>
                <td><?= (!empty($r->product_id))? $r->product->full_name:'' ?></td>
                <td><?= h($r->operation_sequence ?? '') ?></td>
                <td><?= (!empty($r->work_center_id))? $r->work_center->full_name:'' ?></td>
                <td><?= h($r->setup_time ?? '') ?></td>
                <td><?= h($r->run_time ?? '') ?></td>
                <td><?= h($r->operation_name ?? '') ?></td>
                <td><?= Number::format($r->cost ?? '') ?></td>
                <td>
                    <?= $this->Form->postLink('Xóa', ['action' => 'delete', $r->id], ['confirm' => 'Xóa?', 'class' => 'btn btn-sm btn-danger']) ?>
                    <?= $this->Html->link('Sửa', ['action' => 'edit', $r->id], ['class' => 'btn btn-sm btn-warning']) ?>
                </td>
            </tr>
        <?php 
            endforeach; 
        ?>
        <?php 
            if ($cost>0) {
        ?>
            <tr>
                <td colspan="7"></td>
                <td><b><?= Number::format($cost ?? '') ?></b></td>
                <td></td>
        <?php 
            }
        ?>
        </tbody>
    </table>
    <div class="paginator"><?= $this->Paginator->numbers() ?></div>
</div>
<script>
function product_chg() {
    window.location.href = '/routings?product_id='+$('#product-id').val()+'&time='+$.now();
}
</script>
