@push('styles')
    <style>
        /* Payment Page Styles */
        .payment-page {
            background: #f8f9fa;
            min-height: 100vh;
            padding: 40px 0;
        }

        .page-header {
            background: linear-gradient(135deg, #3ab8ff 0%, #377D98 100%);
            color: white;
            padding: 60px 0;
            margin-bottom: 40px;
            position: relative;
        }

        .page-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 50px;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" fill="%23f8f9fa"><path d="M0,50L50,45C100,40,200,30,300,35C400,40,500,60,600,65C700,70,800,60,900,55C1000,50,1100,50,1150,50L1200,50V120H1150C1100,120,1000,120,900,120C800,120,700,120,600,120C500,120,400,120,300,120C200,120,100,120,50,120H0V50Z"/></svg>') no-repeat;
            background-size: cover;
        }

        .payment-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .payment-header {
            background: linear-gradient(135deg, #3ab8ff, #377D98);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .payment-header h3 {
            margin: 0 0 10px;
            font-size: 1.75rem;
            font-weight: 700;
        }

        .payment-header p {
            margin: 0;
            opacity: 0.9;
        }

        .payment-body {
            padding: 40px;
        }

        .service-selection {
            margin-bottom: 40px;
        }

        .service-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .service-option {
            border: 2px solid #eee;
            border-radius: 15px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
            position: relative;
        }

        .service-option:hover {
            border-color: #3ab8ff;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(58, 184, 255, 0.15);
        }

        .service-option.selected {
            border-color: #3ab8ff;
            background: #f0f9ff;
        }

        .service-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .service-info h5 {
            margin: 0 0 8px;
            font-weight: 600;
            color: #333;
        }

        .service-category {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .service-price {
            color: #3ab8ff;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .form-section {
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            border: 2px solid #eee;
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
            width: 100%;
            background: #f8f9fa;
        }

        .form-control:focus {
            outline: none;
            border-color: #3ab8ff;
            background: white;
            box-shadow: 0 0 0 3px rgba(58, 184, 255, 0.1);
        }

        .input-group {
            position: relative;
        }

        .input-group .form-control {
            padding-left: 45px;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            z-index: 3;
        }

        .payment-methods {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .payment-method {
            border: 2px solid #eee;
            border-radius: 12px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            background: white;
            position: relative;
        }

        .payment-method:hover {
            border-color: #3ab8ff;
            transform: translateY(-2px);
        }

        .payment-method.selected {
            border-color: #3ab8ff;
            background: #f0f9ff;
        }

        .payment-method input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .payment-icon {
            font-size: 2rem;
            color: #3ab8ff;
            margin-bottom: 10px;
        }

        .payment-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .payment-desc {
            font-size: 0.9rem;
            color: #666;
        }

        .order-summary {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
            margin-top: 30px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .summary-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
            font-weight: 700;
            font-size: 1.1rem;
            color: #3ab8ff;
        }

        .summary-label {
            color: #666;
        }

        .summary-value {
            font-weight: 600;
            color: #333;
        }

        .btn-submit {
            background: linear-gradient(135deg, #3ab8ff, #377D98);
            border: none;
            color: white;
            padding: 15px 40px;
            border-radius: 25px;
            font-size: 1.1rem;
            font-weight: 600;
            width: 100%;
            margin-top: 30px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(58, 184, 255, 0.3);
        }

        .btn-submit:disabled {
            opacity: 0.6;
            transform: none;
            box-shadow: none;
            cursor: not-allowed;
        }

        .security-note {
            background: #e8f5e8;
            border: 1px solid #c3e6cb;
            border-radius: 10px;
            padding: 15px;
            margin-top: 20px;
            text-align: center;
        }

        .security-note i {
            color: #28a745;
            margin-right: 8px;
        }

        /* Responsive Design */
        @media (max-width: 767.98px) {
            .page-header {
                padding: 40px 0;
                margin-bottom: 20px;
            }

            .payment-body {
                padding: 30px 20px;
            }

            .service-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .payment-methods {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .payment-method {
                padding: 15px;
            }

            .payment-icon {
                font-size: 1.5rem;
            }

            .order-summary {
                padding: 20px;
            }

            .btn-submit {
                padding: 12px 30px;
            }
        }

        @media (max-width: 575.98px) {
            .payment-container {
                margin: 0 -15px;
                border-radius: 0;
            }

            .payment-header {
                padding: 25px 20px;
            }

            .payment-body {
                padding: 25px 15px;
            }

            .service-option {
                padding: 15px;
            }

            .section-title {
                font-size: 1.1rem;
            }
        }
    </style>
@endpush
