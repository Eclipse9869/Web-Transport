<?php $__env->startSection('content'); ?>
    <div class="container py-4 flex items-center gap-3">
        <a href="/" class="text-base">
            <i class="fa-solid fa-house text-transparent bg-gradient-to-b from-orange-700 to-yellow-400 bg-clip-text"></i>
        </a>
        <span class="text-sm text-gray-400">
            <i class="fa-solid fa-chevron-right"></i>
        </span>
        <a href="/shop" class="text-base font-[Lora] font-bold text-transparent bg-gradient-to-b from-orange-700 to-yellow-400 bg-clip-text">
            Bali Tour Package
        </a>
        <span class="text-sm text-gray-400">
            <i class="fa-solid fa-chevron-right"></i>
        </span>
        <a class="text-base font-[Lora] font-bold text-transparent bg-gradient-to-b from-orange-700 to-yellow-400 bg-clip-text">
            <?php echo e($package->name); ?>

        </a>
    </div>
    <form action="<?php echo e(route('cart.add', ['id' => $package->id])); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="container grid grid-cols-2 gap-6">
            <div x-data="{
                currentIndex: 0, 
                total: <?php echo e(count($package->packageImages)); ?>, 
                next() { this.currentIndex = (this.currentIndex + 1) % this.total; },
                prev() { this.currentIndex = (this.currentIndex === 0) ? this.total - 1 : this.currentIndex - 1; }
            }"
            x-init="setInterval(() => next(), 7000)" 
            class="relative w-full aspect-[4/3] overflow-hidden rounded-lg group">
                
                <div class="relative w-full h-full overflow-hidden">
                    <div class="flex w-full h-full transition-transform duration-500 ease-in-out"
                        :style="'transform: translateX(-' + (currentIndex * 100) + '%)'">
                        <?php $__currentLoopData = $package->packageImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <img src="<?php echo e(asset('img/package/' . $image->image)); ?>" 
                                alt="product image" 
                                class="w-full h-full object-cover flex-shrink-0">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                
                <!-- Tombol Navigasi -->
                <button @click.prevent="prev()" x-show="total > 1"
                        class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-white/70 text-gray-800 
                            hover:bg-white shadow-lg w-10 h-10 flex items-center justify-center rounded-full
                            opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <button @click.prevent="next()" x-show="total > 1"
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-white/70 text-gray-800 
                            hover:bg-white shadow-lg w-10 h-10 flex items-center justify-center rounded-full
                            opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
            <div>
                <h2 class="text-3xl font-medium uppercase mb-2"><?php echo e($package->name); ?></h2>
                <h3 class="mb-2"> Rp <?= number_format($package->price, 0, ',' , '.') ?> </h3>
                <div class="space-y-2">
                    <p class="text-gray-800 font-semibold space-x-2">
                        <span>Status : </span>
                        <?php if($package->status == 'available'): ?>
                            <span class="text-red-600"><?php echo e($package->status); ?></span>
                        <?php else: ?>
                            <span class="text-green-600"><?php echo e($package->status); ?></span>
                        <?php endif; ?>
                    </p>
                    <p class="space-x-2">
                        <span class="text-gray-800 font-semibold">Type : </span>
                        <span class="text-gray-600"><?php echo e($package->type->name); ?></span>
                    </p>
                    <p class="space-x-2">
                        <span class="text-gray-800 font-semibold">Car : </span>
                        <span class="text-gray-600"><?php echo e($package->car->name); ?></span>
                    </p>
                </div>
                
                <div class="flex items-baseline mb-1 space-x-2 font-roboto mt-4">
                    <p class="text-xl text-primary font-semibold"></p>
                </div>
                <p class="mt-4 text-gray-600"><?php echo e($package->descriptions); ?></p>
                
                <div class="my-10">
                    <button type="submit"
                        class="add-to-cart bg-gradient-to-b from-orange-700 to-yellow-400 
                        text-white px-8 py-2 font-medium rounded uppercase flex items-center gap-2 
                        transition duration-300 ease-in-out
                        hover:bg-white hover:text-transparent hover:border-orange-700 border border-transparent
                        hover:bg-clip-text hover:border-gradient-to-r hover:from-orange-700 hover:to-yellow-400">
                        Process Package
                    </button>
                </div>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', '.add-to-cart', function(e) {
                e.preventDefault();
                if (<?php echo e($package->status  != 'Available'); ?>) {
                    Swal.fire({
                        title: 'Package is unavailable',
                        text: 'Please select another package',
                        icon: 'info',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.customer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH B:\Project\Transport\transport\resources\views/customer/detail-product.blade.php ENDPATH**/ ?>