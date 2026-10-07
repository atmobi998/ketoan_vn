<?php
        $mainMenu = [
            ['label' => 'Dashboard', 'icon' => 'fa-home', 'url' => '/', 'children' => []],
            ['label' => 'Danh mục chung', 'icon' => 'fa-sitemap', 'children' => [
                ['label' => 'Tiền tệ', 'icon' => 'fa-coins', 'url' => '/currencies'],
                ['label' => 'Tỉ giá hối đoái', 'icon' => 'fa-exchange-alt', 'url' => '/exchange_rates'],
                ['label' => 'Đơn vị tính', 'icon' => 'fa-balance-scale', 'url' => '/units'],
                ['label' => 'Kho hàng', 'icon' => 'fa-warehouse', 'url' => '/warehouses'],
                ['label' => 'Nhóm sản phẩm', 'icon' => 'fa-tags', 'url' => '/product-categories'],
                ['label' => 'Sản phẩm', 'icon' => 'fa-box', 'url' => '/products'],
                ['label' => 'TK Kế toán', 'icon' => 'fa-list-ol', 'url' => '/chart-of-accounts'],
                ['label' => 'Danh mục thuế', 'icon' => 'fa-tags', 'url' => '/tax_rates'],
                ['label' => 'Kỳ kế toán', 'icon' => 'fa-calendar', 'url' => '/accounting-periods'],
                ['label' => 'Trung tâm chi phí', 'icon' => 'fa-bullseye', 'url' => '/cost-centers'],
            ]],
            ['label' => 'Vốn bằng tiền', 'icon' => 'fa-money-bill-wave', 'children' => [
                ['label' => 'TK Ngân hàng', 'icon' => 'fa-university', 'url' => '/bank-accounts'],
                ['label' => 'Thu tiền mặt', 'icon' => 'fa-hand-holding-usd', 'url' => '/cash-receipts'],
                ['label' => 'Chi tiền mặt', 'icon' => 'fa-money-bill', 'url' => '/cash-payments'],
                ['label' => 'Thu tiền gửi', 'icon' => 'fa-piggy-bank', 'url' => '/bank-receipts'],
                ['label' => 'Chi tiền gửi', 'icon' => 'fa-credit-card', 'url' => '/bank-payments'],
                ['label' => 'Giao dịch NH', 'icon' => 'fa-exchange-alt', 'url' => '/bank-transactions'],
            ]],
            ['label' => 'Mua hàng & Phải trả', 'icon' => 'fa-shopping-cart', 'children' => [
                ['label' => 'Nhà cung cấp', 'icon' => 'fa-truck', 'url' => '/suppliers'],
                ['label' => 'Đơn đặt mua', 'icon' => 'fa-file-invoice', 'url' => '/purchase-orders'],
                ['label' => 'Nhập kho', 'icon' => 'fa-dolly', 'url' => '/goods-receipts'],
                ['label' => 'Hóa đơn mua', 'icon' => 'fa-receipt', 'url' => '/purchase-invoices'],
                ['label' => 'Công nợ NCC', 'icon' => 'fa-file-invoice-dollar', 'url' => '/supplier-debts'],
                ['label' => 'Thanh toán NCC', 'icon' => 'fa-hand-holding', 'url' => '/supplier-payments'],
            ]],
            ['label' => 'Bán hàng & Phải thu', 'icon' => 'fa-cash-register', 'children' => [
                ['label' => 'Khách hàng', 'icon' => 'fa-users', 'url' => '/customers'],
                ['label' => 'Đơn bán hàng', 'icon' => 'fa-file-contract', 'url' => '/sales-orders'],
                ['label' => 'Xuất kho', 'icon' => 'fa-shipping-fast', 'url' => '/delivery-notes'],
                ['label' => 'Hóa đơn bán', 'icon' => 'fa-file-invoice-dollar', 'url' => '/sales-invoices'],
                ['label' => 'Công nợ KH', 'icon' => 'fa-hand-holding-usd', 'url' => '/customer-debts'],
                ['label' => 'Thu tiền KH', 'icon' => 'fa-donate', 'url' => '/customer-payments'],
            ]],
            ['label' => 'Quản lý kho', 'icon' => 'fa-boxes', 'children' => [
                ['label' => 'Tồn kho', 'icon' => 'fa-cubes', 'url' => '/inventories'],
                ['label' => 'Giao dịch kho', 'icon' => 'fa-exchange-alt', 'url' => '/stock-transactions'],
                ['label' => 'Chuyển kho', 'icon' => 'fa-truck-loading', 'url' => '/stock-transfers'],
                ['label' => 'Kiểm kê', 'icon' => 'fa-clipboard-check', 'url' => '/stock-adjustments'],
            ]],
            ['label' => 'TSCĐ & CCDC', 'icon' => 'fa-building', 'children' => [
                ['label' => 'Nhóm TSCĐ', 'icon' => 'fa-layer-group', 'url' => '/asset-categories'],
                ['label' => 'TSCĐ', 'icon' => 'fa-desktop', 'url' => '/fixed-assets'],
                ['label' => 'Khấu hao', 'icon' => 'fa-chart-line', 'url' => '/asset-depreciations'],
                ['label' => 'Thanh lý TSCĐ', 'icon' => 'fa-remove', 'url' => '/asset_disposals'],
                ['label' => 'Nhóm CCDC', 'icon' => 'fa-layer-group', 'url' => '/tool_categories'],
                ['label' => 'CCDC', 'icon' => 'fa-tools', 'url' => '/tools'],
                ['label' => 'Phân bổ CCDC', 'icon' => 'fa-tasks', 'url' => '/tool-allocations'],
            ]],
            ['label' => 'Nhân sự & Lương', 'icon' => 'fa-user-tie', 'children' => [
                ['label' => 'Phòng ban', 'icon' => 'fa-sitemap', 'url' => '/departments'],
                ['label' => 'Chức vụ', 'icon' => 'fa-id-badge', 'url' => '/positions'],
                ['label' => 'Nhân viên', 'icon' => 'fa-user-friends', 'url' => '/employees'],
                ['label' => 'Chấm công', 'icon' => 'fa-clock', 'url' => '/attendances'],
                ['label' => 'Bảng lương', 'icon' => 'fa-money-check-alt', 'url' => '/payrolls'],
                ['label' => 'Chi tiết lương', 'icon' => 'fa-file-invoice-dollar', 'url' => '/payroll-details'],
                ['label' => 'HĐLĐ', 'icon' => 'fa-file-contract', 'url' => '/employment_contracts'],
            ]],
            ['label' => 'Sản xuất & Giá thành', 'icon' => 'fa-industry', 'children' => [
                ['label' => 'Định mức BOM', 'icon' => 'fa-project-diagram', 'url' => '/boms'],
                ['label' => 'Công đoạn', 'icon' => 'fa-cogs', 'url' => '/work-centers'],
                ['label' => 'Định tuyến', 'icon' => 'fa-route', 'url' => '/routings'],
                ['label' => 'Lệnh SX', 'icon' => 'fa-industry', 'url' => '/production-orders'],
                ['label' => 'Tính giá thành', 'icon' => 'fa-calculator', 'url' => '/cost-calculations'],
            ]],
            ['label' => 'Kế toán tổng hợp', 'icon' => 'fa-book', 'children' => [
                ['label' => 'Bút toán', 'icon' => 'fa-book-open', 'url' => '/journal-entries'],
                ['label' => 'Dòng bút toán', 'icon' => 'fa-list', 'url' => '/journal-entry-lines'],
                ['label' => 'Hạch toán tự động', 'icon' => 'fa-check', 'url' => '/gl-status'],
                ['label' => 'Sổ cái', 'icon' => 'fa-book-reader', 'url' => '/reports/general-ledger'],
                ['label' => 'Cân đối thử', 'icon' => 'fa-balance-scale', 'url' => '/reports/trial-balance'],
                ['label' => 'BCTC', 'icon' => 'fa-file-alt', 'url' => '/reports/financial'],
                ['label' => 'BCLCTT', 'icon' => 'fa-water', 'url' => '/reports/cash-flow'],
            ]],
            ['label' => 'Báo cáo', 'icon' => 'fa-chart-bar', 'children' => [
                ['label' => 'Xuất Excel', 'icon' => 'fa-file-excel', 'url' => '/reports/excel'],
                ['label' => 'Xuất PDF', 'icon' => 'fa-file-pdf', 'url' => '/reports/pdf'],
            ]],
            ['label' => 'Hệ thống', 'icon' => 'fa-cogs', 'children' => [
                ['label' => 'Người dùng', 'icon' => 'fa-users-cog', 'url' => '/users'],
                ['label' => 'Vai trò', 'icon' => 'fa-user-shield', 'url' => '/roles'],
            ]],
        ];

