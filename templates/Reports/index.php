<h3>Bao cao</h3>
<div class="row"><?php foreach ($reports as $r): ?>
    <div class="col-md-4 mb-3"><div class="card">
        <div class="card-body"><h5><i class="fa <?= $r['icon'] ?>"></i> <?= $r['name'] ?></h5><a href="<?= $r['url'] ?>" class="btn btn-primary btn-sm">Xem</a> <a href="<?= $r['url'] ?>?export=excel" class="btn btn-success btn-sm">Excel</a> <a href="<?= $r['url'] ?>?export=pdf" class="btn btn-danger btn-sm">PDF</a>
    </div>
</div>
</div><?php endforeach; ?></div>