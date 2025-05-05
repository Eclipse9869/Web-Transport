<?php $__env->startSection('content'); ?>
    <div class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="header-title">
                        <h4 class="card-title">All Transaction</h4>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-4"> <!-- Tambahkan gap antar card -->
                                <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-4">
                                        <div class="card border border-primary shadow-lg"> <!-- Tambahkan border dan shadow -->
                                            <div class="card-header bg-primary text-white text-center">
                                                <h5 class="mb-0">Total: Rp <?php echo e(number_format($transaction->total, 0, ',', '.')); ?></h5>
                                            </div>
                                            <div class="card-body">
                                                <p><strong>User :</strong> <?php echo e($transaction->user->name ?? 'No User'); ?></p>
                                                <hr>
                                                <p><strong>Packages :</strong></p>
                                                <ul class="list-group list-group-flush border rounded"> <!-- Tambahkan border pada list -->
                                                    <?php $__currentLoopData = $transaction->transactionDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li class="list-group-item d-flex justify-content-between">
                                                            <?php echo e($detail->package->name); ?> 
                                                            <span class="text-muted">Rp <?php echo e(number_format($detail->package->price, 0, ',', '.')); ?></span>
                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                                <hr>
                                                <div class="d-flex justify-content-between">
                                                    <p><strong>Pax :</strong></p>
                                                    <p><?php echo e($transaction->qty); ?></p>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p><strong>Status :</strong></p>
                                                    <p>
                                                        <span class="badge 
                                                        <?php if($transaction->status == 'Paid'): ?> bg-success
                                                        <?php elseif($transaction->status == 'Unpaid'): ?> bg-warning
                                                        <?php else: ?> bg-danger <?php endif; ?>">
                                                        <?php echo e(ucfirst($transaction->status)); ?>

                                                        </span>
                                                    </p>
                                                </div>
                                                <hr>
                                                <div class="mt-3 text-center">
                                                    <button class="btn btn-sm btn-success border border-dark" onclick="">
                                                        <i class="fa fa-check-circle"></i>&nbsp;&nbsp;Done
                                                    </button>
                                                    <button class="btn btn-sm btn-danger border border-dark" onclick="deleteType(<?php echo e($transaction->id); ?>)">
                                                        <i class="fa fa-trash"></i>&nbsp;&nbsp;Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="card">
                        <div class="card-body">
                            <div class="row">
                            <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-4">
                                    <div class="card shadow-lg">
                                        <div class="card-body">
                                            <h5 class="card-title">Total: <?php echo e($transaction->total); ?></h5>
                                            <?php $__currentLoopData = $transaction->transactionDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <p>Package: <?php echo e($detail->package->name); ?> | Price: <?php echo e($detail->package->price); ?>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <p>Pax : <?php echo e($transaction->qty); ?></p>
                                            <p>Status : <?php echo e($transaction->status); ?></p>
                                            <div class="mt-3">
                                                <button class="btn btn-sm btn-danger" onclick="deleteType(<?php echo e($transaction->id); ?>)">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function deleteType(id) {
            Swal.fire({
                title: 'Hapus Data?',
                text: 'Data yang anda pilih akan dihapus secara permanen',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/type/' + id,
                        method: 'DELETE',
                        success: function(response) {
                            location.reload();
                            Swal.fire(
                                'Terhapus!',
                                'Data telah berhasil dihapus.',
                                'success'
                            );
                        }
                    });
                }
            })
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH B:\Project\Transport\transport\resources\views/staff/transaction/data-transaction.blade.php ENDPATH**/ ?>