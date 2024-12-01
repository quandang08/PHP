document.addEventListener("DOMContentLoaded", () => {
    const cartTable = document.querySelector(".cart-table");
    const subtotalEl = document.getElementById("subtotal");
    const totalEl = document.getElementById("total");
    
    // Hàm định dạng số tiền theo VND
    function formatCurrencyVND(amount) {
        return new Intl.NumberFormat("vi-VN", {
            style: "currency",
            currency: "VND",
        }).format(amount);
    }

    // Hàm cập nhật tổng tiền
    function updateTotal() {
        let subtotal = 0;
        // Duyệt qua tất cả các sản phẩm trong giỏ hàng
        document.querySelectorAll(".cart-table tbody tr").forEach((row) => {
            const price = parseInt(row.querySelector(".price").dataset.price); // Lấy giá của sản phẩm
            const quantity = parseInt(row.querySelector(".quantity").value); // Lấy số lượng
            const subtotalRow = price * quantity; // Tính subtotal cho sản phẩm

            // Cập nhật subtotal cho sản phẩm trong giao diện
            row.querySelector(".subtotal").textContent = formatCurrencyVND(subtotalRow);
            subtotal += subtotalRow; // Cộng dồn subtotal vào tổng tiền
        });

        // Cập nhật tổng phụ và tổng cộng
        subtotalEl.textContent = formatCurrencyVND(subtotal);
        totalEl.textContent = formatCurrencyVND(subtotal);
    }

    // Xử lý sự kiện xóa sản phẩm
    cartTable.addEventListener("click", (e) => {
        // Kiểm tra nếu người dùng nhấn vào nút "X"
        if (e.target.classList.contains("remove-btn")) {
            const productId = e.target.getAttribute("data-id"); // Lấy ID sản phẩm từ thuộc tính data-id

            // Gửi yêu cầu xóa sản phẩm đến server
            const formData = new FormData();
            formData.append('action', 'remove');
            formData.append('product_id', productId);

            fetch('process_cart.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert('Product removed successfully!'); // Hiển thị thông báo thành công
                location.reload(); // Tải lại trang sau khi xóa sản phẩm để cập nhật giỏ hàng
            })
            .catch(error => console.error('Error:', error));
        }
    });

        // Lắng nghe sự thay đổi số lượng
        cartTable.addEventListener("input", (e) => {
            if (e.target.classList.contains("quantity")) {
                const quantity = e.target.value;
                if (quantity < 1) {
                    alert("Quantity must be at least 1.");
                    e.target.value = 1; // Đặt lại số lượng về 1 nếu nhập sai
                } else {
                    updateTotal();
                    const productId = e.target.getAttribute("data-id");
                    fetch("update_cart.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ id: productId, quantity: quantity })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                    })
                    .catch(error => {
                        console.error("Error updating cart:", error);
                    });
                }
            }
        });
        
         // Cập nhật tổng tiền khi tải trang lần đầu
        updateTotal();
});
