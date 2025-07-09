@push('scripts')
    <script>
        // Check authentication status
        const isAuthenticated = @json(Auth::check());
        const loginUrl = @json(route('customer.login'));

        // Service data
        const services = @json($services->take(6));
        let selectedServiceIndex = 0;

        // Check login before interaction
        function checkLoginRequired() {
            if (!isAuthenticated) {
                if (confirm(
                        'Anda harus login terlebih dahulu untuk menggunakan layanan ini.\n\nKlik OK untuk ke halaman login.'
                    )) {
                    window.location.href = loginUrl;
                }
                return false;
            }
            return true;
        }

        // Select service function
        function selectService(index) {
            // Check if user is logged in
            if (!checkLoginRequired()) {
                return;
            }

            // Remove selected class from all options
            document.querySelectorAll('.service-option').forEach(option => {
                option.classList.remove('selected');
            });

            // Add selected class to clicked option
            document.querySelectorAll('.service-option')[index].classList.add('selected');

            // Check radio button
            document.getElementById(`service_${index}`).checked = true;

            selectedServiceIndex = index;
            updateOrderSummary();
        }

        // Select payment function
        function selectPayment(method, event = null) {
            // Remove selected class from all payment methods
            document.querySelectorAll('.payment-method').forEach(methodEl => {
                methodEl.classList.remove('selected');
            });

            // Add selected class ke elemen yang sesuai
            if (event && event.currentTarget) {
                event.currentTarget.classList.add('selected');
            } else {
                // Pilih elemen berdasarkan id radio
                const radio = document.getElementById(method);
                if (radio) {
                    const parent = radio.closest('.payment-method');
                    if (parent) parent.classList.add('selected');
                }
            }

            // Check radio button
            document.getElementById(method).checked = true;
        }

        // Update order summary
        function updateOrderSummary() {
            if (services.length > 0 && services[selectedServiceIndex]) {
                const service = services[selectedServiceIndex];
                // Ganti field lama ke field baru
                const serviceName = service.name;
                const servicePrice = parseInt(service.price);
                const adminFee = 5000;
                const total = servicePrice + adminFee;

                document.getElementById('selectedService').querySelector('.summary-value').textContent = serviceName;
                document.getElementById('totalAmount').textContent = `Rp. ${total.toLocaleString('id-ID')}`;
            }
        }

        // Form submission
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Check if user is logged in
            if (!checkLoginRequired()) {
                return;
            }

            const submitBtn = document.getElementById('submitBtn');
            const formData = new FormData(this);

            // Validation
            const requiredFields = ['customer_name', 'customer_phone', 'customer_email', 'customer_address',
                'service_date', 'service_time'
            ];
            let isValid = true;

            requiredFields.forEach(field => {
                const input = document.getElementById(field);
                if (!input.value.trim()) {
                    isValid = false;
                    input.style.borderColor = '#dc3545';
                    input.focus();
                    return;
                } else {
                    input.style.borderColor = '#eee';
                }
            });

            if (!isValid) {
                alert('Harap lengkapi semua field yang diperlukan!');
                return;
            }

            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses Pembayaran...';

            // Simulate API call
            setTimeout(() => {
                alert(
                    'Pesanan berhasil dibuat!\n\nAnda akan segera dihubungi oleh penyedia jasa untuk konfirmasi.'
                );

                // Reset form
                this.reset();
                selectService(0);
                selectPayment('cash');

                // Reset button
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-lock me-2"></i>Konfirmasi & Bayar';
            }, 2000);
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Check authentication on page load
            if (!isAuthenticated) {
                // Disable all interactive elements for non-authenticated users
                document.querySelectorAll('.service-option').forEach(option => {
                    option.style.opacity = '0.6';
                    option.style.cursor = 'not-allowed';
                });

                document.querySelectorAll('.payment-method').forEach(method => {
                    method.style.opacity = '0.6';
                    method.style.cursor = 'not-allowed';
                });

                const submitBtn = document.getElementById('submitBtn');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-sign-in-alt me-2"></i>Login untuk Melanjutkan';
                    submitBtn.style.background = '#6c757d';
                    submitBtn.onclick = function() {
                        checkLoginRequired();
                    };
                }

                // Show login prompt message
                const paymentBody = document.querySelector('.payment-body');
                if (paymentBody) {
                    const loginPrompt = document.createElement('div');
                    loginPrompt.className = 'alert alert-warning text-center mb-4';
                    loginPrompt.innerHTML = `
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Login Diperlukan!</strong><br>
                        Anda harus login terlebih dahulu untuk menggunakan layanan pemesanan.<br>
                        <a href="${loginUrl}" class="btn btn-primary btn-sm mt-2">
                            <i class="fas fa-sign-in-alt me-1"></i>Login Sekarang
                        </a>
                    `;
                    loginPrompt.style.cssText = `
                        background: #fff3cd;
                        border: 1px solid #ffeaa7;
                        color: #856404;
                        padding: 20px;
                        border-radius: 10px;
                        margin-bottom: 30px;
                    `;
                    paymentBody.insertBefore(loginPrompt, paymentBody.firstChild);
                }

                return; // Don't initialize interactive features for non-authenticated users
            }

            // Only initialize interactive features for authenticated users
            // Select first service by default
            if (document.querySelectorAll('.service-option').length > 0) {
                selectService(0);
            }

            // Select first payment method by default
            selectPayment('cash');

            // Set minimum date to today
            document.getElementById('service_date').min = new Date().toISOString().split('T')[0];

            // Phone number validation
            document.getElementById('customer_phone').addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 13) {
                    value = value.substring(0, 13);
                }
                e.target.value = value;
            });

            // Email validation
            document.getElementById('customer_email').addEventListener('blur', function(e) {
                const email = e.target.value;
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (email && !emailRegex.test(email)) {
                    e.target.style.borderColor = '#dc3545';
                    alert('Format email tidak valid!');
                } else {
                    e.target.style.borderColor = '#eee';
                }
            });

            // Auto-fill alamat jika tersedia dari backend
            const userAddress = @json($user_address ?? '');
            if (userAddress && document.getElementById('customer_address')) {
                document.getElementById('customer_address').value = userAddress;
            }

            // Auto-fill nomor telepon jika tersedia dari backend
            const userPhone = @json(Auth::user()->phone ?? '');
            if (userPhone && document.getElementById('customer_phone')) {
                document.getElementById('customer_phone').value = userPhone;
            }

            // Filter waktu layanan sesuai tanggal
            const serviceDateInput = document.getElementById('service_date');
            const serviceTimeSelect = document.getElementById('service_time');
            const allTimes = [{
                    value: '08:00',
                    label: '08:00 WIB'
                },
                {
                    value: '09:00',
                    label: '09:00 WIB'
                },
                {
                    value: '10:00',
                    label: '10:00 WIB'
                },
                {
                    value: '11:00',
                    label: '11:00 WIB'
                },
                {
                    value: '13:00',
                    label: '13:00 WIB'
                },
                {
                    value: '14:00',
                    label: '14:00 WIB'
                },
                {
                    value: '15:00',
                    label: '15:00 WIB'
                },
                {
                    value: '16:00',
                    label: '16:00 WIB'
                }
            ];

            // Tampilkan semua waktu tanpa filter
            function updateAvailableTimes() {
                serviceTimeSelect.innerHTML = '<option value="">Pilih waktu</option>';
                allTimes.forEach(time => {
                    let opt = document.createElement('option');
                    opt.value = time.value;
                    opt.textContent = time.label;
                    serviceTimeSelect.appendChild(opt);
                });
            }

            serviceDateInput.addEventListener('change', updateAvailableTimes);
            // Inisialisasi waktu saat load
            updateAvailableTimes();
        });
    </script>
@endpush
