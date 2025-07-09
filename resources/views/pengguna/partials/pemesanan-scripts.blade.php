@push('scripts')
    <script>
        // Check authentication status
        const isAuthenticated = @json(Auth::check());
        const loginUrl = @json(route('customer.login'));

        // Service providers data
        const serviceProviders = @json(isset($serviceProviders) ? $serviceProviders : []);
        let selectedServiceId = null;
        let selectedServicePrice = 0;
        let selectedServiceName = '';

        // Format harga dalam Rupiah Indonesia
        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(angka).replace('IDR', 'Rp.');
        }

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

        // Show success/error messages
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3ab8ff',
                timer: 5000,
                timerProgressBar: true
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonColor: '#ff6b6b'
            });
        @endif

        @if ($errors->any())
            let errorMessages = @json($errors->all());
            Swal.fire({
                icon: 'error',
                title: 'Validasi Error',
                html: '<ul style="text-align: left; margin: 0; padding-left: 20px;">' +
                    errorMessages.map(error => '<li>' + error + '</li>').join('') +
                    '</ul>',
                confirmButtonColor: '#ff6b6b'
            });

            // Buka modal jika ada error validasi
            var modal = new bootstrap.Modal(document.getElementById('addOrderModal'));
            modal.show();
        @endif

        // Service selection functionality
        let selectedService = null;
        const adminFee = 5000; // Biaya admin

        function selectService(id, name, price, category) {
            // Check if user is logged in
            if (!checkLoginRequired()) {
                return;
            }

            // Remove previous selection
            document.querySelectorAll('.service-card').forEach(card => {
                card.classList.remove('selected');
            });

            // Add selection to clicked card
            event.currentTarget.classList.add('selected');

            // Store selected service
            selectedService = {
                id,
                name,
                price,
                category
            };
            selectedServiceId = id;
            selectedServicePrice = price;
            selectedServiceName = name;

            // Update hidden input
            document.getElementById('selected_service').value = id;

            // Clear service error if any
            clearFieldError('service_id');

            // Update order summary
            updateOrderSummary();

            // Update provider options based on selected service
            updateProviderOptions(id);
        }

        // Payment method selection
        function selectPayment(paymentType) {
            // Remove previous selection
            document.querySelectorAll('.payment-option').forEach(option => {
                option.classList.remove('selected');
            });

            // Add selection
            const selectedOption = event.currentTarget;
            selectedOption.classList.add('selected');

            // Update radio input
            const radioInput = selectedOption.querySelector('input[type="radio"]');
            if (radioInput) {
                radioInput.checked = true;
            }

            // Clear payment error
            clearFieldError('pembayaran');
        }

        // Update order summary
        function updateOrderSummary() {
            const summaryService = document.getElementById('summary-service');
            const summaryTotal = document.getElementById('summary-total');

            if (selectedService && selectedService.id) {
                summaryService.textContent = selectedService.name;
                const totalPrice = selectedService.price + adminFee;
                summaryTotal.textContent = formatRupiah(totalPrice);
            } else {
                summaryService.textContent = 'Belum dipilih';
                summaryTotal.textContent = formatRupiah(0);
            }
        }

        // Update provider options based on selected service
        function updateProviderOptions(serviceId) {
            const providerSelect = document.getElementById('provider_id');
            const providerDetails = document.getElementById('providerDetails');
            const providerWarning = document.getElementById('providerWarning');

            // Clear previous options
            providerSelect.innerHTML = '<option value="">-- Pilih Penyedia Jasa --</option>';

            // Hide provider details
            providerDetails.style.display = 'none';

            // Get providers for the selected service
            const providers = serviceProviders[serviceId] || [];

            if (providers.length === 0) {
                // Show warning if no providers available
                providerWarning.style.display = 'block';
                // Disable provider select
                providerSelect.disabled = true;
                return;
            } else {
                // Hide warning and enable select
                providerWarning.style.display = 'none';
                providerSelect.disabled = false;
            }

            // Add providers to select options
            providers.forEach(provider => {
                const option = document.createElement('option');
                option.value = provider.id;
                option.textContent = provider.user ? provider.user.name : 'Penyedia #' + provider.id;
                option.dataset.rating = provider.rating || 0;
                option.dataset.reviews = provider.reviews_count || 0;
                option.dataset.experience = provider.experience || '-';
                providerSelect.appendChild(option);
            });
        }

        // Show provider details when selected
        document.getElementById('provider_id').addEventListener('change', function() {
            const providerDetails = document.getElementById('providerDetails');
            const selectedProviderName = document.getElementById('selectedProviderName');
            const selectedProviderRating = document.getElementById('selectedProviderRating');
            const selectedProviderReviews = document.getElementById('selectedProviderReviews');
            const selectedProviderExperience = document.getElementById('selectedProviderExperience');

            if (this.value) {
                const selectedOption = this.options[this.selectedIndex];
                selectedProviderName.textContent = selectedOption.textContent;
                selectedProviderRating.textContent = selectedOption.dataset.rating;
                selectedProviderReviews.textContent = selectedOption.dataset.reviews;
                selectedProviderExperience.textContent = 'Pengalaman: ' + selectedOption.dataset.experience;
                providerDetails.style.display = 'block';
            } else {
                providerDetails.style.display = 'none';
            }
        });

        // Initialize the find services with providers button
        document.getElementById('findServicesWithProviders').addEventListener('click', function() {
            // Find all service cards that have providers
            const serviceCards = document.querySelectorAll('.service-card');

            serviceCards.forEach(card => {
                const serviceId = card.dataset.serviceId;
                const providers = serviceProviders[serviceId] || [];

                // Update the visual indicator
                const providerIndicator = card.querySelector('.has-providers-indicator');

                if (providers.length > 0) {
                    card.classList.add('has-providers');
                    if (providerIndicator) {
                        providerIndicator.style.display = 'block';
                    }
                } else {
                    card.classList.remove('has-providers');
                    if (providerIndicator) {
                        providerIndicator.style.display = 'none';
                    }
                }
            });

            // Scroll to first service with providers
            const firstServiceWithProviders = document.querySelector('.service-card.has-providers');
            if (firstServiceWithProviders) {
                firstServiceWithProviders.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                // Simulate click on this service
                firstServiceWithProviders.click();
            }
        });

        // Refresh providers button
        document.getElementById('refreshProviders').addEventListener('click', function() {
            if (selectedServiceId) {
                updateProviderOptions(selectedServiceId);
            }
        });

        // Form validation
        function validateForm() {
            let isValid = true;
            const requiredFields = ['selected_service', 'provider_id', 'nomor_telepon', 'alamat', 'tanggal_pelaksanaan',
                'waktu_kerja'
            ];

            // Check service selection
            if (!selectedService || !selectedService.id) {
                showFieldError('service', 'Pilih layanan terlebih dahulu');
                isValid = false;
            }

            // Check provider selection
            const providerField = document.querySelector('[name="provider_id"]');
            if (!providerField || !providerField.value) {
                showFieldError('provider_id', 'Pilih penyedia jasa terlebih dahulu');
                isValid = false;
            }

            // Check required text fields
            requiredFields.forEach(fieldName => {
                const field = document.querySelector(`[name="${fieldName}"]`) || document.getElementById(fieldName);
                if (!field || !field.value.trim()) {
                    const displayName = getFieldDisplayName(fieldName);
                    showFieldError(fieldName, `${displayName} wajib diisi`);
                    isValid = false;
                } else {
                    clearFieldError(fieldName);
                }
            });

            // Check payment method
            const paymentMethod = document.querySelector('input[name="pembayaran"]:checked');
            if (!paymentMethod) {
                showFieldError('pembayaran', 'Pilih metode pembayaran');
                isValid = false;
            }

            // Validate phone format
            const phone = document.querySelector('[name="nomor_telepon"]');
            if (phone && phone.value) {
                const phoneRegex = /^08[0-9]{8,11}$/;
                if (!phoneRegex.test(phone.value)) {
                    showFieldError('nomor_telepon', 'Format nomor telepon tidak valid (08xxxxxxxxxx)');
                    isValid = false;
                }
            }

            // Validate address length
            const address = document.querySelector('[name="alamat"]');
            if (address && address.value && address.value.length < 10) {
                showFieldError('alamat', 'Alamat minimal 10 karakter');
                isValid = false;
            }

            // Validate service date
            const serviceDate = document.querySelector('[name="tanggal_pelaksanaan"]');
            if (serviceDate && serviceDate.value) {
                const selectedDate = new Date(serviceDate.value);
                const tomorrow = new Date();
                tomorrow.setDate(tomorrow.getDate() + 1);
                tomorrow.setHours(0, 0, 0, 0);

                if (selectedDate < tomorrow) {
                    showFieldError('tanggal_pelaksanaan', 'Tanggal pelaksanaan minimal H+1 dari hari ini');
                    isValid = false;
                }
            }

            return isValid;
        }

        function getFieldDisplayName(fieldName) {
            const fieldNames = {
                'selected_service': 'Layanan',
                'provider_id': 'Penyedia jasa',
                'nomor_telepon': 'Nomor telepon',
                'alamat': 'Alamat',
                'tanggal_pelaksanaan': 'Tanggal pelaksanaan',
                'waktu_kerja': 'Waktu layanan'
            };
            return fieldNames[fieldName] || fieldName;
        }

        function showFieldError(fieldName, message) {
            const field = document.querySelector(`[name="${fieldName}"]`) || document.getElementById(fieldName);
            const errorDiv = document.getElementById(`${fieldName}-error`);

            if (field) {
                field.classList.add('is-invalid');
            }
            if (errorDiv) {
                errorDiv.textContent = message;
                errorDiv.style.display = 'block';
            }
        }

        function clearFieldError(fieldName) {
            const field = document.querySelector(`[name="${fieldName}"]`) || document.getElementById(fieldName);
            const errorDiv = document.getElementById(`${fieldName}-error`);

            if (field) {
                field.classList.remove('is-invalid');
            }
            if (errorDiv) {
                errorDiv.style.display = 'none';
            }
        }

        // Form submission
        document.getElementById('newOrderForm').addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                return;
            }

            const submitBtn = document.getElementById('submitBtn');
            submitBtn.classList.add('loading');

            // Form akan disubmit secara normal karena kita tidak prevent default lagi
        });

        // Modal event handlers
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('addOrderModal');
            const form = document.getElementById('newOrderForm');

            // Reset form when modal is closed
            modal.addEventListener('hidden.bs.modal', function() {
                // Reset form
                form.reset();

                // Clear service selection
                document.querySelectorAll('.service-card').forEach(card => {
                    card.classList.remove('selected');
                });

                // Hide price display
                document.getElementById('priceDisplay').style.display = 'none';

                // Clear selected service
                selectedService = null;
                document.getElementById('selected_service').value = '';

                // Clear all errors
                document.querySelectorAll(
                    '.form-control-modern, .form-select-modern, .form-textarea-modern').forEach(
                    field => {
                        field.classList.remove('is-invalid');
                    });
                document.querySelectorAll('.invalid-feedback').forEach(errorDiv => {
                    errorDiv.style.display = 'none';
                });

                // Remove loading state from button
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.classList.remove('loading');
            });

            // Focus first editable field when modal opens
            modal.addEventListener('shown.bs.modal', function() {
                // Auto-fill user data
                autoFillUserData();

                // Scroll to top of modal
                const modalBody = modal.querySelector('.modal-body');
                modalBody.scrollTop = 0;

                // Focus on the first service card if no service is selected
                if (!selectedService) {
                    const firstServiceCard = modal.querySelector('.service-card');
                    if (firstServiceCard) {
                        firstServiceCard.focus();
                    }
                } else {
                    // Focus on the first editable input field
                    const firstEditableField = modal.querySelector(
                        'input:not([readonly]):not([type="hidden"]), select, textarea');
                    if (firstEditableField) {
                        setTimeout(() => {
                            firstEditableField.focus();
                        }, 300);
                    }
                }
            });

            // Initialize order summary and other features on page load
            updateOrderSummary();

            // Add event listeners for payment options
            document.querySelectorAll('.payment-option').forEach(option => {
                option.addEventListener('click', function() {
                    const paymentType = this.querySelector('input[type="radio"]').value;
                    selectPayment(paymentType);
                });
            });

            // Add real-time validation for phone number
            const phoneInput = document.querySelector('input[name="nomor_telepon"]');
            if (phoneInput) {
                phoneInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.startsWith('0')) {
                        e.target.value = value;
                    } else if (value.startsWith('62')) {
                        e.target.value = '0' + value.slice(2);
                    }

                    // Real-time validation
                    if (value.length >= 10 && value.startsWith('08')) {
                        clearFieldError('nomor_telepon');
                        e.target.classList.add('is-valid');
                    } else {
                        e.target.classList.remove('is-valid');
                    }
                });
            }

            // Add real-time validation for address
            const addressInput = document.querySelector('input[name="alamat"]');
            if (addressInput) {
                addressInput.addEventListener('input', function(e) {
                    if (e.target.value.length >= 10) {
                        clearFieldError('alamat');
                        e.target.classList.add('is-valid');
                    } else {
                        e.target.classList.remove('is-valid');
                    }
                });
            }

            // Set minimum date for date picker
            const dateInput = document.querySelector('input[name="tanggal_pelaksanaan"]');
            if (dateInput) {
                const tomorrow = new Date();
                tomorrow.setDate(tomorrow.getDate() + 1);
                const minDate = tomorrow.toISOString().split('T')[0];
                dateInput.setAttribute('min', minDate);

                dateInput.addEventListener('change', function(e) {
                    const selectedDate = new Date(e.target.value);
                    const tomorrow = new Date();
                    tomorrow.setDate(tomorrow.getDate() + 1);
                    tomorrow.setHours(0, 0, 0, 0);

                    if (selectedDate >= tomorrow) {
                        clearFieldError('tanggal_pelaksanaan');
                        e.target.classList.add('is-valid');
                    }
                });
            }

            // Add event listener for modal reset
            const modal = document.getElementById('addOrderModal');
            modal.addEventListener('hidden.bs.modal', function() {
                // Reset form and selections
                document.getElementById('newOrderForm').reset();
                selectedService = null;

                // Clear all visual selections
                document.querySelectorAll('.service-card.selected').forEach(card => {
                    card.classList.remove('selected');
                });
                document.querySelectorAll('.payment-option.selected').forEach(option => {
                    option.classList.remove('selected');
                });

                // Clear all validation states
                document.querySelectorAll('.is-valid, .is-invalid').forEach(el => {
                    el.classList.remove('is-valid', 'is-invalid');
                });
                document.querySelectorAll('.invalid-feedback').forEach(el => {
                    el.style.display = 'none';
                });

                // Reset order summary
                updateOrderSummary();

                // Reset submit button
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.classList.remove('loading');
                submitBtn.disabled = false;
            });
        });

        // Auto-format admin fee on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Format admin fee in summary
            const adminFeeElement = document.getElementById('summary-admin-fee');
            if (adminFeeElement) {
                adminFeeElement.textContent = formatRupiah(adminFee);
            }

            // Initial summary update
            updateOrderSummary();
        });

        // Real-time validation
        document.querySelectorAll('.form-control-modern, .form-select-modern, .form-textarea-modern').forEach(field => {
            field.addEventListener('input', function() {
                if (this.value.trim()) {
                    clearFieldError(this.name);
                }
            });

            field.addEventListener('blur', function() {
                if (this.hasAttribute('required') && !this.value.trim()) {
                    showFieldError(this.name, 'Field ini wajib diisi');
                }
            });
        });

        // Set minimum date to tomorrow
        document.addEventListener('DOMContentLoaded', function() {
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            const tomorrowStr = tomorrow.toISOString().split('T')[0];
            const dateField = document.querySelector('[name="tanggal_pelaksanaan"]');
            if (dateField) {
                dateField.setAttribute('min', tomorrowStr);
            }
        });

        // Cancel order
        function cancelOrder(orderId) {
            if (confirm(
                    'Apakah Anda yakin ingin membatalkan pesanan ini?\n\nPesanan yang dibatalkan tidak dapat dikembalikan.'
                )) {
                // Here you would make an AJAX call to cancel the order
                alert('Pesanan berhasil dibatalkan. Anda akan segera menerima konfirmasi pembatalan.');
                // Example:
                // fetch('/api/orders/' + orderId + '/cancel', {
                //     method: 'POST',
                //     headers: {
                //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                //         'Content-Type': 'application/json'
                //     }
                // })
                // .then(response => response.json())
                // .then(data => {
                //     if (data.success) {
                //         location.reload();
                //     }
                // });
            }
        }

        // Edit order
        function editOrder(orderId) {
            alert(
                'Fitur edit pesanan akan segera tersedia.\n\nAnda dapat menghubungi customer service untuk sementara waktu.'
            );
            // Here you would redirect to edit page or open modal
        }

        // Contact provider
        function contactProvider(orderId) {
            const message = encodeURIComponent(`Halo, saya ingin menanyakan tentang pesanan #${orderId}. Terima kasih.`);
            const whatsappUrl = `https://wa.me/6281316814112?text=${message}`;
            window.open(whatsappUrl, '_blank');
        }

        // View order details
        function viewDetails(orderId) {
            alert(
                `Detail lengkap pesanan #${orderId}\n\nFitur detail pesanan akan segera tersedia dengan informasi yang lebih lengkap.`
            );
            // Here you would redirect to order details page or open modal
        }

        // Track order
        function trackOrder(orderId) {
            alert(
                `Pelacakan pesanan #${orderId}\n\nFitur pelacakan real-time akan segera tersedia untuk memantau lokasi penyedia jasa.`
            );
            // Here you would open tracking page or modal
        }

        // Auto refresh every 30 seconds for status updates
        let autoRefreshInterval;

        function startAutoRefresh() {
            autoRefreshInterval = setInterval(() => {
                // Check for status updates
                fetch(window.location.href, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        // Parse the response and update only if there are changes
                        const parser = new DOMParser();
                        const newDoc = parser.parseFromString(html, 'text/html');
                        const currentOrders = document.querySelectorAll('.active-order-card').length;
                        const newOrders = newDoc.querySelectorAll('.active-order-card').length;

                        if (currentOrders !== newOrders) {
                            // Reload page if number of orders changed
                            location.reload();
                        }
                    })
                    .catch(error => {
                        console.log('Auto refresh failed:', error);
                    });
            }, 30000); // 30 seconds
        }

        function stopAutoRefresh() {
            if (autoRefreshInterval) {
                clearInterval(autoRefreshInterval);
            }
        }

        // Start auto refresh when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Initial animation
            const orderCards = document.querySelectorAll('.active-order-card');
            orderCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';

                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 200);
            });

            // Start auto refresh if there are active orders
            if (orderCards.length > 0) {
                startAutoRefresh();
            }
        });

        // Stop auto refresh when page is hidden
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                stopAutoRefresh();
            } else {
                const orderCards = document.querySelectorAll('.active-order-card');
                if (orderCards.length > 0) {
                    startAutoRefresh();
                }
            }
        });

        // Stop auto refresh when page unloads
        window.addEventListener('beforeunload', stopAutoRefresh);

        // Enhanced service card interaction
        document.addEventListener('DOMContentLoaded', function() {
            // Make service cards focusable and add keyboard navigation
            document.querySelectorAll('.service-card').forEach((card, index) => {
                card.setAttribute('tabindex', '0');
                card.setAttribute('role', 'button');
                card.setAttribute('aria-label', 'Pilih layanan ' + card.querySelector('.service-name')
                    .textContent);

                // Keyboard navigation
                card.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        card.click();
                    }
                });

                // Enhanced visual feedback
                card.addEventListener('focus', function() {
                    card.style.transform = 'scale(1.02)';
                    card.style.boxShadow = '0 4px 20px rgba(58, 184, 255, 0.3)';
                });

                card.addEventListener('blur', function() {
                    if (!card.classList.contains('selected')) {
                        card.style.transform = 'scale(1)';
                        card.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
                    }
                });
            });
        });

        // Auto-fill form with user data function
        function autoFillUserData() {
            // Nomor telepon akan diisi dengan nomor WA user jika ada
            const phoneField = document.querySelector('[name="nomor_telepon"]');
            if (phoneField && phoneField.value === '') {
                const userPhone = '{{ auth()->user()->nomor_wa ?? '' }}';
                if (userPhone) {
                    phoneField.value = userPhone;
                }
            }
        }

        // Enhanced validation messages
        function getValidationMessage(fieldName, value) {
            switch (fieldName) {
                case 'service_id':
                    return 'Silakan pilih salah satu layanan yang tersedia';
                case 'nomor_telepon':
                    if (!value) return 'Nomor telepon wajib diisi';
                    if (!/^08\d{8,11}$/.test(value)) return 'Format nomor telepon tidak valid (contoh: 08123456789)';
                    break;
                case 'tanggal_pelaksanaan':
                    if (!value) return 'Tanggal pelaksanaan wajib dipilih';
                    const selectedDate = new Date(value);
                    const tomorrow = new Date();
                    tomorrow.setDate(tomorrow.getDate() + 1);
                    if (selectedDate < tomorrow) return 'Tanggal pelaksanaan minimal H+1 dari hari ini';
                    break;
                case 'waktu_kerja':
                    return 'Estimasi waktu kerja wajib dipilih';
                case 'gender':
                    return 'Preferensi gender wajib dipilih';
                case 'pembayaran':
                    return 'Metode pembayaran wajib dipilih';
                case 'deskripsi':
                    if (!value) return 'Deskripsi pekerjaan wajib diisi';
                    if (value.length < 10) return 'Deskripsi minimal 10 karakter';
                    if (value.length > 500) return 'Deskripsi maksimal 500 karakter';
                    break;
                default:
                    return 'Field ini wajib diisi';
            }
            return null;
        }

        // Progress line animation
        document.addEventListener('DOMContentLoaded', function() {
            const progressLines = document.querySelectorAll('.progress-line-active');

            progressLines.forEach(function(line) {
                const step = line.getAttribute('data-step');
                let width = '0%';

                switch (step) {
                    case '1':
                        width = '0%';
                        break;
                    case '2':
                        width = '33.33%';
                        break;
                    case '3':
                        width = '66.66%';
                        break;
                    case '4':
                        width = '100%';
                        break;
                }

                // Animate the progress line
                setTimeout(function() {
                    line.style.width = width;
                }, 200);
            });
        });

        // Auto dismiss flash messages after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const flashMessages = document.querySelectorAll('.alert-dismissible');

            if (flashMessages.length > 0) {
                setTimeout(function() {
                    flashMessages.forEach(function(flashMessage) {
                        const closeBtn = flashMessage.querySelector('.btn-close');
                        if (closeBtn) {
                            closeBtn.click();
                        } else {
                            flashMessage.classList.remove('show');
                            setTimeout(() => {
                                flashMessage.remove();
                            }, 150);
                        }
                    });
                }, 5000); // 5 seconds
            }
        });
    </script>
@endpush
