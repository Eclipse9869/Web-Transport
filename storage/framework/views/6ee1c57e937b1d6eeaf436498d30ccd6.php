<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transport</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css"/>
    <link rel="shortcut icon" href="assets/images/favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo e(asset('css/cust.css')); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/6.5.95/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"></head>
</head>

<body>
    <nav class="bg-gray-600 bg-opacity-50 top-0 left-0 w-full z-50"> <!-- absolute -->
        <div class="container flex">
            <div class="flex items-center justify-between flex-grow py-2">
                <div class="flex items-center space-x-6 capitalize">
                    <a href="/" class="text-gray-200 hover:text-red font-[Lora] hover:no-underline font-bold text-[20px] <?php echo e(request()->is('/') ? 'text-red-500' : ''); ?>">Home</a>
                    <a href="/shop" class="text-gray-200 hover:text-red transition font-[Lora] hover:no-underline font-bold text-[20px] <?php echo e(request()->is('shop') ? 'text-red-500' : ''); ?>">Bali Tour Package</a>
                    <a href="/" class="text-gray-200 hover:text-red transition font-[Lora] hover:no-underline font-bold text-[20px] <?php echo e(request()->is('car') ? 'text-red-500' : ''); ?>">Car</a>
                    <!-- <a href="/riwayat-order" class="text-gray-200 hover:text-red transition font-[Lora]">Riwayat Order</a> -->
                    <a href="/" class="text-gray-200 hover:text-red transition font-[Lora] hover:no-underline font-bold text-[20px] <?php echo e(request()->is('contact') ? 'text-red-500' : ''); ?>">Contact Us</a>
                    <a href="/" class="text-gray-200 hover:text-red transition font-[Lora] hover:no-underline font-bold text-[20px] <?php echo e(request()->is('about') ? 'text-red-500' : ''); ?>">About Us</a>
                </div>

                <?php if(Auth::check()): ?>
                    <div x-data="{ isOpen: false }" class="relative w-1/2 flex justify-end">
                        <div class="block px-4 py-4 text-gray-200">
                            <strong class="font-[Lora] font-bold text-[20px]">Welcome, <?php echo e(Auth::user()->name); ?> (<?php echo e(Auth::user()->role); ?>)</strong>
                        </div>
                        <button @click="isOpen = !isOpen" class="relative z-10 w-12 h-12 rounded-full overflow-hidden border-4 border-gray-400 hover:border-gray-300 focus:border-gray-300 focus:outline-none mt-3">
                            <img src="<?php echo e(asset('images/user/1.jpg')); ?>">
                        </button>
                        <button x-show="isOpen" @click="isOpen = false" class="h-full w-full fixed inset-0 cursor-default"></button>
                        <div x-show="isOpen" class="absolute w-34 bg-white rounded-lg shadow-lg py-2 mt-16">
                            <?php if(Auth::user()->role != 'Customer'): ?>
                                <a href="/data-package" class="block px-4 py-2 text-blue-600 font-[Lora]">Lihat Toko</a>
                            <?php endif; ?>
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button class="block px-4 py-2 account-link font-[Lora]">
                                    <?php echo e(__('Sign Out')); ?>

                                </button>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="flex items-center space-x-6 justify-between py-4">
                        <a href="/login" class="text-gray-200 hover:text-white transition font-[Lora] hover:no-underline font-bold text-[20px]">Login</a>
                        <a href="/register" class="text-gray-200 hover:text-white transition font-[Lora] hover:no-underline font-bold text-[20px]">Register</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <?php if(Auth::check() && Auth::user()->role === 'Customer'): ?>
        <button onclick="window.open('https://wa.me/6281339861202', '_blank')" class="fixed right-6 bottom-6 bg-blue-600 text-white px-4 py-3 rounded-full shadow-lg hover:bg-blue-700 transition duration-300 flex items-center space-x-2">
            <i class="mdi mdi-headset text-lg"></i>
            <span class="text-sm">Customer Service</span>
        </button>
    <?php endif; ?>

    <div class="container py-4 flex items-center gap-3">
        <a href="../index.html" class="text-primary text-base">
            <i class="fa-solid fa-house"></i>
        </a>
        <span class="text-sm text-gray-400">
            <i class="fa-solid fa-chevron-right">Order Process</i>
        </span>
    </div>
    <?php if($cart == null): ?>
        <div class="wrap-iten-in-cart">
            <div class="container-fluid ">
                <div class="row">
                    <div class="card-body cart">
                        <div class="col-sm-12 empty-cart-cls text-center">
                            <h4><strong>Keranjang Kosong</strong></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        
        <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="container grid grid-cols-2 gap-6 mb-5">
                <div class="col-span-12 space-y-4">
                    <div class="flex items-center justify-between border gap-6 p-4 border-gray-200 rounded">
                        <div class="w-1/3">
                            <h2 class="text-gray-800 text-xl font-medium uppercase"><?php echo e($c['name']); ?></h2>
                            <p class="text-gray-500 text-sm">Rp <?= number_format($c['price'], 0, ',' , '.') ?></p>
                            <div class="text-primary text-lg font-semibold"></div>
                        </div>
                        <div class="flex items-center">
                            <!-- Tombol Minus -->
                            <?php if($c['qty'] > 1): ?>
                                <button onclick="updateQuantity(<?php echo e($c['id']); ?>, <?php echo e($c['qty'] - 1); ?>)" class="px-2 py-1 bg-gray-200">-</button>
                            <?php else: ?>
                                <!-- Placeholder untuk menjaga tata letak tetap konsisten -->
                                <div class="px-2 py-1 bg-gray-200 opacity-50 cursor-not-allowed">-</div>
                            <?php endif; ?>

                            <!-- Menampilkan Kuantitas -->
                            <span class="px-4"><?php echo e($c['qty']); ?></span>

                            <!-- Tombol Plus -->
                            <button onclick="updateQuantity(<?php echo e($c['id']); ?>, <?php echo e($c['qty'] + 1); ?>)" class="px-2 py-1 bg-gray-200">+</button>
                            
                            <div class="container">  
                                <input class="date form-control" type="text" name="date" value="<?php echo e($c['date'] ?? ''); ?>" onchange="updateDate(<?php echo e($c['id']); ?>, this.value)"> 
                            </div>
                        </div>

                        <form action="<?php echo e(route('cart.remove', ['id' => $c['id']])); ?>" method="GET">
                            <button type="submit"
                                class="deleteCart flex items-center px-2 py-1 pl-0 space-x-1 text-red-600">
                                Remove
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <form method="POST" action="<?php echo e(route('checkout.index')); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="container mt-2 gap-6 ">
                <button type="submit"
                    class="px-6 py-2  text-sm text-white bg-primary border border-primary  rounded hover:bg-transparent hover:text-primary transition uppercase font-roboto font-medium">Checkout</button>
            </div>
        </form>
    <?php endif; ?>

    <!-- footer -->
    <footer class="bg-white pt-16 pb-12 border-t border-gray-100">
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        $('.date').datepicker({    
            format: 'dd MM yyyy',
            autoclose: true,
            todayHighlight: true,
        });

        // old
        // function updateQuantity(id, quantity) {
        //     fetch('/cart/update', {
        //         method: 'POST',
        //         headers: {
        //             'Content-Type': 'application/json',
        //             'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        //         },
        //         body: JSON.stringify({
        //             id: id,
        //             quantity: quantity
        //         })
        //     })
        //     .then(response => response.json())
        //     .then(data => {
        //         if (data.success) {
        //             location.reload();
        //         } else {
        //             alert('Gagal memperbarui kuantitas.');
        //         }
        //     });
        // }

        function updateQuantity(id, quantity) {
            fetch('/cart/update-quantity', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                body: JSON.stringify({
                    id: id,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Gagal memperbarui kuantitas.');
                }
            });
        }

        function updateDate(id, date) {
            fetch('/cart/update-date', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                body: JSON.stringify({
                    id: id,
                    date: date
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Tanggal berhasil diperbarui.');
                } else {
                    alert('Gagal memperbarui tanggal.');
                }
            });
        }
    </script>    
</body>
</html>
<?php /**PATH B:\Project\Transport\transport\resources\views/customer/cart.blade.php ENDPATH**/ ?>