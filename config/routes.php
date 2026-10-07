<?php
/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

/*
 * This file is loaded in the context of the `Application` class.
 * So you can use `$this` to reference the application class instance
 * if required.
 */
return function (RouteBuilder $routes): void {
    $routes->setRouteClass(DashedRoute::class);

    $routes->prefix('Admin', function (RouteBuilder $routes) {
        $routes->connect('/gl-status', ['controller' => 'GlStatus', 'action' => 'index']);
        $routes->connect('/gl-status/post-all', ['controller' => 'GlStatus', 'action' => 'postAll']);
    });

    $routes->scope('/', function (RouteBuilder $builder): void {
        $builder->connect('/', ['controller' => 'Dashboard', 'action' => 'index']);
        $builder->connect('/pages/*', 'Pages::display');
        $builder->connect('/login', ['controller' => 'Users', 'action' => 'login']);
        $builder->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);
        $builder->connect('/users/login', ['controller' => 'Users', 'action' => 'login']);
        $builder->connect('/users/logout', ['controller' => 'Users', 'action' => 'logout']);

        $builder->connect('/gl-status', ['controller' => 'GlStatus', 'action' => 'index']);
        $builder->connect('/gl-status/post-all', ['controller' => 'GlStatus', 'action' => 'postAll']);
        $builder->connect('/users', ['controller' => 'Users', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/users/:action/*', ['controller' => 'Users'])->setMethods(['GET', 'POST']);
        $builder->connect('/roles', ['controller' => 'Roles', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/roles/:action/*', ['controller' => 'Roles'])->setMethods(['GET', 'POST']);
        $builder->connect('/departments', ['controller' => 'Departments', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/departments/:action/*', ['controller' => 'Departments'])->setMethods(['GET', 'POST']);
        $builder->connect('/currencies', ['controller' => 'Currencies', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/currencies/:action/*', ['controller' => 'Currencies'])->setMethods(['GET', 'POST']);
        $builder->connect('/units', ['controller' => 'Units', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/units/:action/*', ['controller' => 'Units'])->setMethods(['GET', 'POST']);
        $builder->connect('/warehouses', ['controller' => 'Warehouses', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/warehouses/:action/*', ['controller' => 'Warehouses'])->setMethods(['GET', 'POST']);
        $builder->connect('/product_categories', ['controller' => 'ProductCategories', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/product_categories/:action/*', ['controller' => 'ProductCategories'])->setMethods(['GET', 'POST']);
        $builder->connect('/products', ['controller' => 'Products', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/products/:action/*', ['controller' => 'Products'])->setMethods(['GET', 'POST']);
        $builder->connect('/chart_of_accounts', ['controller' => 'ChartOfAccounts', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/chart_of_accounts/:action/*', ['controller' => 'ChartOfAccounts'])->setMethods(['GET', 'POST']);
        $builder->connect('/accounting_periods', ['controller' => 'AccountingPeriods', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/accounting_periods/:action/*', ['controller' => 'AccountingPeriods'])->setMethods(['GET', 'POST']);
        $builder->connect('/cost_centers', ['controller' => 'CostCenters', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/cost_centers/:action/*', ['controller' => 'CostCenters'])->setMethods(['GET', 'POST']);
        $builder->connect('/bank_accounts', ['controller' => 'BankAccounts', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/bank_accounts/:action/*', ['controller' => 'BankAccounts'])->setMethods(['GET', 'POST']);
        $builder->connect('/cash_receipts', ['controller' => 'CashReceipts', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/cash_receipts/:action/*', ['controller' => 'CashReceipts'])->setMethods(['GET', 'POST']);
        $builder->connect('/cash_receipt_details', ['controller' => 'CashReceiptDetails', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/cash_receipt_details/:action/*', ['controller' => 'CashReceiptDetails'])->setMethods(['GET', 'POST']);
        $builder->connect('/cash_payments', ['controller' => 'CashPayments', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/cash_payments/:action/*', ['controller' => 'CashPayments'])->setMethods(['GET', 'POST']);
        $builder->connect('/cash_payment_details', ['controller' => 'CashPaymentDetails', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/cash_payment_details/:action/*', ['controller' => 'CashPaymentDetails'])->setMethods(['GET', 'POST']);
        $builder->connect('/bank_receipts', ['controller' => 'BankReceipts', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/bank_receipts/:action/*', ['controller' => 'BankReceipts'])->setMethods(['GET', 'POST']);
        $builder->connect('/bank_payments', ['controller' => 'BankPayments', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/bank_payments/:action/*', ['controller' => 'BankPayments'])->setMethods(['GET', 'POST']);
        $builder->connect('/bank_transactions', ['controller' => 'BankTransactions', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/bank_transactions/:action/*', ['controller' => 'BankTransactions'])->setMethods(['GET', 'POST']);
        $builder->connect('/suppliers', ['controller' => 'Suppliers', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/suppliers/:action/*', ['controller' => 'Suppliers'])->setMethods(['GET', 'POST']);
        $builder->connect('/purchase_orders', ['controller' => 'PurchaseOrders', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/purchase_orders/:action/*', ['controller' => 'PurchaseOrders'])->setMethods(['GET', 'POST']);
        $builder->connect('/purchase_order_details', ['controller' => 'PurchaseOrderDetails', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/purchase_order_details/:action/*', ['controller' => 'PurchaseOrderDetails'])->setMethods(['GET', 'POST']);
        $builder->connect('/goods_receipts', ['controller' => 'GoodsReceipts', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/goods_receipts/:action/*', ['controller' => 'GoodsReceipts'])->setMethods(['GET', 'POST']);
        $builder->connect('/goods_receipt_details', ['controller' => 'GoodsReceiptDetails', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/goods_receipt_details/:action/*', ['controller' => 'GoodsReceiptDetails'])->setMethods(['GET', 'POST']);
        $builder->connect('/purchase_invoices', ['controller' => 'PurchaseInvoices', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/purchase_invoices/:action/*', ['controller' => 'PurchaseInvoices'])->setMethods(['GET', 'POST']);
        $builder->connect('/purchase_invoice_details', ['controller' => 'PurchaseInvoiceDetails', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/purchase_invoice_details/:action/*', ['controller' => 'PurchaseInvoiceDetails'])->setMethods(['GET', 'POST']);
        $builder->connect('/supplier_debts', ['controller' => 'SupplierDebts', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/supplier_debts/:action/*', ['controller' => 'SupplierDebts'])->setMethods(['GET', 'POST']);
        $builder->connect('/supplier_payments', ['controller' => 'SupplierPayments', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/supplier_payments/:action/*', ['controller' => 'SupplierPayments'])->setMethods(['GET', 'POST']);
        $builder->connect('/customers', ['controller' => 'Customers', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/customers/:action/*', ['controller' => 'Customers'])->setMethods(['GET', 'POST']);
        $builder->connect('/sales_orders', ['controller' => 'SalesOrders', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/sales_orders/:action/*', ['controller' => 'SalesOrders'])->setMethods(['GET', 'POST']);
        $builder->connect('/sales_order_details', ['controller' => 'SalesOrderDetails', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/sales_order_details/:action/*', ['controller' => 'SalesOrderDetails'])->setMethods(['GET', 'POST']);
        $builder->connect('/delivery_notes', ['controller' => 'DeliveryNotes', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/delivery_notes/:action/*', ['controller' => 'DeliveryNotes'])->setMethods(['GET', 'POST']);
        $builder->connect('/delivery_note_details', ['controller' => 'DeliveryNoteDetails', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/delivery_note_details/:action/*', ['controller' => 'DeliveryNoteDetails'])->setMethods(['GET', 'POST']);
        $builder->connect('/sales_invoices', ['controller' => 'SalesInvoices', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/sales_invoices/:action/*', ['controller' => 'SalesInvoices'])->setMethods(['GET', 'POST']);
        $builder->connect('/sales_invoice_details', ['controller' => 'SalesInvoiceDetails', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/sales_invoice_details/:action/*', ['controller' => 'SalesInvoiceDetails'])->setMethods(['GET', 'POST']);
        $builder->connect('/customer_debts', ['controller' => 'CustomerDebts', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/customer_debts/:action/*', ['controller' => 'CustomerDebts'])->setMethods(['GET', 'POST']);
        $builder->connect('/customer_payments', ['controller' => 'CustomerPayments', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/customer_payments/:action/*', ['controller' => 'CustomerPayments'])->setMethods(['GET', 'POST']);
        $builder->connect('/inventories', ['controller' => 'Inventories', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/inventories/:action/*', ['controller' => 'Inventories'])->setMethods(['GET', 'POST']);
        $builder->connect('/stock_transactions', ['controller' => 'StockTransactions', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/stock_transactions/:action/*', ['controller' => 'StockTransactions'])->setMethods(['GET', 'POST']);
        $builder->connect('/stock_transfers', ['controller' => 'StockTransfers', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/stock_transfers/:action/*', ['controller' => 'StockTransfers'])->setMethods(['GET', 'POST']);
        $builder->connect('/stock_transfer_details', ['controller' => 'StockTransferDetails', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/stock_transfer_details/:action/*', ['controller' => 'StockTransferDetails'])->setMethods(['GET', 'POST']);
        $builder->connect('/stock_adjustments', ['controller' => 'StockAdjustments', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/stock_adjustments/:action/*', ['controller' => 'StockAdjustments'])->setMethods(['GET', 'POST']);
        $builder->connect('/stock_adjustment_details', ['controller' => 'StockAdjustmentDetails', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/stock_adjustment_details/:action/*', ['controller' => 'StockAdjustmentDetails'])->setMethods(['GET', 'POST']);
        $builder->connect('/asset_categories', ['controller' => 'AssetCategories', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/asset_categories/:action/*', ['controller' => 'AssetCategories'])->setMethods(['GET', 'POST']);
        $builder->connect('/fixed_assets', ['controller' => 'FixedAssets', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/fixed_assets/:action/*', ['controller' => 'FixedAssets'])->setMethods(['GET', 'POST']);
        $builder->connect('/asset_depreciations', ['controller' => 'AssetDepreciations', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/asset_depreciations/:action/*', ['controller' => 'AssetDepreciations'])->setMethods(['GET', 'POST']);
        $builder->connect('/asset_disposals', ['controller' => 'AssetDisposals', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/asset_disposals/:action/*', ['controller' => 'AssetDisposals'])->setMethods(['GET', 'POST']);
        $builder->connect('/tool_categories', ['controller' => 'ToolCategories', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/tool_categories/:action/*', ['controller' => 'ToolCategories'])->setMethods(['GET', 'POST']);
        $builder->connect('/tools', ['controller' => 'Tools', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/tools/:action/*', ['controller' => 'Tools'])->setMethods(['GET', 'POST']);
        $builder->connect('/tool_allocations', ['controller' => 'ToolAllocations', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/tool_allocations/:action/*', ['controller' => 'ToolAllocations'])->setMethods(['GET', 'POST']);
        $builder->connect('/positions', ['controller' => 'Positions', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/positions/:action/*', ['controller' => 'Positions'])->setMethods(['GET', 'POST']);
        $builder->connect('/employees', ['controller' => 'Employees', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/employees/:action/*', ['controller' => 'Employees'])->setMethods(['GET', 'POST']);
        $builder->connect('/employment_contracts', ['controller' => 'EmploymentContracts', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/employment_contracts/:action/*', ['controller' => 'EmploymentContracts'])->setMethods(['GET', 'POST']);
        $builder->connect('/attendances', ['controller' => 'Attendances', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/attendances/:action/*', ['controller' => 'Attendances'])->setMethods(['GET', 'POST']);
        $builder->connect('/payrolls', ['controller' => 'Payrolls', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/payrolls/:action/*', ['controller' => 'Payrolls'])->setMethods(['GET', 'POST']);
        $builder->connect('/payroll_details', ['controller' => 'PayrollDetails', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/payroll_details/:action/*', ['controller' => 'PayrollDetails'])->setMethods(['GET', 'POST']);
        $builder->connect('/boms', ['controller' => 'Boms', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/boms/:action/*', ['controller' => 'Boms'])->setMethods(['GET', 'POST']);
        $builder->connect('/bom_details', ['controller' => 'BomDetails', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/bom_details/:action/*', ['controller' => 'BomDetails'])->setMethods(['GET', 'POST']);
        $builder->connect('/work_centers', ['controller' => 'WorkCenters', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/work_centers/:action/*', ['controller' => 'WorkCenters'])->setMethods(['GET', 'POST']);
        $builder->connect('/routings', ['controller' => 'Routings', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/routings/:action/*', ['controller' => 'Routings'])->setMethods(['GET', 'POST']);
        $builder->connect('/production_orders', ['controller' => 'ProductionOrders', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/production_orders/:action/*', ['controller' => 'ProductionOrders'])->setMethods(['GET', 'POST']);
        $builder->connect('/production_order_materials', ['controller' => 'ProductionOrderMaterials', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/production_order_materials/:action/*', ['controller' => 'ProductionOrderMaterials'])->setMethods(['GET', 'POST']);
        $builder->connect('/production_order_costs', ['controller' => 'ProductionOrderCosts', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/production_order_costs/:action/*', ['controller' => 'ProductionOrderCosts'])->setMethods(['GET', 'POST']);
        $builder->connect('/cost_calculations', ['controller' => 'CostCalculations', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/cost_calculations/:action/*', ['controller' => 'CostCalculations'])->setMethods(['GET', 'POST']);
        $builder->connect('/journal_entries', ['controller' => 'JournalEntries', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/journal_entries/:action/*', ['controller' => 'JournalEntries'])->setMethods(['GET', 'POST']);
        $builder->connect('/journal_entry_lines', ['controller' => 'JournalEntryLines', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/journal_entry_lines/:action/*', ['controller' => 'JournalEntryLines'])->setMethods(['GET', 'POST']);
        $builder->connect('/exchange_rates', ['controller' => 'ExchangeRates', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/exchange_rates/:action/*', ['controller' => 'ExchangeRates'])->setMethods(['GET', 'POST']);
        $builder->connect('/tax_rates', ['controller' => 'TaxRates', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/tax_rates/:action/*', ['controller' => 'TaxRates'])->setMethods(['GET', 'POST']);
        $builder->connect('/reports/*', ['controller' => 'Reports', 'action' => 'index'])->setMethods(['GET', 'POST']);
        $builder->connect('/reports/general-ledger', ['controller' => 'Reports', 'action' => 'generalLedger'])->setMethods(['GET', 'POST']);
        $builder->connect('/reports/trial-balance', ['controller' => 'Reports', 'action' => 'trialBalance'])->setMethods(['GET', 'POST']);
        $builder->connect('/reports/financial', ['controller' => 'Reports', 'action' => 'financial'])->setMethods(['GET', 'POST']);
        $builder->connect('/reports/excel', ['controller' => 'Reports', 'action' => 'excel'])->setMethods(['GET', 'POST']);
        $builder->connect('/reports/pdf', ['controller' => 'Reports', 'action' => 'pdf'])->setMethods(['GET', 'POST']);
        $builder->fallbacks();
    });

};
