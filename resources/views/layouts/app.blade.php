<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Health Tracker')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        body {
            background: linear-gradient(135deg, #e3edf7 0%, #f5f7fa 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            background: rgba(255, 255, 255, 0.98) !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border-bottom: 1px solid #e8ecef;
        }
        
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            transition: transform 0.3s ease;
            background: white;
        }
        
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        }
        
        .card-header {
            background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);
            color: white;
            border-radius: 12px 12px 0 0 !important;
            font-weight: 600;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);
            border: none;
            border-radius: 8px;
            padding: 8px 24px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(74, 144, 226, 0.3);
            background: linear-gradient(135deg, #357abd 0%, #4a90e2 100%);
        }
        
        .btn-outline-primary {
            border-color: #4a90e2;
            color: #4a90e2;
            border-radius: 8px;
            padding: 8px 24px;
            font-weight: 500;
        }
        
        .btn-outline-primary:hover {
            background: #4a90e2;
            color: white;
            border-color: #4a90e2;
        }
        
        .btn-danger {
            border-radius: 8px;
            padding: 5px 15px;
            background: #dc3545;
            border-color: #dc3545;
        }
        
        .btn-danger:hover {
            background: #c82333;
            border-color: #bd2130;
        }
        
        .btn-outline-danger {
            border-radius: 8px;
            color: #dc3545;
            border-color: #dc3545;
        }
        
        .btn-outline-danger:hover {
            background: #dc3545;
            color: white;
        }
        
        .form-control {
            border-radius: 8px;
            border: 1px solid #dde1e6;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #6c7a89;
            box-shadow: 0 0 0 0.2rem rgba(108, 122, 137, 0.15);
        }
        
        .list-group-item {
            border-radius: 8px !important;
            margin-bottom: 12px;
            border: none;
            background: #f8f9fa;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            padding: 14px 16px;
            transition: all 0.2s ease;
        }
        
        .list-group-item:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.12);
            transform: translateX(2px);
        }
        
        .badge {
            padding: 6px 12px;
            border-radius: 6px;
            background: #4a90e2;
        }
        
        .bg-primary {
            background: #4a90e2 !important;
        }
        
        .text-primary {
            color: #4a90e2 !important;
        }
        
        .alert {
            border-radius: 8px;
            border: none;
        }
        
        .container-custom {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
    </style>
    
    @yield('styles')
</head>
<body>
    @if(session('username'))
    <nav class="navbar navbar-expand-lg navbar-light mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}" style="color: #4a90e2;">
                <span>🏥</span> Health Tracker
            </a>
            <div class="d-flex align-items-center">
                <span class="me-3" style="color: #357abd;">Welcome, <strong>{{ ucfirst(session('username')) }}</strong></span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>
    @endif

    <div class="container-custom">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @yield('scripts')
</body>
</html>
