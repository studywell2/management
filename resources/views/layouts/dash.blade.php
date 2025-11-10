<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - StudyWell</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            overflow-x: hidden;
            background-color: #f8f9fa;
        }

        #wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        #sidebar-wrapper {
            min-width: 250px;
            background-color: #212529;
        }

        .sidebar-heading {
            color: #fff;
        }

        .list-group-item {
            border: none;
            transition: all 0.2s ease-in-out;
        }

        .list-group-item:hover {
            background-color: #0d6efd !important;
            color: #fff !important;
        }

        #page-content-wrapper {
            flex: 1;
            padding: 20px;
        }

        footer {
            background: #fff;
            padding: 10px 20px;
            text-align: center;
            font-size: 0.9rem;
            border-top: 1px solid #eaeaea;
        }

        /* Mobile Sidebar */
        @media (max-width: 768px) {
            #sidebar-wrapper {
                position: fixed;
                top: 0;
                left: -250px;
                height: 100%;
                transition: all 0.3s ease;
                z-index: 1000;
            }
            #sidebar-wrapper.active {
                left: 0;
            }
            #sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
            }
            #sidebar-overlay.active {
                display: block;
            }
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <div class="border-end bg-dark text-white" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-3 fs-4 fw-bold">StudyWell</div>
            <div class="list-group list-group-flush">
                <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action bg-dark text-white">
                    🏠 Dashboard
                </a>
                <a href="{{ route('school.create') }}" class="list-group-item list-group-item-action bg-dark text-white">
                    🏫 School
                </a>
                <a href="{{ route('students.index') }}" class="list-group-item list-group-item-action bg-dark text-white">
                    👩‍🎓 Students
                </a>
                <a href="{{ route('results.index') }}" class="list-group-item list-group-item-action bg-dark text-white">
                    📘 Results
                </a>

                <form action="{{ route('logout') }}" method="POST" class="list-group-item bg-dark text-white border-0 p-0">
                    @csrf
                    <button type="submit" class="w-100 text-start bg-dark text-white border-0 py-2 px-3 list-group-item-action">
                        🚪 Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Overlay for mobile -->
        <div id="sidebar-overlay"></div>

        <!-- Page Content -->
        <div id="page-content-wrapper" class="w-100">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm mb-4">
                <div class="container-fluid">
                    <button class="btn btn-outline-dark d-lg-none" id="menu-toggle">☰</button>
                    <span class="navbar-brand fw-bold">@yield('title', 'Dashboard')</span>
                </div>
            </nav>

            {{-- Main Page Content --}}
            @yield('content')
        </div>

        <!-- Footer -->
        <footer>
            &copy; {{ date('Y') }} StudyWell. All rights reserved.
        </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle for mobile
        const sidebar = document.getElementById('sidebar-wrapper');
        const overlay = document.getElementById('sidebar-overlay');
        const toggleButton = document.getElementById('menu-toggle');

        toggleButton.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });
    </script>
</body>
</html>
