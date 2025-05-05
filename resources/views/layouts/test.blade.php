<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transport</title>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css"/> -->
    <link rel="shortcut icon" href="assets/images/favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/cust.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/6.5.95/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{config('midtrans.client_key')}}"></script>
</head>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>

<body style="background-color: #fef2c7;">
    <nav x-data="{ isOpen: false }" class="bg-gradient-to-b from-orange-700 to-yellow-400 top-0 left-0 w-full z-50"> <!-- absolute -->
        <div class="container flex">
            <div class="flex items-center justify-between flex-grow py-2">
                <div class="flex items-center space-x-6 capitalize">
                    <button @click="isOpen = !isOpen" class="lg:hidden text-gray-200 text-2xl focus:outline-none">
                        <i class="fas fa-bars"></i>
                    </button>

                    <div class="hidden lg:flex space-x-6">
                        <a href="/" class="text-gray-200 hover:text-red font-[Lora] hover:no-underline font-bold text-[20px] {{ request()->is('/') ? 'text-red-800' : '' }}">Home</a>
                        <a href="/shop" class="text-gray-200 hover:text-red font-[Lora] hover:no-underline font-bold text-[20px] {{ request()->is('shop') ? 'text-red-800' : '' }}">Bali Tour Package</a>
                        <a href="/car" class="text-gray-200 hover:text-red font-[Lora] hover:no-underline font-bold text-[20px] {{ request()->is('car') ? 'text-red-800' : '' }}">Car</a>
                        <a href="/contact" class="text-gray-200 hover:text-red font-[Lora] hover:no-underline font-bold text-[20px] {{ request()->is('contact') ? 'text-red-800' : '' }}">Contact Us</a>
                        <a href="/about" class="text-gray-200 hover:text-red font-[Lora] hover:no-underline font-bold text-[20px] {{ request()->is('about') ? 'text-red-800' : '' }}">About Us</a>
                    </div>
                </div>

                @if (Auth::check())
                    <div x-data="{ isOpen: false }" class="relative w-1/2 flex justify-end">
                        <div class="block px-4 py-4 text-gray-200">
                            @if (Auth::user()->role == 'Customer')
                                <strong class="font-[Lora] font-bold text-[20px]">Welcome, {{ Auth::user()->name }}</strong>
                            @else
                                <strong class="font-[Lora] font-bold text-[20px]">Welcome, {{ Auth::user()->name }} ({{ Auth::user()->role }})</strong>
                            @endif
                        </div>
                        <button @click="isOpen = !isOpen" class="relative z-10 w-12 h-12 rounded-full overflow-hidden border-4 border-gray-400 hover:border-gray-300 focus:border-gray-300 focus:outline-none mt-3">
                            <img src="{{ asset('images/user/1.jpg') }}">
                        </button>
                        <button x-show="isOpen" @click="isOpen = false" class="h-full w-full fixed inset-0 cursor-default"></button>
                        <div x-show="isOpen" x-cloak class="absolute w-30 bg-white rounded-lg shadow-lg mt-16">
                            @if (Auth::user()->role != 'Customer')
                                <a href="/data-package" class="block px-4 py-2 text-blue-600 hover:text-red-500 transition font-[Lora] hover:no-underline">Lihat Toko</a>
                            @endif
                            <a href="/riwayat-order" class="block px-4 py-2 text-blue-600 hover:text-red-500 transition font-[Lora] hover:no-underline">My History</a>
                            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                @csrf
                                <button class="block px-4 py-2 account-link hover:text-red-500 transition font-[Lora] hover:no-underline">
                                    {{ __('Sign Out') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex items-center space-x-6 justify-between py-4">
                        <a href="/login" class="text-gray-200 hover:text-white transition font-[Lora] hover:no-underline font-bold text-[20px]">Login</a>
                        <a href="/register" class="text-gray-200 hover:text-white transition font-[Lora] hover:no-underline font-bold text-[20px]">Register</a>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- 🌟 Navbar Mobile (Muncul Saat di Klik) -->
        <div x-show="isOpen" x-cloak class="lg:hidden bg-gradient-to-b from-orange-700 to-yellow-400 mt-3 p-4 space-y-3">
            <a href="/" class="block text-gray-200 hover:text-blue-500 hover:no-underline font-bold text-[18px] border-b border-gray-500 pb-2 {{ request()->is('/') ? 'text-red-800' : '' }}">Home</a>
            <a href="/shop" class="block text-gray-200 hover:text-blue-500 hover:no-underline font-bold text-[18px] border-b border-gray-500 pb-2 {{ request()->is('shop') ? 'text-red-800' : '' }}">Bali Tour Package</a>
            <a href="/car" class="block text-gray-200 hover:text-blue-500 hover:no-underline font-bold text-[18px] border-b border-gray-500 pb-2 {{ request()->is('car') ? 'text-red-800' : '' }}">Car</a>
            <a href="/contact" class="block text-gray-200 hover:text-blue-500 hover:no-underline font-bold text-[18px] border-b border-gray-500 pb-2 {{ request()->is('contact') ? 'text-red-800' : '' }}">Contact Us</a>
            <a href="/about" class="block text-gray-200 hover:text-blue-500 hover:no-underline font-bold text-[18px] {{ request()->is('about') ? 'text-red-800' : '' }}">About Us</a>
        </div>
    </nav>

    @if (Auth::check() && Auth::user()->role === 'Customer')
        <button onclick="window.open('https://wa.me/6281339861202', '_blank')" class="fixed right-6 bottom-6 bg-blue-600 text-white px-4 py-3 rounded-full shadow-lg hover:bg-blue-700 transition duration-300 flex items-center space-x-2">
            <i class="mdi mdi-headset text-lg"></i>
            <span class="text-sm">Customer Service</span>
        </button>
    @endif

    @yield('content')

    <!-- footer -->
    <footer class="pt-16 pb-12 border-t border-gray-100" style="background-color: #fef2c7;">
        <div class="container grid grid-cols-1 ">
            <div class="col-span-1 space-y-4">
                <img src="assets/images/logo.svg" alt="logo" class="w-30">
                <div class="mr-2">
                    <p class="text-gray-500">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia, hic?
                    </p>
                </div>
                <div class="flex space-x-5">
                    <a href="#" class="text-gray-400 hover:text-gray-500"><i class="fa-brands fa-facebook-square"></i></a>
                    <a href="#" class="text-gray-400 hover:text-gray-500"><i class="fa-brands fa-instagram-square"></i></a>
                    <a href="#" class="text-gray-400 hover:text-gray-500"><i class="fa-brands fa-twitter-square"></i></a>
                    <a href="#" class="text-gray-400 hover:text-gray-500">
                        <i class="fa-brands fa-github-square"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Script -->
    @yield('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>    
</body>
</html>
