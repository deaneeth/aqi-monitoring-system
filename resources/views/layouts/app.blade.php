<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>AQI Monitoring Dashboard</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">



    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        .nav-glass {
            background: none;
        }

        .nav-link {
            @apply text-sm font-medium text-white px-3 py-2 rounded transition hover:bg-blue-600 hover:shadow;
        }

        .nav-btn {
            @apply px-4 py-1.5 text-sm font-semibold rounded-lg bg-gradient-to-r from-pink-500 to-yellow-500 text-white hover:opacity-90 transition;
        }

        .logo-text {
            font-size: 20px;
            font-weight: bold;
            color: #00eaff;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .logo-text i {
            color: #00ffc3;
        }

        .glow-tab {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 22px;
        font-weight: 600;
        font-size: 14px;
        color: #fff;
        background: linear-gradient(135deg, #00d0ff, #0066ff);
        border-radius: 30px;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 153, 255, 0.4);
    }

    .glow-tab:hover {
        background: linear-gradient(135deg, #00aaff, #0044cc);
        box-shadow: 0 0 12px #00c3ff, 0 0 20px #007fff;
        transform: translateY(-1px);
    }

    .glow-tab i {
        font-size: 16px;
    }
    </style>
</head>
<body class="bg-gray-900 text-white font-inter">
    <div class="min-h-screen">

        <!-- 🚀 Next-level Navbar -->
        <nav class="nav-bar py-4 px-6">

    <div class="max-w-7xl mx-auto flex justify-between items-center">

        <!-- Logo -->
        <div class="text-white font-bold text-xl flex items-center gap-2">
            <i class="fas fa-globe-asia text-purple-400"></i> AQI Dashboard
        </div>

        <!-- Navigation -->
        <div class="flex items-center gap-8 text-sm font-medium text-gray-300">

            <a href="{{ route('home') }}" class="glow-tab">
                <i class="fas fa-map-marker-alt mr-1"></i> Public Map
            </a>

            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="glow-tab">
                        <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                    </a>
                    <a href="{{ route('sensors.index') }}" class="glow-tab">
                        <i class="fas fa-satellite-dish mr-1"></i> Sensors
                    </a>
                    <a href="{{ route('simulation.settings') }}" class="glow-tab">
                        <i class="fas fa-flask mr-1"></i> Simulation
                    </a>
                    <a href="{{ route('admin.alerts.index') }}" class="glow-tab">
                        <i class="fas fa-exclamation-triangle mr-1"></i> Alerts
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="glow-tab">
                        <i class="fas fa-users-cog mr-1"></i> Users
                    </a>
                @elseif(auth()->user()->role === 'sysadmin')
                    <a href="{{ route('sysadmin.dashboard') }}" cclass="glow-tab"
                        <i class="fas fa-cogs mr-1"></i> SysAdmin
                    </a>
                @endif

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="nav-link hover:text-red-400">
                        <i class="fas fa-sign-out-alt mr-1"></i> Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="glow-tab">
                    <i class="fas fa-sign-in-alt mr-1"></i> Admin Login
                </a>
            @endauth
        </div>
    </div>
</nav>


        <!-- Push down to not overlap fixed nav -->
        <div class="pt-4">
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main>
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
