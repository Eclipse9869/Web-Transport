<?php $__env->startSection('content'); ?>
    <!-- <?php
        $total = 0;
        $tax = 0;
        foreach ($details as $key => $value) {
            $tax += $value->transaction['total_ppn'];
            $total += $value->transaction['sub_total'];
        }
        $grandTotal = $total + $tax;
    ?> -->
    <div class="container py-4 flex items-center gap-3">
        <a href="../index.html" class="text-primary text-base">
            <i class="fa-solid fa-house"></i>
        </a>
        <span class="text-sm text-gray-400">
            <i class="fa-solid fa-chevron-right">Detail Orders</i>
        </span>
    </div>
    <?php $__currentLoopData = $details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="container grid grid-cols-2 gap-6 mb-5">
            <div class="col-span-12 space-y-4">
                <div class="flex items-center justify-between border gap-6 p-4 border-gray-200 rounded">
                    <div class="w-1/3">
                        <h2 class="text-gray-800 text-xl font-medium">Name : <?php echo e($item->name); ?></h2>
                        <!-- <p class="text-gray-500 text-sm">Alamat : <?php echo e($item->address); ?></p> -->
                        <p class="text-gray-500 text-sm">Phone Number : <?php echo e($item->phone); ?></p>
                    </div>
                    
                    <div class="text-primary text-lg font-semibold">Rp <?= number_format($item->transaction->total, 0, ',' , '.') ?></div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.customer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH B:\Project\Transport\transport\resources\views/customer/riwayat-detail.blade.php ENDPATH**/ ?>