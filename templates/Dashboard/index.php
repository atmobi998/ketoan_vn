<div class="dashboard">
<h3><i class="fa fa-home"></i> Tong quan</h3>
<div class="row">
    <div class="col-md-3"><div class="card bg-primary text-white mb-3"><div class="card-body"><h5><?= $stats['Users'] ?? 0 ?> Người dùng</h5><p>Users</p></div></div></div>
    <div class="col-md-3"><div class="card bg-success text-white mb-3"><div class="card-body"><h5><?= $stats['Products'] ?? 0 ?> Sản phẩm</h5><p>Kho</p></div></div></div>
    <div class="col-md-3"><div class="card bg-warning text-white mb-3"><div class="card-body"><h5><?= $stats['Suppliers'] ?? 0 ?> NCC</h5><p>Phải trả</p></div></div></div>
    <div class="col-md-3"><div class="card bg-info text-white mb-3"><div class="card-body"><h5><?= $stats['Customers'] ?? 0 ?> Khách hàng</h5><p>Phải thu</p></div></div></div>
    <div class="col-md-3"><div class="card bg-info text-white mb-3"><div class="card-body"><h5><?= $stats['Employees'] ?? 0 ?> Nhân viên</h5><p>Tiền lương</p></div></div></div>
    <div class="col-md-3"><div class="card bg-info text-white mb-3"><div class="card-body"><h5><?= $stats['Departments'] ?? 0 ?> Phòng ban</h5><p>Nhân viên</p></div></div></div>
    <div class="col-md-3"><div class="card bg-info text-white mb-3"><div class="card-body"><h5><?= $stats['FixedAssets'] ?? 0 ?> TSCĐ</h5><p>Khấu hao</p></div></div></div>
    <div class="col-md-3"><div class="card bg-info text-white mb-3"><div class="card-body"><h5><?= $stats['JournalEntries'] ?? 0 ?> Sổ cái</h5><p>Chứng từ</p></div></div></div>
</div>
<div class="row">
    <div class="col-md-6"><div class="card"><div class="card-header">Cong no phai tra NCC</div><div class="card-body"><h4><?= number_format($totalSupplierDebt) ?> VND</h4></div></div></div>
    <div class="col-md-6"><div class="card"><div class="card-header">Cong no phai thu KH</div><div class="card-body"><h4><?= number_format($totalCustomerDebt) ?> VND</h4></div></div></div>
</div>
</div>