?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->fetch('title') ?> - Ke toan VN</title>
    <?= $this->Html->meta('icon') ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.14.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.14.1/jquery-ui.min.js"></script>

    <style>
        body { font-family: 'Segoe UI', sans-serif; transition: all 0.3s; }
        .sidebar { min-height: 100vh; background: #2c3e50; color: #ecf0f1; width: 280px; position: fixed; overflow-y: auto; transition: all 0.3s ease; z-index: 1040; }
        .sidebar.collapsed { width: 70px; }
        .sidebar .nav-link { color: #bdc3c7; padding: 8px 16px; white-space: nowrap; overflow: hidden; transition: all 0.3s; display: flex; align-items: center; }
        .sidebar .nav-link:hover { color: #fff; background: #34495e; }
        .sidebar .submenu { padding-left: 20px; font-size: 0.9rem; }
        .sidebar.collapsed .submenu { display: none !important; }
        .sidebar.collapsed .menu-label { display: none; }
        .sidebar.collapsed .brand-text, .sidebar.collapsed .brand-sub { display: none; }
        .sidebar.collapsed .nav-link span { display: none; }
        .sidebar.collapsed .nav-link { justify-content: center; padding: 12px 5px; }
        .sidebar.collapsed .nav-link i { margin: 0 !important; font-size: 1.2rem; }
        .main-content { margin-left: 280px; padding: 20px; transition: all 0.3s ease; }
        .main-content.expanded { margin-left: 70px; }
        .menu-group { border-top: 1px solid #34495e; margin-top: 8px; }
        .menu-label { font-weight: bold; font-size: 0.8rem; text-transform: uppercase; color: #95a5a6; padding: 12px 16px 6px; cursor: pointer; user-select: none; display: flex; justify-content: space-between; align-items: center; transition: all 0.2s; }
        .menu-label:hover { color: #ecf0f1; background: #34495e; }
        .menu-label i.toggle-icon { font-size: 0.7rem; transition: transform 0.3s; }
        .menu-label.collapsed i.toggle-icon { transform: rotate(-90deg); }
        .submenu-container .nav-link { padding: 6px 16px 6px 38px; font-size: 0.85rem; }
        .submenu-container .nav-link.active { background: #34495e; color: #fff; border-left: 3px solid #3498db; }
        .sidebar::-webkit-scrollbar { width: 5px; }
        .sidebar::-webkit-scrollbar-thumb { background: #34495e; border-radius: 3px; }
        .toggle-btn { border: none; background: #34495e; color: #fff; padding: 8px 12px; border-radius: 4px; cursor: pointer; }
        .toggle-btn:hover { background: #2c3e50; }
        .sidebar.collapsed .nav-link { position: relative; }
        .sidebar.collapsed .nav-link:hover::after { content: attr(data-title); position: absolute; left: 70px; top: 50%; transform: translateY(-50%); background: #2c3e50; color: #fff; padding: 6px 12px; border-radius: 4px; white-space: nowrap; z-index: 1050; font-size: 0.85rem; box-shadow: 0 2px 10px rgba(0,0,0,0.3); }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); width: 280px; }
            .sidebar.mobile-show { transform: translateX(0); }
            .sidebar.collapsed { transform: translateX(-100%); width: 280px; }
            .main-content, .main-content.expanded { margin-left: 0; }
        }
        .paginator {white-space: nowrap; overflow-x: auto;list-style: none;padding: 10px;}
        .paginator li {display: inline-block;padding: 10px;border-radius: 3px;margin: 5px;}
        .paginator li:hover {background-color: grey;}
        .paginator li.active a{color: black !important;}
        .form {max-width: 900px;width: 100%;}
        .clearfix {max-width: 900px;}
        .form label {font-weight: bold;}
        .form-control {max-width: 400px;width: 100%;}
        .form-select {max-width: 400px;width: 100%;}
        .input {max-width: 400px;width: 100%;float:left;margin:10px;}
        .btn {float:right;margin:5px; width:auto;min-width: 60px;}
        .ajaxdoing {opacity: 1.0;position: fixed;left: 10px;top: 10px;width: 30px;height: 30px;display: none;z-index: 10127}
    </style>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
<div id="ajaxdoing" class="ajaxdoing" title="đang gửi Y/C"><img src="/images/ajax-loader.gif" /></div>
<div class="sidebar collapsed" id="sidebar">
    <div class="p-3 text-center border-bottom border-secondary">
        <h5><i class="fa fa-calculator"></i> <span class="brand-text">KE TOAN VN</span></h5>
        <small class="brand-sub">VAS - Doanh nghiep</small>
    </div>
<?php $user = $this->request->getAttribute('identity'); ?>
<?php if ($user): ?>
    <nav class="nav flex-column" id="mainMenu">
        <?php $groupIdx = 0; foreach ($mainMenu as $m): ?>
            <?php if (empty($m['children'])): ?>
                <a class="nav-link" data-title="<?= h($m['label']) ?>" href="<?= $this->Url->build($m['url'] ?? '#') ?>"><i class="fa <?= $m['icon'] ?? 'fa-circle' ?> me-2"></i> <span><?= $m['label'] ?></span></a>
            <?php else: ?>
                <?php $groupId = 'menuGroup' . $groupIdx++; ?>
                <div class="menu-group">
                    <div class="menu-label" data-bs-toggle="collapse" data-bs-target="#<?= $groupId ?>" aria-expanded="true" data-group="<?= $groupId ?>">
                        <span><i class="fa <?= $m['icon'] ?> me-2"></i> <span><?= $m['label'] ?></span></span>
                        <i class="fa fa-chevron-down toggle-icon"></i>
                    </div>
                    <div class="submenu-container collapse show" id="<?= $groupId ?>">
                        <?php foreach ($m['children'] as $child): ?>
                            <a class="nav-link submenu" data-title="<?= h($child['label']) ?>" href="<?= $this->Url->build($child['url']) ?>"><i class="fa <?= $child['icon'] ?> me-2"></i> <span><?= $child['label'] ?></span></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </nav>
<?php endif; ?>
</div>
<div class="main-content expanded" id="mainContent">
    <nav class="navbar navbar-light bg-light mb-3 rounded shadow-sm">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <button class="toggle-btn me-3" id="sidebarToggle" title="Toggle sidebar"><i class="fa fa-bars"></i></button>
                <span class="navbar-brand mb-0 h6">He thong ke toan VN</span>
            </div>
            <div>
                <?php $user = $this->request->getAttribute('identity'); ?>
                <?php if ($user): ?>
                    <span class="me-3"><i class="fa fa-user"></i> <?= h($user->full_name ?? $user->username) ?></span>
                    <a href="/users/logout" class="btn btn-sm btn-outline-danger">Dang xuat</a>
                <?php else: ?>
                    <a href="/users/login" class="btn btn-sm btn-primary">Dang nhap</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const toggleBtn = document.getElementById('sidebarToggle');
    let isCollapsed = localStorage.getItem('sidebarCollapsed');
    if (isCollapsed === null) { isCollapsed = 'true'; }
    function applySidebarState(collapsed) {
        if (collapsed === 'true') { sidebar.classList.add('collapsed'); mainContent.classList.add('expanded'); }
        else { sidebar.classList.remove('collapsed'); mainContent.classList.remove('expanded'); }
    }
    applySidebarState(isCollapsed);
    toggleBtn.addEventListener('click', function() {
        const currentlyCollapsed = sidebar.classList.contains('collapsed');
        const newState = currentlyCollapsed ? 'false' : 'true';
        localStorage.setItem('sidebarCollapsed', newState);
        applySidebarState(newState);
        if (window.innerWidth <= 768) { sidebar.classList.toggle('mobile-show'); }
    });
    const menuGroups = document.querySelectorAll('.menu-group');
    menuGroups.forEach(group => {
        const label = group.querySelector('.menu-label');
        const targetId = label.getAttribute('data-bs-target');
        const target = document.querySelector(targetId);
        const groupKey = 'menuGroup_' + targetId;
        const savedState = localStorage.getItem(groupKey);
        if (savedState === 'collapsed') {
            target.classList.remove('show');
            label.classList.add('collapsed');
            label.setAttribute('aria-expanded', 'false');
        }
        target.addEventListener('hide.bs.collapse', function() {
            localStorage.setItem(groupKey, 'collapsed');
            label.classList.add('collapsed');
        });
        target.addEventListener('show.bs.collapse', function() {
            localStorage.setItem(groupKey, 'expanded');
            label.classList.remove('collapsed');
        });
    });
});
</script>
</body>
</html>
