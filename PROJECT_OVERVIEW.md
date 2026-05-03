# Tổng quan về dự án Rynna Stationery

## 1. Giới thiệu dự án
**Rynna Stationery** là một ứng dụng web thương mại điện tử chuyên cung cấp và quản lý các sản phẩm văn phòng phẩm. Hệ thống được xây dựng trên nền tảng Laravel (PHP) kết hợp với các công nghệ web hiện đại, hướng tới mục tiêu cung cấp trải nghiệm mua sắm trực tuyến thuận tiện cho khách hàng và bộ công cụ quản lý toàn diện cho người quản trị (Admin).

## 2. Đối tượng sử dụng
- **Khách hàng (Người mua):** Học sinh, sinh viên, nhân viên văn phòng hoặc bất kỳ ai có nhu cầu mua sắm văn phòng phẩm.
- **Quản trị viên (Admin):** Chủ cửa hàng, nhân viên quản lý kho, nhân viên chăm sóc khách hàng.

## 3. Các tính năng chính (Nội dung cốt lõi)

### Dành cho Khách hàng (Client Side)
- **Danh mục và Sản phẩm:** Xem, tìm kiếm và lọc sản phẩm theo danh mục. Hỗ trợ hiển thị các chương trình Flash Sale.
- **Giỏ hàng (Cart):** Thêm, sửa, xóa sản phẩm trong giỏ hàng. Hỗ trợ áp dụng mã giảm giá (Voucher).
- **Thanh toán và Đơn hàng (Checkout & Orders):** Đặt hàng và theo dõi trạng thái đơn hàng (đang xử lý, đang giao, đã hoàn thành).
- **Trợ lý ảo (Chatbot AI):** Hỗ trợ tư vấn mua sắm trực tiếp qua chatbot thông minh tích hợp công nghệ AI (Google Gemini).

### Dành cho Quản trị viên (Admin Panel)
- **Bảng điều khiển (Dashboard):** Thống kê doanh thu, số lượng đơn hàng, và xuất báo cáo tài chính (Export Revenue/Excel).
- **Quản lý Sản phẩm & Danh mục:** Thêm, sửa, xóa sản phẩm và phân loại danh mục.
- **Quản lý Kho (Inventory):** Nhập kho, theo dõi số lượng tồn kho của các mặt hàng.
- **Quản lý Khuyến mãi:** Tạo và quản lý mã giảm giá (Vouchers), lên lịch các chiến dịch Flash Sale.
- **Quản lý Đơn hàng:** Cập nhật trạng thái đơn hàng, theo dõi lộ trình (Order Timeline).
- **Chăm sóc Khách hàng:** Quản lý lịch sử chat của khách hàng, chuyển đổi giữa chế độ AI tự động trả lời và nhân viên tư vấn trực tiếp.

## 4. Cấu trúc kỹ thuật chính
- **Framework:** Laravel (MVC Pattern)
- **Database:** MySQL / SQLite
- **Xác thực (Authentication):** Laravel Breeze / Sanctum
- **Frontend:** Blade Templates, HTML5, CSS3, JavaScript (AJAX cho các thao tác giỏ hàng và Chat)

Dự án này là một bài tập lớn (BTL) hoàn chỉnh, áp dụng các kiến thức thực tế về quy trình phát triển phần mềm và thương mại điện tử.
