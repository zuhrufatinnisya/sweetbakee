// Admin Dashboard JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Toggle sidebar on mobile
    const toggleSidebarBtn = document.getElementById('sidebarToggle');
    if (toggleSidebarBtn) {
        toggleSidebarBtn.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });
    }

    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize popovers
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function(popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

    // Confirm delete actions
    const deleteButtons = document.querySelectorAll('.delete-confirm');
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            if (!confirm('Apakah Anda yakin ingin menghapus item ini?')) {
                e.preventDefault();
            }
        });
    });

    // Form validation
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });

    // Image preview for file inputs
    const imageInputs = document.querySelectorAll('input[type="file"][accept*="image"]');
    imageInputs.forEach(function(input) {
        input.addEventListener('change', function() {
            const preview = document.querySelector(this.dataset.preview || '#imagePreview');
            if (preview && this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    });

    // Price formatter for input fields
    const priceInputs = document.querySelectorAll('.price-input');
    priceInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            // Remove non-numeric characters
            let value = this.value.replace(/\D/g, '');
            // Format with thousand separator
            if (value !== '') {
                value = parseInt(value, 10).toLocaleString('id-ID');
            }
            this.value = value;
        });
    });

    // Handle modal data for edit forms
    const editModals = document.querySelectorAll('[data-bs-toggle="modal"][data-edit-url]');
    editModals.forEach(function(button) {
        button.addEventListener('click', function() {
            const url = this.getAttribute('data-edit-url');
            const modal = document.querySelector(this.getAttribute('data-bs-target'));
            
            // You can implement AJAX to fetch data here if needed
            // For now, we'll use data attributes
            const form = modal.querySelector('form');
            if (form) {
                form.action = url;
                
                // Set form values from data attributes
                for (const [key, value] of Object.entries(this.dataset)) {
                    if (key.startsWith('form')) {
                        const fieldName = key.replace('form', '').toLowerCase();
                        const input = form.querySelector(`[name="${fieldName}"]`);
                        if (input) {
                            input.value = value;
                        }
                    }
                }
            }
        });
    });

    // Dashboard charts (if Chart.js is included)
    if (typeof Chart !== 'undefined') {
        // Sales chart example
        const salesChartCanvas = document.getElementById('salesChart');
        if (salesChartCanvas) {
            new Chart(salesChartCanvas, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Penjualan',
                        data: [12, 19, 3, 5, 2, 3, 20, 33, 23, 12, 33, 55],
                        backgroundColor: 'rgba(255, 107, 107, 0.2)',
                        borderColor: '#ff6b6b',
                        borderWidth: 2,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Products chart example
        const productsChartCanvas = document.getElementById('productsChart');
        if (productsChartCanvas) {
            new Chart(productsChartCanvas, {
                type: 'doughnut',
                data: {
                    labels: ['Kue', 'Roti', 'Donat', 'Pastry', 'Minuman'],
                    datasets: [{
                        data: [12, 19, 8, 15, 10],
                        backgroundColor: [
                            '#ff6b6b',
                            '#4ecdc4',
                            '#ffe66d',
                            '#1a535c',
                            '#ff9f1c'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
    }
});