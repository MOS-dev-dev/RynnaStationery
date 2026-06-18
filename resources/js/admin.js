import './bootstrap';
import Alpine from 'alpinejs';

// Admin-specific JavaScript for Rynna Pet Shop
document.addEventListener('DOMContentLoaded', function() {
    // Admin dashboard functionality
    console.log('Admin panel loaded');
    
    // Flash sale countdown timers
    const countdownTimers = document.querySelectorAll('.flash-sale-countdown');
    if (countdownTimers.length > 0) {
        countdownTimers.forEach(timer => {
            const endTime = new Date(timer.dataset.endTime).getTime();
            
            const updateCountdown = () => {
                const now = new Date().getTime();
                const distance = endTime - now;
                
                if (distance < 0) {
                    timer.innerHTML = 'EXPIRED';
                    return;
                }
                
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                
                timer.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
            };
            
            updateCountdown();
            setInterval(updateCountdown, 1000);
        });
    }
    
    // Order status updates
    const statusSelects = document.querySelectorAll('.order-status-select');
    statusSelects.forEach(select => {
        select.addEventListener('change', function() {
            const orderId = this.dataset.orderId;
            const status = this.value;
            
            fetch(`/admin/orders/${orderId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ status })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Order status updated successfully');
                } else {
                    alert('Failed to update order status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the order status');
            });
        });
    });
    
    // Inventory management
    const inventoryForms = document.querySelectorAll('.inventory-form');
    inventoryForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Inventory updated successfully');
                    location.reload();
                } else {
                    alert('Failed to update inventory');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating inventory');
            });
        });
    });
    
    // Product image preview
    const imageInputs = document.querySelectorAll('.product-image-input');
    imageInputs.forEach(input => {
        input.addEventListener('change', function() {
            const file = this.files[0];
            const preview = this.nextElementSibling;
            
            if (file && preview) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    });
    
    // Delete confirmation
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to delete this item?')) {
                e.preventDefault();
            }
        });
    });
});
