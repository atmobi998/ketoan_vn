<div class="gl-status index content">
    <h3>Hạch Toán Tự Động</h3>
    <p class="text-muted">Tổng quan chứng từ chưa vào sổ</p>

    <div class="row">
        <div class="col-md-3">
            <div class="card bg-warning text-dark mb-3">
                <div class="card-header">Nhập kho (GR)</div>
                <div class="card-body">
                    <h2><?= $grUnposted ?></h2>
                    <small>chưa hạch toán</small><br>
                    <small>Tổng: <?= $this->Number->format($grTotal->total ?? 0) ?> VNĐ</small><br>
                    <small>Đã HT: <?= $postedCounts['GoodsReceipt'] ?></small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white mb-3">
                <div class="card-header">Xuất kho (DN) - Giá vốn</div>
                <div class="card-body">
                    <h2><?= $dnUnposted ?></h2>
                    <small>chưa hạch toán</small><br>
                    <small>Tổng: <?= $this->Number->format($dnTotal->total ?? 0) ?> VNĐ</small><br>
                    <small>Đã HT: <?= $postedCounts['DeliveryNote'] ?></small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white mb-3">
                <div class="card-header">HĐ Bán (SINV)</div>
                <div class="card-body">
                    <h2><?= $siUnposted ?></h2>
                    <small>chưa hạch toán</small><br>
                    <small>Đã HT: <?= $postedCounts['SalesInvoice'] ?></small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-primary text-white mb-3">
                <div class="card-header">HĐ Mua (PINV)</div>
                <div class="card-body">
                    <h2><?= $piUnposted ?></h2>
                    <small>chưa hạch toán</small><br>
                    <small>Đã HT: <?= $postedCounts['PurchaseInvoice'] ?></small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-primary text-white mb-3">
                <div class="card-header">Bảng lương</div>
                <div class="card-body">
                    <h2><?= $prUnposted ?></h2>
                    <small>chưa hạch toán</small><br>
                    <small>Đã HT: <?= $postedCounts['Payroll'] ?></small>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4 border-danger">
        <div class="card-body text-center">
            <?php
            $totalUnposted = $grUnposted + $dnUnposted + $piUnposted + $siUnposted + $prUnposted;
            if ($totalUnposted > 0):
            ?>
                <h4>Có <span class="badge bg-danger"><?= $totalUnposted ?></span> chứng từ chưa vào sổ cái</h4>
                <p>Nhấn nút dưới để tự động sinh bút toán: NK-, XK-, BH-, MH-</p>
                <?= $this->Form->create(null, ['url' => ['action' => 'postAll']]) ?>
                <?= $this->Form->button(
                    '<i class="fas fa-bolt"></i> HẠCH TOÁN TOÀN BỘ',
                    ['class' => 'btn btn-danger btn-lg', 'escapeTitle' => false, 'confirm' => "Chắc chắn hạch toán $totalUnposted chứng từ?"]
                ) ?>
                <?= $this->Form->end() ?>
            <?php else: ?>
                <h4 class="text-success"><i class="fas fa-check-circle"></i> Tất cả đã vào sổ cái!</h4>
                <p>Không còn chứng từ nào chưa hạch toán. Sổ cái đã cân.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="card">
        <div class="card-header">15 Bút toán gần nhất</div>
        <div class="card-body">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>Số CT</th>
                        <th>Ngày</th>
                        <th>Diễn giải</th>
                        <th>Loại</th>
                        <th class="text-end">Tổng tiền</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentEntries as $je): ?>
                    <tr>
                        <td><?= h($je->entry_number) ?></td>
                        <td><?= h($je->entry_date) ?></td>
                        <td><?= h($je->description) ?></td>
                        <td><span class="badge bg-secondary"><?= h($je->reference_type) ?> #<?= h($je->reference_id) ?></span></td>
                        <td class="text-end"><?= $this->Number->format($je->total_debit) ?></td>
                        <td><span class="badge bg-success"><?= h($je->status) ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        <?= $this->Html->link('← Về trang chủ', '/', ['class' => 'btn btn-secondary']) ?>
        <?= $this->Html->link('Xem Sổ Cái', ['controller' => 'JournalEntries', 'action' => 'index'], ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<style>
.card h2 { font-size: 2.5rem; margin: 0; }
</style>
