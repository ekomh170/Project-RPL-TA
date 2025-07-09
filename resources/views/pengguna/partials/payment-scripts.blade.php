@push('scripts')
    <script>
        // Check authentication status
        const isAuthenticated = @json(Auth::check());
        const loginUrl = @json(route('customer.login'));

        // Service data
        const services = @json($services);
        const serviceProviders = @json($serviceProviders ?? []);
        console.log("Service Providers Data:", serviceProviders);
        let selectedServiceIndex = 0;
        let selectedServiceId = null;

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
            console.log(`Selecting service at index ${index}`);

            // Check if user is logged in
            if (!checkLoginRequired()) {
                return;
            } // Get the service element
            const serviceElement = document.querySelectorAll('.service-option')[index];
            if (!serviceElement) {
                console.error(`No service element found at index ${index}`);
                return;
            }

            // Skip if the service is disabled (already ordered)
            if (serviceElement.classList.contains('disabled')) {
                console.log(`Service at index ${index} is disabled`);
                return;
            }

            // Check if this service has providers before proceeding
            const serviceId = services[index].id;
            const hasProviders = serviceProviders[serviceId] && serviceProviders[serviceId].length > 0;

            // Remove selected class from all options
            document.querySelectorAll('.service-option').forEach(option => {
                option.classList.remove('selected');
            });

            // Add selected class to clicked option
            serviceElement.classList.add('selected');

            // Check radio button
            const serviceRadio = document.getElementById(`service_${index}`);
            if (serviceRadio) {
                serviceRadio.checked = true;
            } else {
                console.error(`No radio element found for service_${index}`);
            }

            selectedServiceIndex = index;
            selectedServiceId = services[index].id;
            console.log(`Selected service ID: ${selectedServiceId}`);

            updateOrderSummary();
            updateProviderOptions(selectedServiceId);
        } // Update provider dropdown based on selected service
        function updateProviderOptions(serviceId) {
            const providerSelect = document.getElementById('provider_id');
            const providerWarningEl = document.getElementById('providerWarning');

            // Clear existing options
            providerSelect.innerHTML = '<option value="">-- Pilih Penyedia Jasa --</option>';

            // Hide provider details
            document.getElementById('providerDetails').classList.add('d-none');

            // Hide any previous warning
            if (providerWarningEl) {
                providerWarningEl.style.display = 'none';
            }

            if (!serviceId) {
                console.log("Service ID is null or undefined");
                return;
            }

            console.log("Service ID:", serviceId);
            console.log("All service providers:", serviceProviders);

            if (!serviceProviders[serviceId]) {
                console.log(`No providers defined for service ID ${serviceId}`);
                const noOption = document.createElement('option');
                noOption.value = "";
                noOption.text = "Tidak ada penyedia jasa untuk layanan ini";
                noOption.disabled = true;
                providerSelect.appendChild(noOption);

                // Show warning message
                if (providerWarningEl) {
                    providerWarningEl.style.display = 'block';
                }
                return;
            }

            const providers = serviceProviders[serviceId];
            console.log(`Loading ${providers.length} providers for service ${serviceId}:`, providers);

            if (!providers || providers.length === 0) {
                // No providers available for this service
                console.log(`No providers available for service ID ${serviceId}`);
                const noOption = document.createElement('option');
                noOption.value = "";
                noOption.text = "Tidak ada penyedia jasa tersedia";
                noOption.disabled = true;
                providerSelect.appendChild(noOption);

                // Show warning message
                if (providerWarningEl) {
                    providerWarningEl.style.display = 'block';
                    providerWarningEl.innerHTML = `
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Perhatian!</strong> Tidak ada penyedia jasa tersedia untuk layanan ini saat ini. 
                        <button type="button" id="findProvidersBtn" class="btn btn-warning btn-sm mt-2">
                            <i class="fas fa-search me-1"></i>Cari Layanan dengan Penyedia
                        </button>
                    `;

                    // Tambahkan event listener untuk tombol cari layanan dengan penyedia
                    setTimeout(() => {
                        const findProvidersBtn = document.getElementById('findProvidersBtn');
                        if (findProvidersBtn) {
                            findProvidersBtn.addEventListener('click', switchToServiceWithProviders);
                        }
                    }, 100);
                }

                // Disable submit button
                const submitBtn = document.getElementById('submitBtn');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-exclamation-circle me-2"></i>Tidak Ada Penyedia Jasa';
                }
                return;
            } else {
                // Enable submit button if it was disabled
                const submitBtn = document.getElementById('submitBtn');
                if (submitBtn && submitBtn.disabled) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-lock me-2"></i>Konfirmasi & Bayar';
                }
            }

            // Add provider options
            providers.forEach(provider => {
                console.log(`Processing provider:`, provider);
                try {
                    const option = document.createElement('option');
                    option.value = provider.id;

                    // Check if user data exists and has name property
                    let providerName = "";

                    if (provider.user && typeof provider.user === 'object' && provider.user.name) {
                        // Jika user adalah object dengan property name
                        providerName = provider.user.name;
                        console.log(`Provider #${provider.id} has user object with name: ${providerName}`);
                    } else if (provider.user && typeof provider.user === 'string') {
                        // Jika user adalah string (mungkin serialisasi yang salah)
                        providerName = provider.user;
                        console.log(`Provider #${provider.id} has user as string: ${providerName}`);
                    } else if (provider.user_id) {
                        // Jika user_id tersedia
                        providerName = `Penyedia #${provider.user_id}`;
                        console.log(`Provider #${provider.id} has user_id: ${provider.user_id}`);
                    } else {
                        // Fallback ke id provider
                        providerName = `Penyedia Jasa #${provider.id}`;
                        console.log(`Provider #${provider.id} has no user info`);
                    }

                    option.text = providerName;
                    option.dataset.rating = provider.rating_average || "0";
                    option.dataset.reviews = provider.total_reviews || "0";
                    option.dataset.experience = provider.experience || "Tidak disebutkan";
                    providerSelect.appendChild(option);
                    console.log(`Added option: ${providerName}`);
                } catch (error) {
                    console.error(`Error processing provider ${JSON.stringify(provider)}:`, error);
                }
            });
        }

        // Handle provider selection
        document.getElementById('provider_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const providerDetails = document.getElementById('providerDetails');

            if (this.value === "") {
                providerDetails.classList.add('d-none');
                return;
            }

            // Show provider details
            document.getElementById('selectedProviderName').textContent = selectedOption.text;
            document.getElementById('selectedProviderRating').textContent = selectedOption.dataset.rating || "0";
            document.getElementById('selectedProviderReviews').textContent = selectedOption.dataset.reviews || "0";
            document.getElementById('selectedProviderExperience').textContent =
                `Pengalaman: ${selectedOption.dataset.experience || "Tidak disebutkan"}`;

            providerDetails.classList.remove('d-none');
        });

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
            // PENTING: Biarkan formulir tersubmit secara normal, jangan gunakan e.preventDefault()

            // Check if all services are disabled
            const serviceOptions = document.querySelectorAll('.service-option');
            let allDisabled = true;

            for (let i = 0; i < serviceOptions.length; i++) {
                if (!serviceOptions[i].classList.contains('disabled')) {
                    allDisabled = false;
                    break;
                }
            }

            if (allDisabled) {
                alert(
                    'Semua layanan sudah dipesan. Silakan cek halaman Pemesanan untuk melihat status pesanan Anda.'
                );
                e.preventDefault();
                return false;
            }

            // Check if user is logged in
            if (!checkLoginRequired()) {
                e.preventDefault();
                return;
            }

            const submitBtn = document.getElementById('submitBtn');

            // Validation
            const requiredFields = ['customer_name', 'customer_phone', 'customer_email', 'customer_address',
                'service_date', 'service_time', 'provider_id'
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
                alert('Harap lengkapi semua field yang diperlukan, termasuk memilih penyedia jasa!');
                e.preventDefault();
                return;
            }

            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses Pembayaran...';

            // Simpan layanan yang dipilih ke localStorage untuk deteksi perubahan status
            localStorage.setItem('lastOrderedServiceId', document.querySelector('input[name="service_id"]:checked')
                .value);

            // Biarkan formulir tersubmit ke server
            return true;
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
            } // Only initialize interactive features for authenticated users
            // Find first non-disabled service and select it
            const serviceOptions = document.querySelectorAll('.service-option');
            console.log(`Found ${serviceOptions.length} service options`);

            if (serviceOptions.length > 0) {
                // Find first non-disabled service that has providers
                let firstAvailableIndex = -1;
                let firstAvailableWithProvidersIndex = -1;

                // Tambahkan log untuk debugging
                console.log("Mencari layanan dengan penyedia jasa...");
                console.log("Daftar layanan tersedia:");

                // Tampilkan semua layanan yang memiliki penyedia jasa
                let availableServicesWithProviders = [];

                // First pass: find any available service
                for (let i = 0; i < serviceOptions.length; i++) {
                    const serviceId = services[i].id;
                    const isDisabled = serviceOptions[i].classList.contains('disabled');
                    const hasProviders = serviceProviders[serviceId] && serviceProviders[serviceId].length > 0;

                    console.log(
                        `Service #${serviceId} (index ${i}): ${services[i].name} - Disabled: ${isDisabled}, Has Providers: ${hasProviders}, Provider count: ${hasProviders ? serviceProviders[serviceId].length : 0}`
                        );

                    if (!isDisabled) {
                        if (firstAvailableIndex === -1) {
                            firstAvailableIndex = i;
                            console.log(`First available service is at index ${i} (ID: ${serviceId})`);
                        }

                        if (hasProviders) {
                            availableServicesWithProviders.push({
                                index: i,
                                id: serviceId,
                                name: services[i].name,
                                providerCount: serviceProviders[serviceId].length
                            });

                            if (firstAvailableWithProvidersIndex === -1) {
                                firstAvailableWithProvidersIndex = i;
                                console.log(
                                    `First available service with providers is at index ${i} (ID: ${serviceId})`
                                    );
                            }
                        }
                    }
                }

                console.log("Layanan tersedia dengan penyedia jasa:", availableServicesWithProviders);

                // Prefer services with providers, fallback to any available service
                const selectedIndex = (firstAvailableWithProvidersIndex !== -1) ?
                    firstAvailableWithProvidersIndex : firstAvailableIndex;

                console.log(
                    `Pemilihan layanan: firstAvailableWithProvidersIndex=${firstAvailableWithProvidersIndex}, firstAvailableIndex=${firstAvailableIndex}, selectedIndex=${selectedIndex}`
                    );

                if (selectedIndex >= 0) {
                    console.log(`Selecting service at index ${selectedIndex} (ID: ${services[selectedIndex].id})`);

                    // Validasi bahwa layanan ini memiliki penyedia jasa
                    const serviceId = services[selectedIndex].id;
                    const hasProviders = serviceProviders[serviceId] && serviceProviders[serviceId].length > 0;
                    console.log(`Layanan terpilih ${serviceId} memiliki penyedia jasa: ${hasProviders}`);

                    if (hasProviders) {
                        console.log(`Penyedia jasa untuk layanan ${serviceId}:`, serviceProviders[serviceId]);
                    }

                    // Manually set initial values
                    selectedServiceIndex = selectedIndex;
                    selectedServiceId = services[selectedIndex].id;

                    // Select the service in UI - Perbaikan: gunakan selectedIndex, bukan firstAvailableIndex
                    const serviceElement = serviceOptions[selectedIndex];
                    serviceElement.classList.add('selected');

                    // Check the radio
                    const radioElement = document.getElementById(`service_${selectedIndex}`);
                    if (radioElement) {
                        radioElement.checked = true;
                    }

                    // Update UI
                    updateOrderSummary();
                    updateProviderOptions(selectedServiceId);

                    console.log(`Initialized with service ID ${selectedServiceId}`);
                } else {
                    // All services are disabled/ordered
                    console.log('All services are disabled/ordered');
                    document.getElementById('selectedService').querySelector('.summary-value').textContent =
                        'Semua layanan sudah dipesan';
                    document.getElementById('totalAmount').textContent = 'Rp. 0';
                    document.getElementById('submitBtn').disabled = true;
                    document.getElementById('submitBtn').textContent = 'Tidak ada layanan tersedia';
                }
            }

            // Select first payment method by default
            selectPayment('cash');

            // Set minimum date to today
            document.getElementById('service_date').min = new Date().toISOString().split('T')[0];

            // Tambahkan event listener untuk semua elemen service option
            document.querySelectorAll('.service-option:not(.disabled)').forEach(option => {
                option.addEventListener('click', function() {
                    // Ambil index layanan dari atribut data
                    const serviceIndex = parseInt(this.getAttribute('data-service-index'));
                    // Panggil fungsi selectService
                    selectService(serviceIndex);
                });
            });

            // Load More Services button
            const loadMoreBtn = document.getElementById('loadMoreServices');
            if (loadMoreBtn) {
                loadMoreBtn.addEventListener('click', function() {
                    document.querySelectorAll('.service-option').forEach(option => {
                        option.style.display = 'flex';
                    });
                    this.style.display = 'none';
                });
            }

            // Refresh Services button
            const refreshBtn = document.getElementById('refreshServices');
            if (refreshBtn) {
                refreshBtn.addEventListener('click', function() {
                    location.reload();
                });
            }

            // Refresh Providers button
            const refreshProvidersBtn = document.getElementById('refreshProviders');
            if (refreshProvidersBtn) {
                refreshProvidersBtn.addEventListener('click', function() {
                    // Get current selected service id
                    const selectedServiceRadio = document.querySelector('input[name="service_id"]:checked');
                    if (selectedServiceRadio) {
                        // Find its index in the service options
                        const serviceOptions = document.querySelectorAll('.service-option');
                        for (let i = 0; i < serviceOptions.length; i++) {
                            const radio = serviceOptions[i].querySelector('input[type="radio"]');
                            if (radio && radio.id === selectedServiceRadio.id) {
                                // Re-select this service to reload providers
                                selectService(i);
                                break;
                            }
                        }
                    } else {
                        alert('Pilih layanan terlebih dahulu untuk melihat penyedia jasa yang tersedia.');
                    }
                });
            }

            // Find Services With Providers button
            const findServicesBtn = document.getElementById('findServicesWithProviders');
            if (findServicesBtn) {
                findServicesBtn.addEventListener('click', function() {
                    switchToServiceWithProviders();
                });
            }

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

            // Tampilkan layanan dengan batasan (6 pertama)
            const allServiceOptions = document.querySelectorAll('.service-option');
            if (allServiceOptions.length > 6) {
                // Sembunyikan layanan setelah 6 pertama
                for (let i = 6; i < allServiceOptions.length; i++) {
                    allServiceOptions[i].style.display = 'none';
                }

                // Tambahkan event listener untuk tombol "Lihat Semua Layanan"
                const loadMoreBtn = document.getElementById('loadMoreServices');
                if (loadMoreBtn) {
                    loadMoreBtn.addEventListener('click', function() {
                        // Tampilkan semua layanan yang tersembunyi
                        for (let i = 6; i < allServiceOptions.length; i++) {
                            allServiceOptions[i].style.display = 'block';
                        }
                        // Sembunyikan tombol setelah diklik
                        this.style.display = 'none';
                    });
                }
            }
        });

        // Cek apakah pengguna baru kembali setelah berhasil membuat pesanan
        // PENTING: Kode ini dijalankan sekali ketika DOM sudah siap
        const lastOrderedServiceId = localStorage.getItem('lastOrderedServiceId');
        if (lastOrderedServiceId) {
            // Cek apakah layanan tersebut sekarang dalam status "disabled"
            const orderedIds = @json($orderedServiceIds ?? []);
            if (orderedIds.includes(parseInt(lastOrderedServiceId))) {
                // Tampilkan pesan sukses
                setTimeout(function() {
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-success mb-4';
                    alertDiv.innerHTML = `
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Pesanan Berhasil!</strong> Layanan yang Anda pesan sekarang dalam status menunggu konfirmasi.
                        <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
                    `;
                    const paymentBody = document.querySelector('.payment-body');
                    if (paymentBody) {
                        paymentBody.insertBefore(alertDiv, paymentBody.firstChild);
                    }

                    // Hapus data dari localStorage
                    localStorage.removeItem('lastOrderedServiceId');

                    // Auto-dismiss alert setelah 5 detik
                    setTimeout(function() {
                        alertDiv.remove();
                    }, 5000);
                }, 500);
            }
        }

        // Function to dump providers for debugging
        function dumpServiceProviders() {
            console.log("=== SERVICE PROVIDERS DEBUG ===");
            let servicesWithProviders = [];

            for (const serviceId in serviceProviders) {
                const providers = serviceProviders[serviceId];
                console.log(`Service ID ${serviceId} has ${providers.length} providers:`);

                if (providers && providers.length > 0) {
                    // Cari nama layanan berdasarkan ID
                    let serviceName = "Unknown Service";
                    for (let i = 0; i < services.length; i++) {
                        if (services[i].id == serviceId) {
                            serviceName = services[i].name;
                            break;
                        }
                    }

                    servicesWithProviders.push({
                        id: serviceId,
                        name: serviceName,
                        providers: providers.length
                    });
                }

                providers.forEach(provider => {
                    if (provider.user && typeof provider.user === 'object' && provider.user.name) {
                        console.log(`  - Provider #${provider.id} (${provider.user.name})`);
                    } else if (provider.user && typeof provider.user === 'object') {
                        console.log(`  - Provider #${provider.id} (${provider.user.name || 'No name'})`);
                    } else {
                        console.log(`  - Provider #${provider.id} (No user data)`);
                    }
                });
            }

            console.log("=== LAYANAN DENGAN PENYEDIA JASA ===");
            console.log(servicesWithProviders);
            console.log("==============================");

            return servicesWithProviders;
        }

        // Function to switch to a service with providers
        function switchToServiceWithProviders() {
            const servicesWithProviders = dumpServiceProviders();

            if (servicesWithProviders.length === 0) {
                alert("Tidak ada layanan dengan penyedia jasa tersedia saat ini.");
                return;
            }

            // Buat pesan dengan daftar layanan yang memiliki penyedia
            let message = "Layanan dengan penyedia jasa tersedia:\n\n";
            servicesWithProviders.forEach((service, index) => {
                message += `${index + 1}. ${service.name} (${service.providers} penyedia)\n`;
            });

            message += "\nPilih nomor layanan untuk beralih ke layanan tersebut:";

            // Minta pengguna memilih
            const selection = prompt(message, "1");
            if (selection === null) return; // User cancelled

            const selectedIndex = parseInt(selection) - 1;
            if (isNaN(selectedIndex) || selectedIndex < 0 || selectedIndex >= servicesWithProviders.length) {
                alert("Nomor pilihan tidak valid.");
                return;
            }

            const selectedServiceId = servicesWithProviders[selectedIndex].id;

            // Cari indeks di array services
            let serviceIndex = -1;
            for (let i = 0; i < services.length; i++) {
                if (services[i].id == selectedServiceId) {
                    serviceIndex = i;
                    break;
                }
            }

            if (serviceIndex === -1) {
                alert("Terjadi kesalahan saat memilih layanan.");
                return;
            }

            // Pilih layanan tersebut
            console.log(
                `Beralih ke layanan dengan penyedia jasa: ${servicesWithProviders[selectedIndex].name} (ID: ${selectedServiceId})`
                );
            selectService(serviceIndex);
        }

        // Dump service providers on page load
        const servicesWithProviders = dumpServiceProviders();

        // Highlight services with providers
        function highlightServicesWithProviders() {
            // Reset all indicators first
            document.querySelectorAll('.has-providers-indicator').forEach(indicator => {
                indicator.style.display = 'none';
            });

            // Show indicators for services that have providers
            servicesWithProviders.forEach(service => {
                const serviceOptions = document.querySelectorAll(
                `.service-option[data-service-id="${service.id}"]`);
                serviceOptions.forEach(option => {
                    const indicator = option.querySelector('.has-providers-indicator');
                    if (indicator) {
                        indicator.style.display = 'inline-block';
                        indicator.textContent = `${service.providers} Penyedia tersedia`;
                    }
                });
            });
        }

        // Call the highlight function
        highlightServicesWithProviders();
    </script>
@endpush
