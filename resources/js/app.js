// Laundry POS Custom JavaScript

// Auto-hide alerts after 3 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.bg-green-50, .bg-red-50, .bg-blue-50');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 3000);
    });
    
    // Format currency input
    const priceInputs = document.querySelectorAll('input[type="number"][step="0.1"]');
    priceInputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value) {
                this.value = parseFloat(this.value).toFixed(1);
            }
        });
    });
});

// Global functions
window.formatRupiah = function(number) {
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
};

window.confirmDelete = function(formId, itemName = 'Data') {
    Swal.fire({
        title: `Hapus ${itemName}?`,
        text: "Data akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
};