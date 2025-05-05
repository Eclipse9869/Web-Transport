<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transport</title>
    <link rel="shortcut icon" href="assets/images/favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo e(asset('css/cust.css')); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/6.5.95/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo e(config('midtrans.client_key')); ?>"></script>
    <style>
        body {
            /* background: url('https://source.unsplash.com/1600x900/?travel,nature') no-repeat center center fixed; */
            background-size: cover;
            position: relative;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4); /* Efek blur transparan */
            backdrop-filter: blur(10px);
            z-index: -1;
        }

        nav {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 50;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            background: transparent;
            transition: background 0.3s;
        }

        .scrolled {
            /* background: rgba(31, 41, 55, 0.9); */
            background: rgba(255, 255, 255, 0.7); /* Kuning pucet dengan transparansi */
            backdrop-filter: blur(5px);
        }

        nav a {
            color: white;
            font-weight: 600;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #FACC15;
        }
    </style>
</head>

<body>
    <nav id="navbar" class="px-[10%]">
        <a href="/" class="text-black text-3xl font-bold">Transport</a>
        <div class="hidden md:flex space-x-6">
            <!-- <a href="/" class="text-black hover:text-yellow-400 font-semibold text-xl">Home</a> -->
            <a href="/shop" class="text-black hover:text-yellow-400 font-semibold text-xl">Bali Tour Package</a>
            <a href="/" class="text-black hover:text-yellow-400 font-semibold text-xl">Car</a>
            <a href="/shop" class="text-black hover:text-yellow-400 font-semibold text-xl">Contact Us</a>
            <a href="/" class="text-black hover:text-yellow-400 font-semibold text-xl">About Us</a>
        </div>
        <?php if(Auth::check()): ?>
            <div x-data="{ isOpen: false }" class="relative w-1/2 flex justify-end">
                <div class="block px-4 py-4 text-black">
                <?php if(Auth::user()->role == 'Customer'): ?>
                    <strong class="font-semibold">Welcome, <?php echo e(Auth::user()->name); ?></strong>
                <?php else: ?>
                    <strong class="font-semibold">Welcome, <?php echo e(Auth::user()->name); ?> (<?php echo e(Auth::user()->role); ?>)</strong>
                <?php endif; ?>
                </div>
                <button @click="isOpen = !isOpen" class="relative z-10 w-12 h-12 rounded-full overflow-hidden focus:outline-none mt-1">
                    <i class="fas fa-chevron-down hover:text-yellow-400 font-semibold"></i>
                </button>
                <button x-show="isOpen" @click="isOpen = false" class="h-full w-full fixed inset-0 cursor-default"></button>
                <div x-show="isOpen" x-cloak class="absolute w-30 bg-white rounded-lg shadow-lg mt-16">
                    <?php if(Auth::user()->role != 'Customer'): ?>
                        <a href="/data-package" class="block px-4 py-2 text-blue-600 hover:text-yellow-400 transition font-semibold hover:no-underline">Lihat Toko</a>
                    <?php endif; ?>
                    <a href="/riwayat-order" class="block px-4 py-2 text-blue-600 hover:text-yellow-400 transition font-semibold hover:no-underline">My History</a>
                    <form method="POST" action="<?php echo e(route('logout')); ?>" style="margin: 0;">
                        <?php echo csrf_field(); ?>
                        <button class="block px-4 py-2 account-link hover:text-yellow-400 transition font-semibold hover:no-underline">
                            <?php echo e(__('Sign Out')); ?>

                        </button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <div class="flex space-x-4">
                <a href="/login" class="border border-black text-black hover:bg-black hover:text-white font-semibold px-4 py-2 rounded-md transition duration-300">
                    Login
                </a>
                <a href="/register" class="border border-yellow-400 text-yellow-400 hover:bg-yellow-400 hover:text-white font-semibold px-4 py-2 rounded-md transition duration-300">
                    Register
                </a>
            </div>
        <?php endif; ?>
    </nav>
    
    <?php echo $__env->yieldContent('content'); ?>

    <footer class="pt-16 pb-12 border-t border-gray-100 bg-gray-800">
        <div class="container mx-auto text-center">
            <p class="text-gray-400">&copy; 2025 Transport. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        window.addEventListener("scroll", function() {
            var navbar = document.getElementById("navbar");
            if (window.scrollY > 50) {
                navbar.classList.add("scrolled");
            } else {
                navbar.classList.remove("scrolled");
            }
        });
    </script>
</body>
</html><?php /**PATH B:\Project\Transport\transport\resources\views/layouts/customer.blade.php ENDPATH**/ ?>