<style>
    * {
        font-family: 'Poppins', sans-serif;
    }

    body {
        background: #f8f9fa;
    }

    .navbar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
    }

    .sidebar {
        background: white;
        min-height: calc(100vh - 76px);
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    }

    .sidebar .nav-link {
        color: #333;
        padding: 12px 20px;
        border-radius: 8px;
        margin: 5px 15px;
        transition: all 0.3s;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        transform: translateX(5px);
    }

    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s, box-shadow 0.3s;
        border: none;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
    }

    .bg-primary-gradient {
        background: linear-gradient(135deg, #667eea, #764ba2);
    }

    .bg-success-gradient {
        background: linear-gradient(135deg, #56ab2f, #a8e6cf);
    }

    .bg-warning-gradient {
        background: linear-gradient(135deg, #f093fb, #f5576c);
    }

    .bg-info-gradient {
        background: linear-gradient(135deg, #4facfe, #00f2fe);
    }

    .content-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        border: none;
    }

    .order-card {
        border-left: 4px solid #667eea;
        transition: transform 0.3s;
    }

    .order-card:hover {
        transform: translateX(5px);
    }

    .notification-item {
        border-left: 4px solid #28a745;
        background: #f8f9fa;
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 10px;
        transition: all 0.3s;
    }

    .notification-item:hover {
        background: #e9ecef;
        transform: translateX(5px);
    }

    .service-card {
        border-radius: 15px;
        transition: transform 0.3s;
    }

    .service-card:hover {
        transform: translateY(-5px);
    }

    .provider-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        border-radius: 25px;
        padding: 8px 20px;
        transition: transform 0.3s;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
    }

    .badge {
        border-radius: 20px;
        padding: 5px 12px;
    }

    @media (max-width: 768px) {
        .sidebar {
            min-height: auto;
        }
    }
</style>
