@push('styles')
    <style>
        /* Hero Section */
        .about-hero {
            background: linear-gradient(135deg, #3ab8ff 0%, #377D98 100%);
            color: white;
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }

        .about-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" opacity="0.1"><polygon points="0,100 1000,0 1000,100"/></svg>');
            background-size: cover;
        }

        .about-content {
            position: relative;
            z-index: 2;
        }

        /* Feature Sections */
        .feature-section {
            padding: 80px 0;
        }

        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            height: 100%;
            border: 1px solid #f0f0f0;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .feature-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #3ab8ff, #377D98);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            font-size: 2.5rem;
            color: white;
        }

        .feature-card h4 {
            color: #333;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .feature-card p {
            color: #666;
            line-height: 1.7;
        }

        /* FAQ Section */
        .faq-section {
            background: white;
            padding: 80px 0;
        }

        .faq-item {
            border: none;
            border-radius: 15px !important;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(58, 184, 255, 0.1);
            overflow: hidden;
            background: #f8f9fa;
        }

        .faq-item .accordion-button {
            background: #f8f9fa;
            border: none;
            padding: 25px 30px;
            font-weight: 600;
            color: #333;
            font-size: 1.1rem;
            border-radius: 15px;
            transition: all 0.3s ease;
        }

        .faq-item .accordion-button:not(.collapsed) {
            background: linear-gradient(135deg, #3ab8ff, #377D98);
            color: white;
            box-shadow: none;
        }

        .faq-item .accordion-button:focus {
            box-shadow: none;
            border: none;
        }

        .faq-item .accordion-button::after {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23333'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
            transition: transform 0.3s ease;
        }

        .faq-item .accordion-button:not(.collapsed)::after {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23fff'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
            transform: rotate(180deg);
        }

        .faq-item .accordion-body {
            padding: 25px 30px;
            background: #f8f9fa;
            color: #666;
            line-height: 1.7;
            border-top: 1px solid rgba(58, 184, 255, 0.2);
        }

        .faq-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(58, 184, 255, 0.15);
        }

        /* Team Section */
        .team-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #3ab8ff 0%, #377D98 100%);
        }

        .team-section h2 {
            color: white;
        }

        .team-section .text-muted {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        .team-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .team-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 35px rgba(0, 0, 0, 0.3);
        }

        .team-avatar {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #377D98, #3ab8ff);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 30px auto 20px;
            font-size: 3rem;
            color: white;
            box-shadow: 0 5px 15px rgba(55, 125, 152, 0.3);
        }

        .team-info {
            padding: 0 30px 30px;
        }

        .team-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .team-role {
            color: #377D98;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .team-desc {
            color: #666;
            font-size: 0.9rem;
            line-height: 1.6;
        }

        /* Mission Vision Section */
        .mission-vision {
            background: white;
            color: #333;
            padding: 80px 0;
        }

        .mission-card,
        .vision-card {
            background: #f8f9fa;
            border-radius: 20px;
            padding: 40px 30px;
            border: 1px solid rgba(58, 184, 255, 0.1);
            height: 100%;
            box-shadow: 0 5px 15px rgba(58, 184, 255, 0.1);
            transition: all 0.3s ease;
        }

        .mission-card:hover,
        .vision-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(58, 184, 255, 0.15);
            border-color: rgba(58, 184, 255, 0.2);
        }

        .mission-card h4,
        .vision-card h4 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            color: #3ab8ff;
        }

        .mission-card h4 i,
        .vision-card h4 i {
            margin-right: 15px;
            font-size: 2rem;
            color: #3ab8ff;
        }

        .mission-card p,
        .vision-card p {
            color: #666;
            line-height: 1.7;
        }

        /* Contact CTA */
        .contact-cta {
            background: #f8f9fa;
            padding: 80px 0;
            text-align: center;
        }

        .cta-content {
            max-width: 600px;
            margin: 0 auto;
        }

        .cta-content h3 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
        }

        .cta-content p {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.7;
        }

        .btn-cta {
            background: linear-gradient(135deg, #3ab8ff, #377D98);
            border: none;
            color: white;
            padding: 15px 40px;
            border-radius: 30px;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(58, 184, 255, 0.3);
            color: white;
        }

        /* Responsive Design */
        @media (max-width: 767.98px) {
            .about-hero {
                padding: 60px 0;
            }

            .about-hero h1 {
                font-size: 2rem;
            }

            .feature-section {
                padding: 60px 0;
            }

            .feature-card {
                padding: 30px 20px;
                margin-bottom: 30px;
            }

            .feature-icon {
                width: 80px;
                height: 80px;
                font-size: 2rem;
            }

            .faq-section {
                padding: 60px 0;
            }

            .faq-item .accordion-button {
                padding: 20px 25px;
                font-size: 1rem;
            }

            .faq-item .accordion-body {
                padding: 20px 25px;
            }

            .team-section {
                padding: 60px 0;
            }

            .team-avatar {
                width: 100px;
                height: 100px;
                font-size: 2.5rem;
            }

            .mission-vision {
                padding: 60px 0;
            }

            .contact-cta {
                padding: 60px 0;
            }

            .cta-content h3 {
                font-size: 2rem;
            }
        }

        @media (max-width: 575.98px) {
            .about-hero h1 {
                font-size: 1.75rem;
            }

            .feature-card {
                padding: 20px 15px;
            }

            .faq-item .accordion-button {
                padding: 15px 20px;
                font-size: 0.95rem;
            }

            .faq-item .accordion-body {
                padding: 15px 20px;
            }

            .mission-card,
            .vision-card {
                padding: 30px 20px;
                margin-bottom: 20px;
            }

            .cta-content h3 {
                font-size: 1.75rem;
            }

            .btn-cta {
                padding: 12px 30px;
                font-size: 1rem;
            }
        }
    </style>
@endpush
