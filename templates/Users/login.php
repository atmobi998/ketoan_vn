<div class="row justify-content-center mt-5">
<div class="col-md-4">
<h3><i class="fa fa-sign-in-alt"></i> Dang nhap he thong ke toan</h3>
<?= $this->Form->create() ?>
<?= $this->Form->control('username', ['label' => 'Tai khoan', 'class' => 'form-control']) ?>
<?= $this->Form->control('password', ['label' => 'Mat khau', 'type' => 'password', 'class' => 'form-control']) ?>
<div class="mt-3"><?= $this->Form->button('Dang nhap', ['class' => 'btn btn-primary w-100']) ?></div>
<?= $this->Form->end() ?>
<div style="float:left;"><p class="mt-3 small text-muted">Tai khoan test: superadmin / superadmin123 | admin / admin123 | user / user123</p></div>
</div>
</div>
