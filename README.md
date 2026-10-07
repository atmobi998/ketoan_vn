# Kế Toán VN - Hệ Thống Kế Toán Việt Nam trên CakePHP

[[CakePHP](https://img.shields.io/badge/CakePHP-5.x-red.svg)](https://cakephp.org)
[[PHP](https://img.shields.io/badge/PHP-%3E%3D8.1-blue.svg)](https://php.net)
[[License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
[[Version](https://img.shields.io/badge/Version-v303.1-blue.svg)](https://github.com/your-repo/ketoan-vn)

Hệ thống kế toán trọn gói cho doanh nghiệp SME Việt Nam, tuân thủ **Chế độ kế toán theo Thông tư 200/2014/TT-BTC**. Xây dựng trên **CakePHP 5**, hỗ trợ quản lý mua hàng, bán hàng, kho, công nợ và tự động hạch toán vào sổ cái.

> **v303.1-GL-Patched** - Bản vá tự động hạch toán: Nhập kho / Xuất kho / Mua / Bán tự động sinh bút toán vào `journal_entries`.

---

## 📸 Tính năng chính

### 1. Mua hàng & Công nợ phải trả
- **Purchase Orders (PO)** - Đơn đặt hàng NCC
- **Goods Receipts (GR)** - Phiếu nhập kho: `Nợ 152/1561, Nợ 1331 / Có 331`
- **Purchase Invoices (PINV)** - Hóa đơn mua hàng, tự động tránh double khi đã có GR

### 2. Bán hàng & Công nợ phải thu
- **Sales Orders (SO)** - Đơn hàng bán
- **Delivery Notes (DN)** - Phiếu xuất kho: `Nợ 632 / Có 152/155/1561` (giá vốn)
- **Sales Invoices (SINV)** - Hóa đơn bán hàng: `Nợ 131 / Có 5111, Có 33311` (doanh thu + VAT)

### 3. Kho & Tồn kho
- Quản lý nhiều kho (Warehouses)
- Theo dõi tồn kho theo sản phẩm, lot, hạn sử dụng
- Tự động cập nhật `inventories` khi duyệt phiếu (sync_inv)
- Phân loại: NVL (152), Thành phẩm (155), Hàng hóa (1561), CCDC (153)

### 4. Kế toán tổng hợp
- **Chart of Accounts** - Hệ thống TK 228 tài khoản theo TT200
- **Journal Entries** - Sổ nhật ký chung, tự động sinh số `NK-2026-09-001`, `XK-...`, `BH-...`, `MH-...`
- **Accounting Periods** - Kỳ kế toán, khóa sổ
- **Auto GL Posting Service** - `GlPostingService.php` - chống trùng bằng `reference_type + reference_id`

### 5. Khác
- Quản lý khách hàng, NCC, sản phẩm, đơn vị tính
- Quản lý nhân sự & bảng lương (Payroll)
- Xuất Excel / PDF cho mọi chứng từ
- Giao diện tiếng Việt 100% (168 file templates đã dịch)

---

## 🚀 Cài đặt nhanh

### Yêu cầu hệ thống
- PHP >= 8.1
- MySQL 5.7+ / MariaDB 10.3+
- Composer 2.x
- Extensions: `intl`, `mbstring`, `pdo_mysql`

### 1. Clone & cài đặt

```bash
git clone https://github.com/atmobi998/ketoan-vn.git
cd ketoan-vn

composer install
cp config/app_local.example.php config/app_local.php
# Sửa DB config trong app_local.php
```

### 2. Import Database

File SQL nằm trong release: `ketoan-v303.0.sql` (thực chất là dump + source)

```bash
# Tạo DB
mysql -u root -p -e "CREATE DATABASE ketoan_vn CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Import
mysql -u root -p ketoan_vn < ketoan_vn.sql
```

Hoặc import file `ketoan_vn.sql` trong thư mục gốc nếu có.

### 3. Cấu hình

Sửa `config/app_local.php`:

```php
'Datasources' => [
    'default' => [
        'host' => 'localhost',
        'username' => 'root',
        'password' => 'your_pass',
        'database' => 'ketoan_vn',
    ]
]
```

### 4. Chạy

```bash
bin/cake server
# hoặc
php -S localhost:8000 -t webroot/

# Truy cập http://localhost:8000
# User mặc định: admin / admin (kiểm tra bảng users)
```

---

## 📒 Hạch toán tự động

Trước đây phiếu nhập/xuất chỉ cập nhật kho, chưa vào sổ cái. Bản patch này thêm:

### Service: `src/Service/GlPostingService.php`

```php
use App\Service\GlPostingService;

$gl = new GlPostingService();
$gl->postGoodsReceipt($id);      // Nhập kho
$gl->postDeliveryNote($id);      // Xuất kho - giá vốn
$gl->postSalesInvoice($id);      // Doanh thu
$gl->postPurchaseInvoice($id);   // Mua hàng
```

**Đã tích hợp sẵn trong:**
- `GoodsReceiptsController::edit()` - tự hạch toán khi duyệt
- `DeliveryNotesController::edit()` - tự hạch toán giá vốn

### Backfill dữ liệu cũ

```bash
# Hạch toán toàn bộ chứng từ approved chưa vào sổ
php bin/cake post_missing_gl_entries

# Ép hạch toán lại (force)
php bin/cake post_missing_gl_entries --force
```

Kiểm tra:
```sql
SELECT * FROM journal_entries WHERE reference_type = 'GoodsReceipt';
SELECT * FROM journal_entry_lines WHERE journal_entry_id = 123;
```

---

## 🗂️ Cấu trúc thư mục

```
ketoan-v303.0/
├── config/                 # Cấu hình CakePHP
├── src/
│   ├── Controller/         # 40+ controllers (PO, SO, GR, DN, INV...)
│   ├── Model/Table/        # ORM Tables
│   ├── Service/
│   │   └── GlPostingService.php  # <-- Service hạch toán tự động
│   ├── Command/
│   │   └── PostMissingGlEntriesCommand.php
│   └── View/
├── templates/              # 168 file đã dịch tiếng Việt
│   ├── GoodsReceipts/
│   ├── DeliveryNotes/
│   ├── PurchaseInvoices/
│   ├── SalesInvoices/
│   └── JournalEntries/
├── webroot/
├── vendor/
└── ketoan_vn.sql
```

---

## 🧾 Định khoản mẫu

| Nghiệp vụ | Nợ | Có |
|-----------|----|----|
| Nhập kho mua NVL | 152 (total_amount)<br>1331 (vat_amount) | 331 (grand_total) |
| Nhập kho HH | 1561 / 1331 | 331 |
| Xuất kho bán | 632 | 152/155/1561 |
| Doanh thu bán | 131 (grand_total) | 5111 (total)<br>33311 (VAT) |
| Mua hàng (không GR) | 152/1561 + 1331 | 331 |

Tài khoản kho theo `product_category_id`:
- 1 - NVL → 152
- 2 - TP → 155
- 3 - HH → 1561
- 4 - CCDC → 153

---

## 🛠️ Các lệnh hữu ích

```bash
# Clear cache
bin/cake cache clear_all

# Check code style
vendor/bin/phpcs src/Controller/GoodsReceiptsController.php

# Tạo controller mới
bin/cake bake controller Products

# Backup DB
mysqldump -u root -p ketoan_vn > backup_$(date +%Y%m%d).sql
```

---

## 🐛 Sửa lỗi thường gặp

**1. `Undefined method 'begin'`**
> Đã fix trong v303.1-FIXED. Dùng `$connection->transactional()` thay vì `$conn->begin()`.

**2. `SQLSTATE[HY000] [1045] Access denied`**
> Kiểm tra `config/app_local.php` Datasources.

**3. Phiếu đã duyệt nhưng không vào sổ cái**
> Chạy `bin/cake post_missing_gl_entries` để backfill.

---

## 🤝 Đóng góp

1. Fork repo
2. Tạo branch: `git checkout -b feature/ten-tinh-nang`
3. Commit: `git commit -m 'Add some feature'`
4. Push: `git push origin feature/ten-tinh-nang`
5. Tạo Pull Request

---

## 📄 License

MIT License - xem file [LICENSE](LICENSE)

---

## 👨‍💻 Tác giả

**Hồ Trần An** - Phát triển & Tùy chỉnh cho doanh nghiệp VN

- Facebook: [Hồ Trần An](https://www.facebook.com/100012148350629)
- Project: Kế toán VN v303.1 GL-Patched

### Changelog

**v303.1-FIXED (2026-10-07)**
- Fix `Undefined method begin()` - chuyển sang `transactional()`
- Tự động hạch toán GR/DN vào sổ cái
- Thêm Command `post_missing_gl_entries`
- Dịch full 168 templates sang tiếng Việt
- Thêm `GlPostingService` với chống trùng `reference_type`

**v303.0 (2026-10-02)**
- Base version từ CakePHP 5
- 40+ modules kế toán, kho, mua bán

---

## 📞 Hỗ trợ

Nếu gặp lỗi khi upload lên GitHub hoặc deploy, tạo Issue hoặc liên hệ.

**Happy Accounting!** 📊
