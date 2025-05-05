
<?php $__env->startSection('content'); ?>
    <!-- wrapper -->
    <div class="container py-4">
        <div class="container grid grid-cols-12 items-start pb-16 pt-4 gap-6">
            <div class="col-span-12 border border-gray-200 p-4 rounded">
                <h4 class="text-gray-800 text-lg mb-4 font-medium uppercase">Invoice</h4>
                <p class="text-gray-500">Thank you for your payment. Here is your invoice:</p>
                <div class="mt-4 border-t pt-4">
                    <p class="text-gray-700"><strong>Invoice ID:</strong> <?php echo e($transaction->id); ?></p>
                    <p class="text-gray-700"><strong>Transaction Date:</strong> <?php echo e($transaction->date); ?></p>
                </div>
                <div class="mt-4 space-y-2">
                    <?php $__currentLoopData = $transaction->transactionDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex justify-between">
                            <h5 class="text-gray-800 font-medium"><?php echo e($detail->package->name); ?></h5>
                            <div>
                                <p class="text-gray-500 text-sm">Rp<?php echo e(number_format($detail->package->price, 0, ',', '.')); ?></p>
                                <p class="text-gray-500 text-sm"><?php echo e($transaction->qty); ?> pax</p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="flex justify-between text-gray-800 font-medium py-3 uppercase border-t mt-4 pt-4">
                    <p>Total Amount</p>
                    <p>Rp<?php echo e(number_format($transaction->total, 0, ',', '.')); ?></p>
                </div>
                <div class="mt-4 text-center">
                    <a href="<?php echo e(route('home')); ?>" class="inline-block px-6 py-3 bg-primary text-white rounded-md hover:bg-transparent hover:text-primary border border-primary transition">
                        Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.customer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH B:\Project\Transport\transport\resources\views/customer/invoice.blade.php ENDPATH**/ ?>