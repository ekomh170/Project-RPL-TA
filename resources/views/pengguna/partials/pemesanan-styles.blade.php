@push('styles')
    <style>
        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, #3ab8ff 0%, #377D98 100%);
            color: white;
            padding: 60px 0;
            position: relative;
        }

        /* Active Order Card */
        .active-order-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid #f0f0f0;
            position: relative;
        }

        .active-order-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .order-header {
            background: linear-gradient(135deg, #3ab8ff, #377D98);
            color: white;
            padding: 20px;
            position: relative;
        }

        .order-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: rgba(255, 255, 255, 0.3);
        }

        .order-id {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .order-date {
            font-size: 0.85rem;
            opacity: 0.9;
            margin-top: 2px;
        }

        .order-body {
            padding: 25px;
        }

        .service-info {
            display: flex;
            align-items: start;
            gap: 20px;
            margin-bottom: 25px;
        }

        .service-image {
            width: 100px;
            height: 100px;
            border-radius: 15px;
            object-fit: cover;
            flex-shrink: 0;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .service-details h5 {
            margin: 0 0 8px;
            font-weight: 700;
            color: #333;
            font-size: 1.2rem;
        }

        .service-details .provider {
            color: #666;
            font-size: 0.95rem;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .service-details .price {
            color: #3ab8ff;
            font-weight: 700;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .order-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e9ecef;
        }

        .info-row:last-child {
            margin-bottom: 0;
            border-bottom: none;
            padding-bottom: 0;
        }

        .info-label {
            color: #666;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .info-value {
            color: #333;
            font-weight: 600;
        }

        /* Status Progress */
        .status-progress {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
        }

        .progress-container {
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding: 0 25px;
            /* Add padding to better position the line */
        }

        .progress-line {
            position: absolute;
            top: 50%;
            left: 25px;
            right: 25px;
            height: 3px;
            background: #dee2e6;
            border-radius: 3px;
            z-index: 1;
            transform: translateY(-50%);
        }

        .progress-line-active {
            position: absolute;
            top: 50%;
            left: 25px;
            height: 3px;
            background: linear-gradient(135deg, #3ab8ff, #377D98);
            border-radius: 3px;
            z-index: 2;
            transition: width 0.8s ease-in-out;
            transform: translateY(-50%);
            box-shadow: 0 2px 8px rgba(58, 184, 255, 0.3);
        }

        /* Progress line width based on step */
        .progress-line-active[data-step="1"] {
            width: 0%;
        }

        .progress-line-active[data-step="2"] {
            width: 33.33%;
        }

        .progress-line-active[data-step="3"] {
            width: 66.66%;
        }

        .progress-line-active[data-step="4"] {
            width: 100%;
        }

        .progress-step {
            position: relative;
            z-index: 3;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #e9ecef;
            color: #666;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            border: 3px solid #fff;
            margin: 0 auto;
        }

        .progress-step.active {
            background: linear-gradient(135deg, #3ab8ff, #377D98);
            color: white;
            transform: scale(1.15);
            border-color: #fff;
            box-shadow: 0 6px 20px rgba(58, 184, 255, 0.4);
        }

        .progress-step.completed {
            background: linear-gradient(135deg, #28a745, #1e7e34);
            color: white;
            border-color: #fff;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }

        /* Individual step states */
        .progress-step[data-step="1"] {
            order: 1;
        }

        .progress-step[data-step="2"] {
            order: 2;
        }

        .progress-step[data-step="3"] {
            order: 3;
        }

        .progress-step[data-step="4"] {
            order: 4;
        }

        .progress-labels {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            padding: 0 25px;
        }

        .progress-label {
            text-align: center;
            font-size: 0.75rem;
            font-weight: 500;
            color: #666;
            padding: 0 5px;
        }

        .progress-label.active {
            color: #3ab8ff;
            font-weight: 700;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-action {
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 0.875rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .btn-detail {
            background: #3ab8ff;
            color: white;
        }

        .btn-detail:hover {
            background: #2a8fd9;
            color: white;
            transform: translateY(-1px);
        }

        .btn-chat {
            background: #28a745;
            color: white;
        }

        .btn-chat:hover {
            background: #1e7e34;
            color: white;
            transform: translateY(-1px);
        }

        .btn-cancel {
            background: #dc3545;
            color: white;
        }

        .btn-cancel:hover {
            background: #c82333;
            color: white;
            transform: translateY(-1px);
        }

        /* Modal Styles */
        .modal-header {
            background: linear-gradient(135deg, #3ab8ff 0%, #377D98 100%);
            color: white;
            border-radius: 15px 15px 0 0;
            border: none;
            padding: 25px 30px;
        }

        .modal-title-container {
            flex: 1;
        }

        .btn-close-custom {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-close-custom:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            transform: rotate(90deg);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #3ab8ff;
            box-shadow: 0 0 0 0.2rem rgba(58, 184, 255, 0.1);
        }

        .form-select {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-select:focus {
            border-color: #3ab8ff;
            box-shadow: 0 0 0 0.2rem rgba(58, 184, 255, 0.1);
        }

        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 5px;
        }

        .is-invalid {
            border-color: #dc3545 !important;
        }

        .price-display {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            border: 2px solid #e9ecef;
        }

        .price-display .price-amount {
            font-size: 1.5rem;
            font-weight: 700;
            color: #3ab8ff;
            margin-bottom: 5px;
        }

        .price-display .price-label {
            color: #666;
            font-size: 0.9rem;
        }

        .btn-cta {
            background: linear-gradient(135deg, #3ab8ff 0%, #377D98 100%);
            color: white;
            padding: 15px 30px;
            border-radius: 50px;
            border: none;
            font-weight: 700;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(58, 184, 255, 0.3);
        }

        .btn-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(58, 184, 255, 0.4);
            color: white;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3ab8ff 0%, #377D98 100%);
            border: none;
            padding: 12px 25px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2a8fd9 0%, #2c5f73 100%);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #6c757d;
            border: none;
            padding: 12px 25px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-1px);
        }

        /* Fix for Order Card Layout Issues */
        .order-header .d-flex {
            flex-wrap: wrap;
            gap: 10px;
        }

        .order-date {
            font-size: 0.85rem;
            opacity: 0.9;
            margin-top: 2px;
        }

        .status-badge {
            border-radius: 20px;
            padding: 6px 12px;
            font-size: 0.8rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .status-pending {
            background: #ffc107;
            color: #000;
        }

        .status-diproses {
            background: #17a2b8;
            color: white;
        }

        .status-dikerjakan {
            background: #28a745;
            color: white;
        }

        .status-selesai {
            background: #6f42c1;
            color: white;
        }

        /* Better Progress Circle Layout */
        .progress-step {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border: 3px solid transparent;
        }

        .progress-step.active {
            border-color: rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 12px rgba(58, 184, 255, 0.3);
        }

        .progress-labels {
            margin-top: 10px;
        }

        .progress-label {
            text-align: center;
            font-size: 0.75rem;
            font-weight: 500;
            color: #666;
            padding: 0 5px;
        }

        .progress-label.active {
            color: #3ab8ff;
            font-weight: 700;
        }

        /* Better Order Info Layout */
        .order-note,
        .order-preference,
        .order-payment {
            background: #f8f9fa;
            padding: 12px 15px;
            border-radius: 8px;
            border-left: 3px solid #3ab8ff;
            margin-bottom: 15px;
        }

        .order-note strong,
        .order-preference strong,
        .order-payment strong {
            color: #333;
            display: block;
            margin-bottom: 5px;
        }

        /* Better Action Buttons Layout */
        .order-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #e9ecef;
        }

        .btn-action {
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 0.875rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .btn-danger-action {
            background: #dc3545;
            color: white;
        }

        .btn-danger-action:hover {
            background: #c82333;
            transform: translateY(-1px);
        }

        .btn-primary-action {
            background: #3ab8ff;
            color: white;
        }

        .btn-primary-action:hover {
            background: #2a9fd8;
            transform: translateY(-1px);
        }

        .btn-success-action {
            background: #28a745;
            color: white;
        }

        .btn-success-action:hover {
            background: #218838;
            transform: translateY(-1px);
        }

        /* Modal Form Styles */
        .form-section {
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: #f8f9fa;
            border-radius: 15px;
            border: 1px solid #e9ecef;
        }

        .section-header {
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #e9ecef;
        }

        .section-title {
            color: #333;
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .section-subtitle {
            color: #666;
            font-size: 0.9rem;
            margin: 0;
        }

        /* Service Selection Cards */
        .service-selection {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-bottom: 1rem;
        }

        .service-card {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .service-card:hover {
            border-color: #3ab8ff;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(58, 184, 255, 0.15);
        }

        .service-card.selected {
            border-color: #3ab8ff;
            background: linear-gradient(135deg, rgba(58, 184, 255, 0.1), rgba(55, 125, 152, 0.05));
            box-shadow: 0 5px 20px rgba(58, 184, 255, 0.2);
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #3ab8ff, #377D98);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .service-card.selected::before {
            transform: scaleX(1);
        }

        .service-name {
            font-weight: 700;
            color: #333;
            font-size: 1.1rem;
            margin-bottom: 8px;
        }

        .service-price {
            color: #3ab8ff;
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 5px;
        }

        .service-description {
            color: #666;
            font-size: 0.9rem;
        }

        /* Form Controls */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 0;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: flex;
            align-items: center;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-label i {
            color: #3ab8ff;
            width: 20px;
        }

        .form-control-modern {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control-modern:focus {
            outline: none;
            border-color: #3ab8ff;
            box-shadow: 0 0 0 0.2rem rgba(58, 184, 255, 0.1);
            transform: translateY(-1px);
        }

        .form-control-modern.is-invalid {
            border-color: #dc3545;
        }

        .form-textarea-modern {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: white;
            resize: vertical;
            min-height: 120px;
            font-family: inherit;
        }

        .form-textarea-modern:focus {
            outline: none;
            border-color: #3ab8ff;
            box-shadow: 0 0 0 0.2rem rgba(58, 184, 255, 0.1);
        }

        /* Price Display */
        .price-display {
            background: linear-gradient(135deg, rgba(58, 184, 255, 0.1), rgba(55, 125, 152, 0.05));
            border: 2px solid #3ab8ff;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
            animation: fadeIn 0.5s ease;
        }

        .price-label {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .price-value {
            color: #3ab8ff;
            font-size: 1.8rem;
            font-weight: 700;
        }

        /* Submit Button */
        .btn-submit-order {
            background: linear-gradient(135deg, #3ab8ff, #377D98);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1rem;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            min-height: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-submit-order:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(58, 184, 255, 0.4);
        }

        .btn-submit-order:active {
            transform: translateY(0);
        }

        .btn-submit-order .btn-loading {
            display: none;
        }

        .btn-submit-order.loading .btn-text {
            display: none;
        }

        .btn-submit-order.loading .btn-loading {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Loading Spinner */
        .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Invalid Feedback */
        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875rem;
            color: #dc3545;
        }

        /* Small Text */
        .form-group small {
            display: block;
            margin-top: 0.25rem;
            color: #6c757d;
            font-size: 0.875rem;
        }

        /* Modal Responsive */
        @media (max-width: 767.98px) {
            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .service-selection {
                grid-template-columns: 1fr;
            }

            .form-section {
                padding: 1rem;
                margin-bottom: 1.5rem;
            }

            .section-title {
                font-size: 1rem;
            }

            .service-card {
                padding: 15px;
            }

            .price-value {
                font-size: 1.5rem;
            }

            .btn-submit-order {
                padding: 12px 25px;
                font-size: 0.95rem;
            }
        }

        @media (max-width: 575.98px) {
            .modal-dialog {
                margin: 0;
                max-width: 100%;
                height: 100vh;
            }

            .modal-content {
                height: 100vh;
                border-radius: 0;
            }

            .modal-header {
                padding: 15px;
            }

            .modal-body {
                padding: 15px;
            }

            .form-section {
                padding: 15px;
                margin-bottom: 1rem;
            }
        }

        /* Payment Methods */
        .payment-methods {
            display: grid;
            gap: 15px;
            margin-bottom: 1rem;
        }

        .payment-option {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 15px;
            position: relative;
        }

        .payment-option:hover {
            border-color: #3ab8ff;
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(58, 184, 255, 0.1);
        }

        .payment-option.selected {
            border-color: #3ab8ff;
            background: linear-gradient(135deg, rgba(58, 184, 255, 0.1), rgba(55, 125, 152, 0.05));
            box-shadow: 0 3px 12px rgba(58, 184, 255, 0.2);
        }

        .payment-radio {
            position: relative;
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        .payment-radio input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            margin: 0;
            cursor: pointer;
        }

        .payment-radio label {
            position: absolute;
            top: 0;
            left: 0;
            width: 20px;
            height: 20px;
            border: 2px solid #dee2e6;
            border-radius: 50%;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .payment-radio label::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0);
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #3ab8ff;
            transition: transform 0.2s ease;
        }

        .payment-radio input[type="radio"]:checked+label {
            border-color: #3ab8ff;
        }

        .payment-radio input[type="radio"]:checked+label::after {
            transform: translate(-50%, -50%) scale(1);
        }

        .payment-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #3ab8ff;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .payment-option.selected .payment-icon {
            background: linear-gradient(135deg, #3ab8ff, #377D98);
            color: white;
        }

        .payment-info {
            flex: 1;
        }

        .payment-title {
            font-weight: 700;
            color: #333;
            font-size: 1.1rem;
            margin-bottom: 4px;
        }

        .payment-desc {
            color: #666;
            font-size: 0.9rem;
        }

        /* Order Summary */
        .order-summary {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            border: 1px solid #e9ecef;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e9ecef;
        }

        .summary-row:last-of-type {
            margin-bottom: 0;
            border-bottom: none;
            padding-bottom: 0;
        }

        .summary-label {
            color: #666;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .summary-value {
            color: #333;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .summary-divider {
            height: 2px;
            background: linear-gradient(135deg, #3ab8ff, #377D98);
            border-radius: 2px;
            margin: 15px 0;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-top: 2px solid #3ab8ff;
            margin-top: 10px;
        }

        .total-label {
            color: #333;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .total-value {
            color: #3ab8ff;
            font-weight: 700;
            font-size: 1.3rem;
        }

        /* Security Note */
        .security-note {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(34, 139, 34, 0.05));
            border: 1px solid rgba(40, 167, 69, 0.2);
            border-radius: 10px;
            padding: 15px;
            margin-top: 20px;
            color: #28a745;
            font-size: 0.9rem;
            font-weight: 500;
            text-align: center;
        }

        .security-note i {
            color: #28a745;
        }

        /* Enhanced Service Card */
        .service-card {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .service-card:hover {
            border-color: #3ab8ff;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(58, 184, 255, 0.15);
        }

        .service-card.selected {
            border-color: #3ab8ff;
            background: linear-gradient(135deg, rgba(58, 184, 255, 0.1), rgba(55, 125, 152, 0.05));
            box-shadow: 0 5px 20px rgba(58, 184, 255, 0.2);
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #3ab8ff, #377D98);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .service-card.selected::before {
            transform: scaleX(1);
        }

        .service-name {
            font-weight: 700;
            color: #333;
            font-size: 1.1rem;
            margin-bottom: 8px;
        }

        .service-category {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .service-price {
            color: #3ab8ff;
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 5px;
        }

        /* Enhanced responsiveness for new elements */
        @media (max-width: 991.98px) {
            .payment-methods {
                gap: 12px;
            }

            .payment-option {
                padding: 16px;
            }

            .payment-icon {
                width: 45px;
                height: 45px;
                font-size: 1.3rem;
            }

            .order-summary {
                padding: 16px;
            }

            .total-value {
                font-size: 1.2rem;
            }
        }

        @media (max-width: 767.98px) {
            .payment-option {
                padding: 14px;
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }

            .payment-radio {
                position: absolute;
                top: 10px;
                right: 10px;
            }

            .order-summary {
                padding: 14px;
            }

            .summary-total {
                flex-direction: column;
                gap: 8px;
                text-align: center;
            }

            .total-value {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 575.98px) {
            .payment-methods {
                gap: 10px;
            }

            .payment-option {
                padding: 12px;
            }

            .payment-icon {
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
            }

            .payment-title {
                font-size: 1rem;
            }

            .payment-desc {
                font-size: 0.85rem;
            }

            .security-note {
                padding: 12px;
                font-size: 0.85rem;
            }
        }
    </style>
@endpush
