<?php
/**
 * @var \App\View\AppView $this
 * @var array $report
 * @var array $detail
 * @var \App\Model\Entity\AccountingPeriod $fromPeriod
 * @var \App\Model\Entity\AccountingPeriod $toPeriod
 */
$this->assign('title', 'Báo cáo lưu chuyển tiền tệ - TT200');
?>
<div class="reports cash-flow">
    <div class="card mb-3">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fa fa-water"></i> Báo cáo lưu chuyển tiền tệ (Trực tiếp) - Mẫu B03-DN - TT200</h4>
            <small>Từ <?= h($fromPeriod->name) ?> đến <?= h($toPeriod->name) ?> (<?= h($report['from_date']) ?> - <?= h($report['to_date']) ?>)</small>
        </div>
        <div class="card-body">
            <form method="get" class="row g-3 mb-3">
                <div class="col-md-3">
                    <label>Từ kỳ</label>
                    <?= $this->Form->select('from_period', $options, ['value' => $from_period, 'class' => 'form-control']) ?>
                </div>
                <div class="col-md-3">
                    <label>Đến kỳ</label>
                    <?= $this->Form->select('to_period', $options, ['value' => $to_period, 'class' => 'form-control']) ?>
                </div>
                <div class="col-md-6 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Xem</button>
                    <a href="?from_period=<?= h($from_period) ?>&to_period=<?= h($to_period) ?>&export=excel" class="btn btn-success"><i class="fa fa-file-excel"></i> Excel</a>
                    <a href="?from_period=<?= h($from_period) ?>&to_period=<?= h($to_period) ?>&export=pdf" class="btn btn-danger"><i class="fa fa-file-pdf"></i> PDF</a>
                    <a href="/gl-status" class="btn btn-secondary">GL Status</a>
                </div>
            </form>

            <!-- Tổng quan tiền mặt -->
            <div class="row mb-3">
                <div class="col-md-3"><div class="card bg-success text-white"><div class="card-body"><h6>Thu tiền mặt (PT)</h6><h4><?= $this->Number->format($detail['cash_in']) ?>đ</h4></div></div></div>
                <div class="col-md-3"><div class="card bg-danger text-white"><div class="card-body"><h6>Chi tiền mặt (PC)</h6><h4><?= $this->Number->format($detail['cash_out']) ?>đ</h4></div></div></div>
                <div class="col-md-3"><div class="card bg-info text-white"><div class="card-body"><h6>Thu tiền NH (BC)</h6><h4><?= $this->Number->format($detail['bank_in']) ?>đ</h4></div></div></div>
                <div class="col-md-3"><div class="card bg-warning"><div class="card-body"><h6>Chi tiền NH (BN)</h6><h4><?= $this->Number->format($detail['bank_out']) ?>đ</h4></div></div></div>
            </div>

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th style="width:60px">Mã số</th>
                        <th>Chỉ tiêu</th>
                        <th style="width:150px" class="text-end">Kỳ này</th>
                        <th style="width:100px">TM</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="table-primary"><td colspan="4"><strong>I. LƯU CHUYỂN TIỀN TỪ HOẠT ĐỘNG KINH DOANH</strong></td></tr>
                    <?php foreach (['01','02','03','04','05','06','07'] as $code): $line = $report['lines'][$code] ?? null; if (!$line) continue; ?>
                    <tr>
                        <td class="text-center"><?= h($code) ?></td>
                        <td><?= h($line['label']) ?></td>
                        <td class="text-end <?= $line['type']=='out' ? 'text-danger' : 'text-success' ?>">
                            <?= $line['type']=='out' ? '(' : '' ?><?= $this->Number->format($line['amount']) ?><?= $line['type']=='out' ? ')' : '' ?>
                        </td>
                        <td></td>
                    </tr>
                    <?php endforeach; ?>
                    <tr class="table-info fw-bold">
                        <td class="text-center">20</td>
                        <td>Lưu chuyển tiền thuần từ hoạt động kinh doanh</td>
                        <td class="text-end <?= $report['summary']['net_operating']<0?'text-danger':'' ?>"><?= $this->Number->format($report['summary']['net_operating']) ?></td>
                        <td></td>
                    </tr>

                    <tr class="table-primary"><td colspan="4"><strong>II. LƯU CHUYỂN TIỀN TỪ HOẠT ĐỘNG ĐẦU TƯ</strong></td></tr>
                    <?php foreach (['21','22','23','24','25','26','27'] as $code): $line = $report['lines'][$code] ?? null; if (!$line) continue; ?>
                    <tr>
                        <td class="text-center"><?= h($code) ?></td>
                        <td><?= h($line['label']) ?></td>
                        <td class="text-end <?= $line['type']=='out' ? 'text-danger' : 'text-success' ?>">
                            <?= $line['type']=='out' ? '(' : '' ?><?= $this->Number->format($line['amount']) ?><?= $line['type']=='out' ? ')' : '' ?>
                        </td>
                        <td></td>
                    </tr>
                    <?php endforeach; ?>
                    <tr class="table-info fw-bold">
                        <td class="text-center">30</td>
                        <td>Lưu chuyển tiền thuần từ hoạt động đầu tư</td>
                        <td class="text-end"><?= $this->Number->format($report['summary']['net_investing']) ?></td>
                        <td></td>
                    </tr>

                    <tr class="table-primary"><td colspan="4"><strong>III. LƯU CHUYỂN TIỀN TỪ HOẠT ĐỘNG TÀI CHÍNH</strong></td></tr>
                    <?php foreach (['31','32','33','34','35','36'] as $code): $line = $report['lines'][$code] ?? null; if (!$line) continue; ?>
                    <tr>
                        <td class="text-center"><?= h($code) ?></td>
                        <td><?= h($line['label']) ?></td>
                        <td class="text-end <?= $line['type']=='out' ? 'text-danger' : 'text-success' ?>">
                            <?= $line['type']=='out' ? '(' : '' ?><?= $this->Number->format($line['amount']) ?><?= $line['type']=='out' ? ')' : '' ?>
                        </td>
                        <td></td>
                    </tr>
                    <?php endforeach; ?>
                    <tr class="table-info fw-bold">
                        <td class="text-center">40</td>
                        <td>Lưu chuyển tiền thuần từ hoạt động tài chính</td>
                        <td class="text-end"><?= $this->Number->format($report['summary']['net_financing']) ?></td>
                        <td></td>
                    </tr>

                    <tr class="table-success fw-bold">
                        <td class="text-center">50</td>
                        <td>Lưu chuyển tiền thuần trong kỳ (20+30+40)</td>
                        <td class="text-end"><?= $this->Number->format($report['summary']['net_cash_flow']) ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="text-center">60</td>
                        <td>Tiền và tương đương tiền đầu kỳ</td>
                        <td class="text-end"><?= $this->Number->format($report['summary']['begin_balance']) ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="text-center">61</td>
                        <td>Ảnh hưởng của thay đổi tỷ giá</td>
                        <td class="text-end">0</td>
                        <td></td>
                    </tr>
                    <tr class="table-warning fw-bold">
                        <td class="text-center">70</td>
                        <td>Tiền và tương đương tiền cuối kỳ (50+60+61) = TK 110</td>
                        <td class="text-end"><?= $this->Number->format($report['summary']['end_balance']) ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="2">Đối chiếu: Đầu kỳ + Thuần = <?= $this->Number->format($report['summary']['check']) ?> (phải = Cuối kỳ <?= $this->Number->format($report['summary']['end_balance']) ?>)</td>
                        <td colspan="2" class="text-center">
                            <?php if (abs($report['summary']['check'] - $report['summary']['end_balance']) < 1): ?>
                                <span class="badge bg-success">Khớp</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Lệch <?= $this->Number->format($report['summary']['check'] - $report['summary']['end_balance']) ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-4">
                <h5>Chi tiết hạch toán đối ứng 111/112</h5>
                <?php foreach ($report['lines'] as $code => $line): if (empty($line['details'])) continue; ?>
                <div class="card mb-2">
                    <div class="card-header"><?= h($code) ?> - <?= h($line['label']) ?> (<?= $this->Number->format($line['amount']) ?>)</div>
                    <div class="card-body p-0">
                        <table class="table table-sm mb-0">
                            <tr><th>Ngày</th><th>Số CT</th><th>Diễn giải</th><th>TK đối ứng</th><th class="text-end">Tiền</th></tr>
                            <?php foreach (array_slice($line['details'],0,20) as $d): ?>
                            <tr><td><?= h($d['date']) ?></td><td><?= h($d['number']) ?></td><td><?= h($d['desc']) ?></td><td><?= h($d['account']) ?></td><td class="text-end"><?= $this->Number->format($d['amount']) ?></td></tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
