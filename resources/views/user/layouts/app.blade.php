<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - SINEMANIS</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary: #2E3192;
            --secondary: #1BAEEC;
            --accent: #33a4f4;
            --light: #F8F9FA;
            --dark: #343A40;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fc;
        }
        
        .sidebar {
            background: linear-gradient(180deg, var(--primary), #1a1c5b);
            min-height: 100vh;
            color: white;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            transition: all 0.3s;
            z-index: 100;
        }
        
        .content-wrapper {
            margin-left: 250px;
            transition: all 0.3s;
            min-height: 100vh;
        }
        
        .sidebar-collapsed .sidebar {
            width: 70px;
        }
        
        .sidebar-collapsed .content-wrapper {
            margin-left: 70px;
        }
        
        .sidebar-header {
            padding: 20px 15px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-brand img {
            height: 40px;
        }
        
        .sidebar-menu {
            padding: 0;
            list-style: none;
            margin-top: 20px;
        }
        
        .sidebar-menu li a {
            display: block;
            padding: 12px 20px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
            font-size: 15px;
        }
        
        .sidebar-menu li a:hover,
        .sidebar-menu li a.active {
            background-color: rgba(255,255,255,0.1);
            color: white;
            border-left: 4px solid var(--accent);
        }
        
        .sidebar-menu li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .topbar {
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 99;
            width: 100%;
        }
        .content-wrapper {
            margin-left: 250px;
            transition: all 0.3s;
            min-height: 100vh;
            width: calc(100% - 250px);
        }

        .sidebar-collapsed .content-wrapper {
            margin-left: 70px;
            width: calc(100% - 70px); 
        }

        .user-profile {
            display: flex;
            align-items: center;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-weight: bold;
        }
        
        .content {
            padding: 20px 30px;
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            font-weight: 600;
            padding: 15px 20px;
        }
        
        .btn-primary-custom {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
            border-radius: 5px;
            padding: 8px 15px;
            transition: all 0.3s;
        }
        
        .btn-primary-custom:hover {
            background: var(--secondary);
            border-color: var(--secondary);
        }
        
        .btn-accent-custom {
            background: var(--accent);
            border-color: var(--accent);
            color: white;
            border-radius: 5px;
            padding: 8px 15px;
            transition: all 0.3s;
        }
        
        .btn-accent-custom:hover {
            background: #e67012;
            border-color: #e67012;
        }
        
        .timeline {
            position: relative;
            padding-left: 30px;
        }
        
        .timeline-item {
            position: relative;
            padding-bottom: 20px;
        }
        
        .timeline-item:before {
            content: "";
            position: absolute;
            left: -30px;
            top: 0;
            width: 2px;
            height: 100%;
            background-color: var(--secondary);
        }
        
        .timeline-item:after {
            content: "";
            position: absolute;
            left: -36px;
            top: 0;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background-color: var(--primary);
            border: 2px solid white;
        }
        
        .timeline-item.active:after {
            background-color: var(--accent);
        }
        
        .timeline-item.completed:after {
            background-color: #28a745;
        }
        
        .timeline-item:last-child:before {
            height: 0;
        }
        
        .form-section {
            display: none;
        }
        
        .form-section.active {
            display: block;
        }
        
        .form-navigation {
            margin-top: 20px;
        }
        
        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        
        .step {
            flex: 1;
            text-align: center;
            padding: 10px;
            position: relative;
        }
        
        .step:not(:last-child):after {
            content: "";
            position: absolute;
            top: 20px;
            right: -50%;
            width: 100%;
            height: 2px;
            background-color: #dee2e6;
            z-index: 1;
        }
        
        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #dee2e6;
            color: var(--dark);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            position: relative;
            z-index: 2;
        }
        
        .step.active .step-number {
            background-color: var(--primary);
            color: white;
        }
        
        .step.completed .step-number {
            background-color: var(--secondary);
            color: white;
        }
        
        .step-title {
            font-size: 14px;
            color: var(--dark);
        }
        
        .step.active .step-title {
            color: var(--primary);
            font-weight: 600;
        }
        
        .form-label {
            font-weight: 500;
        }
        
        .required-field::after {
            content: " *";
            color: red;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(46, 49, 146, 0.25);
        }
        
        .accordion-button:not(.collapsed) {
            background-color: rgba(46, 49, 146, 0.1);
            color: var(--primary);
        }
        
        .accordion-button:focus {
            box-shadow: 0 0 0 0.25rem rgba(46, 49, 146, 0.25);
        }
        
        .alert-custom {
            border-left: 4px solid var(--primary);
        }
    </style>
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        @include('user.partials.sidebar')
        
        <!-- Page Content -->
        <div class="content-wrapper">
            <!-- Topbar -->
            @include('user.partials.topbar')
            
            <!-- Main Content -->
            <div class="content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Toggle Sidebar
        document.getElementById('sidebarToggle').addEventListener('click', function(e) {
            e.preventDefault();
            document.body.classList.toggle('sidebar-collapsed');
        });
    </script>
    
    @stack('scripts')
</body>
</html>