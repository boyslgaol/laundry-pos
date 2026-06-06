<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laundry POS - @yield('title')</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Chart JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        /* Custom styles */
        .btn-primary {
            background-color: #2563eb;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.2s;
        }
        
        .btn-primary:hover {
            background-color: #1d4ed8;
        }
        
        .btn-secondary {
            background-color: #e5e7eb;
            color: #374151;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.2s;
        }
        
        .btn-secondary:hover {
            background-color: #d1d5db;
        }
        
        input:focus, select:focus, textarea:focus {
            outline: none;
            ring: 2px solid #2563eb;
            border-color: #2563eb;
        }
        
        /* Dark mode styles */
        .dark {
            background-color: #1a202c;
            color: #e2e8f0;
        }
        
        .dark .bg-white {
            background-color: #2d3748;
        }
        
        .dark .bg-gray-50 {
            background-color: #1a202c;
        }
        
        .dark .border-gray-200 {
            border-color: #4a5568;
        }
        
        .dark .text-gray-800 {
            color: #e2e8f0;
        }
        
        .dark .text-gray-600 {
            color: #a0aec0;
        }
        
        .dark .bg-blue-50 {
            background-color: #2c5282;
        }
        
        /* Smooth transitions */
        * {
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        
        /* Card hover effect */
        .stat-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800 dark:bg-gray-900 dark:text-gray-200">
    <!-- Dark Mode Toggle Button -->
    <button onclick="toggleDarkMode()" class="fixed bottom-4 right-4 bg-gray-200 dark:bg-gray-700 p-3 rounded-full shadow-lg z-50 hover:scale-110 transition-transform">
        <i class="fas fa-moon dark:hidden text-gray-700"></i>
        <i class="fas fa-sun hidden dark:inline text-yellow-400"></i>
    </button>
    
    <!-- Navbar -->
    <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm sticky top-0 z-50 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <i class="fas fa-tshirt text-blue-600 dark:text-blue-400 text-2xl"></i>
                    <div class="font-bold text-xl text-gray-800 dark:text-white">
                        Laundry<span class="text-blue-600 dark:text-blue-400">POS</span>
                    </div>
                </div>
                
                <!-- Desktop Menu - DASHBOARD sudah ditambahkan di paling depan -->
                <div class="hidden md:flex space-x-1">
                    <a href="{{ route('dashboard') }}" 
                       class="px-4 py-2 rounded-lg text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900 transition 
                              @if(request()->routeIs('dashboard')) bg-blue-50 dark:bg-blue-900 text-blue-600 dark:text-blue-400 font-semibold @endif">
                        <i class="fas fa-chart-pie mr-2"></i>Dashboard
                    </a>
                    <a href="{{ route('transaksi.index') }}" 
                       class="px-4 py-2 rounded-lg text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900 transition 
                              @if(request()->routeIs('transaksi.*')) bg-blue-50 dark:bg-blue-900 text-blue-600 dark:text-blue-400 @endif">
                        <i class="fas fa-shopping-cart mr-2"></i>Transaksi
                    </a>
                    <a href="{{ route('pelanggan.index') }}" 
                       class="px-4 py-2 rounded-lg text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900 transition 
                              @if(request()->routeIs('pelanggan.*')) bg-blue-50 dark:bg-blue-900 text-blue-600 dark:text-blue-400 @endif">
                        <i class="fas fa-users mr-2"></i>Pelanggan
                    </a>
                    <a href="{{ route('layanan.index') }}" 
                       class="px-4 py-2 rounded-lg text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900 transition 
                              @if(request()->routeIs('layanan.*')) bg-blue-50 dark:bg-blue-900 text-blue-600 dark:text-blue-400 @endif">
                        <i class="fas fa-tags mr-2"></i>Layanan
                    </a>
                    <a href="{{ route('laporan.index') }}" 
                       class="px-4 py-2 rounded-lg text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900 transition 
                              @if(request()->routeIs('laporan.*')) bg-blue-50 dark:bg-blue-900 text-blue-600 dark:text-blue-400 @endif">
                        <i class="fas fa-chart-line mr-2"></i>Laporan
                    </a>
                </div>
                
                <!-- User Menu & Mobile Menu Button -->
                <div class="flex items-center space-x-3">
                    @auth
                    <div class="hidden md:flex items-center space-x-3">
                        <span class="text-sm text-gray-600 dark:text-gray-300">
                            <i class="fas fa-user-circle mr-1"></i>
                            {{ auth()->user()->name }}
                        </span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 text-sm">
                                <i class="fas fa-sign-out-alt mr-1"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                    @endauth
                    
                    <!-- Mobile Menu Button -->
                    <button onclick="toggleMobileMenu()" class="md:hidden text-gray-600 dark:text-gray-300 hover:text-blue-600">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu - Dashboard juga ditambahkan di sini -->
        <div id="mobileMenu" class="hidden md:hidden bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 py-2">
            <div class="flex flex-col space-y-1 px-4">
                <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-lg text-gray-600 dark:text-gray-300 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900 transition">
                    <i class="fas fa-chart-pie mr-2"></i>Dashboard
                </a>
                <a href="{{ route('transaksi.index') }}" class="px-4 py-2 rounded-lg text-gray-600 dark:text-gray-300 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900 transition">
                    <i class="fas fa-shopping-cart mr-2"></i>Transaksi
                </a>
                <a href="{{ route('pelanggan.index') }}" class="px-4 py-2 rounded-lg text-gray-600 dark:text-gray-300 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900 transition">
                    <i class="fas fa-users mr-2"></i>Pelanggan
                </a>
                <a href="{{ route('layanan.index') }}" class="px-4 py-2 rounded-lg text-gray-600 dark:text-gray-300 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900 transition">
                    <i class="fas fa-tags mr-2"></i>Layanan
                </a>
                <a href="{{ route('laporan.index') }}" class="px-4 py-2 rounded-lg text-gray-600 dark:text-gray-300 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900 transition">
                    <i class="fas fa-chart-line mr-2"></i>Laporan
                </a>
                @auth
                <div class="border-t border-gray-200 dark:border-gray-700 my-2 pt-2">
                    <div class="px-4 py-2 text-sm text-gray-600 dark:text-gray-300">
                        <i class="fas fa-user-circle mr-2"></i>
                        {{ auth()->user()->name }}
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 rounded-lg text-red-600 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-900 transition">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            Logout
                        </button>
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        @if(session('success'))
            <div class="mb-4 bg-green-50 dark:bg-green-900 border-l-4 border-green-500 text-green-700 dark:text-green-300 p-4 rounded shadow-sm flex items-center justify-between transition">
                <div>
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-700 dark:text-green-300 hover:text-green-900">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="mb-4 bg-red-50 dark:bg-red-900 border-l-4 border-red-500 text-red-700 dark:text-red-300 p-4 rounded shadow-sm flex items-center justify-between transition">
                <div>
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                </div>
                <button onclick="this.parentElement.remove()" class="text-red-700 dark:text-red-300 hover:text-red-900">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif
        
        @if($errors->any())
            <div class="mb-4 bg-red-50 dark:bg-red-900 border-l-4 border-red-500 text-red-700 dark:text-red-300 p-4 rounded shadow-sm transition">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="border-t border-gray-200 dark:border-gray-700 py-4 text-center text-gray-400 dark:text-gray-500 text-sm mt-8 transition-colors">
        <i class="fas fa-code mr-1"></i> Laundry POS System &copy; {{ date('Y') }}
    </footer>
    
    <!-- Toast Notification Container -->
    <div id="toast-container" class="fixed top-20 right-4 z-50 space-y-2"></div>
    
    <script>
        // Dark Mode Toggle
        function toggleDarkMode() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('darkMode', 'false');
                showToast('Light mode activated', 'info');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('darkMode', 'true');
                showToast('Dark mode activated', 'info');
            }
        }
        
        // Load dark mode preference
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark');
        }
        
        // Mobile Menu Toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
            } else {
                menu.classList.add('hidden');
            }
        }
        
        // Toast Notification System
        function showToast(message, type = 'success') {
            const toastContainer = document.getElementById('toast-container');
            const toast = document.createElement('div');
            
            const colors = {
                success: 'bg-green-500',
                error: 'bg-red-500',
                warning: 'bg-yellow-500',
                info: 'bg-blue-500'
            };
            
            const icons = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle',
                warning: 'fa-exclamation-triangle',
                info: 'fa-info-circle'
            };
            
            toast.className = `${colors[type]} text-white px-6 py-3 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full opacity-0 flex items-center gap-3`;
            toast.innerHTML = `
                <i class="fas ${icons[type]}"></i>
                <span>${message}</span>
            `;
            
            toastContainer.appendChild(toast);
            
            // Animate in
            setTimeout(() => {
                toast.classList.remove('translate-x-full', 'opacity-0');
                toast.classList.add('translate-x-0', 'opacity-100');
            }, 100);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                toast.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }
        
        // Confirmation Dialog
        window.confirmDelete = function(formId, itemName = 'Data') {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                html: `Data <strong>${itemName}</strong> akan dihapus permanen!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        };
        
        // Auto hide alerts after 5 seconds
        setTimeout(() => {
            document.querySelectorAll('.bg-green-50, .bg-red-50, .bg-blue-50').forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 300);
                }, 5000);
            });
        }, 100);
        
        // Format Rupiah
        window.formatRupiah = function(number) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
        };
    </script>
    
    @stack('scripts')
</body>
</html>