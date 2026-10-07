<?php
        use Cake\I18n\FrozenDate;
        use Cake\I18n\Number;
?>
<div class="boms form">
    <h3>Sửa Boms: <?= h($record->id) ?></h3>
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
    <?= $this->Form->button('Cập nhật', ['class' => 'btn btn-warning']) ?>
    <?= $this->Html->link('Quay lại', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>
</div>
<div class="clearfix bg-light p-3"></div>
<div class="bom_details index">
    <h3>BomDetails <a href="<?= $this->Url->build(['action' => 'adddetail',$record->id]) ?>" class="btn btn-primary btn-sm float-end">+ Thêm</a>
    <a href="<?= $this->Url->build(['controller' => 'BomDetails','action' => 'exportExcel']) ?>" class="btn btn-success btn-sm float-end me-2"><i class="fa fa-file-excel"></i> Excel</a>
    <a href="<?= $this->Url->build(['controller' => 'BomDetails','action' => 'exportPdf']) ?>" class="btn btn-danger btn-sm float-end me-2"><i class="fa fa-file-pdf"></i> PDF</a></h3>
    <table class="table table-bordered table-striped">
        <thead><tr>
                <th>Mã ID</th>
                <th>BOM</th>
                <th>nguyên vật liệu</th>
                <th>số lượng</th>
                <th>đơn vị</th>
                <th>tỷ lệ lãng phí</th>
                <th>chi phí mỗi đơn vị</th>
                <th>tổng chi phí</th>
                <th>Tác vụ</th>
        </tr></thead>
        <tbody>
        <?php 
            $total_cost=0;
            foreach ($records as $r): 
                $total_cost+=$r->total_cost;
        ?>
            <tr>
                <td><?= h($r->id ?? '') ?></td>
                <td><?= (!empty($r->bom_id))? $r->bom->bom_code:'' ?></td>
                <td><?= (!empty($r->material_id))? $r->product->full_name:'' ?></td>
                <td><?= h($r->quantity ?? '') ?></td>
                <td><?= (!empty($r->unit_id))? $r->unit->name:'' ?></td>
                <td><?= h($r->waste_rate ?? '') ?></td>
                <td style="text-align:right;"><?= Number::format($r->unit_cost ?? '') ?></td>
                <td style="text-align:right;"><?= Number::format($r->total_cost ?? '') ?></td>
                <td>
                    <?= $this->Form->postLink('Xóa', ['action' => 'deletedetail', $r->id], ['confirm' => 'Xóa?', 'class' => 'btn btn-sm btn-danger']) ?>
                    <?= $this->Html->link('Sửa', ['action' => 'editdetail', $r->id], ['class' => 'btn btn-sm btn-warning']) ?>
                </td>
            </tr>
        <?php 
            endforeach; 
        ?>
        <?php 
            if ($total_cost>0) {
        ?>
            <tr>
                <td colspan="7"></td>
                <td style="text-align:right;"><b><?= Number::format($total_cost ?? '') ?></b></td>
                <td></td>
            </tr>
        <?php 
            }
        ?>
        </tbody>
    </table>
    <div class="paginator"><?= $this->Paginator->numbers() ?></div>
</div>
