<?php $__env->startSection('content'); ?>
    <style>
        .image-wrapper {
            position: relative;
            display: inline-block;
        }

        .image-wrapper .delete-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(255, 0, 0, 0.7);
            color: white;
            font-size: 18px;
            padding: 2px 7px;
            border-radius: 50%;
            cursor: pointer;
            display: none;
        }

        .image-wrapper:hover .delete-btn {
            display: block;
        }
    </style>
    <div class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Package List</h4>
                            </div>
                            <div class="header-action">
                                <button class="btn btn-sm btn-primary" onclick="showCreateForm()">Add Package</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable-1" class="table data-table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Car</th>
                                            <th>Description</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="package-table">
                                        <?php $__currentLoopData = $package; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr id="package-<?php echo e($item->id); ?>">
                                                <td> <?php echo e($item->name); ?> </td>
                                                <td> <?php echo e($item->type->name); ?> </td>
                                                <td> <?php echo e($item->car->name); ?> </td>
                                                <td> <?php echo e($item->descriptions); ?> </td>
                                                <td> Rp <?= number_format($item->price, 0, ',' , '.') ?> </td>
                                                <td>
                                                    <span class="badge badge-<?php echo e($item->status == 'Available' ? 'success' : 'danger'); ?>">
                                                        <?php echo e($item->status); ?>

                                                    </span>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-warning"
                                                        onclick="viewImages(<?php echo e($item->id); ?>)">
                                                        <i class="fa-solid fa-image"></i>
                                                    </button>
                                                    <div id="package-images-<?php echo e($item->id); ?>" class="d-none">
                                                        <?php $__currentLoopData = $item->packageImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <img src="<?php echo e(asset('img/package/' . $image->image)); ?>" alt="Package Image"
                                                                width="100" height="75" class="m-1">
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                    <button class="btn btn-sm btn-info"
                                                        onclick="editPackage(<?php echo e($item->id); ?>)">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger"
                                                        onclick="deletePackage(<?php echo e($item->id); ?>)">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal untuk menampilkan gambar dengan slide -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- modal-dialog-centered untuk tengah layar -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Package Images</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="imageCarousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner" id="carousel-images">
                                <!-- Gambar akan dimasukkan via JavaScript -->
                            </div>
                            <a class="carousel-control-prev" href="#imageCarousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true" 
                                    style="filter: drop-shadow(0px 0px 5px rgba(0, 0, 0, 0.8)); background-color: rgba(0, 0, 0, 0.5); padding: 15px; border-radius: 50%;">
                                </span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#imageCarousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true" 
                                    style="filter: drop-shadow(0px 0px 5px rgba(0, 0, 0, 0.8)); background-color: rgba(0, 0, 0, 0.5); padding: 15px; border-radius: 50%;">
                                </span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="packageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="packageForm" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="modal-body">
                            <input type="hidden" id="package_id">
                            <div class="form-group">
                                <label>Package Name</label>
                                <input class="form-control" id="name" name="name" type="text" required
                                    placeholder="Package Name" aria-label="Name">
                            </div>
                            <div class="form-group">
                                <label>Type</label>
                                <select class="form-control" name="type" id="type_id">
                                    <option value="">-- Choose Type --</option>
                                    <?php $__currentLoopData = $type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Car Type</label>
                                <select class="form-control" name="car" id="car_id">
                                    <option value="">-- Choose Car Type--</option>
                                    <?php $__currentLoopData = $car; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <input class="form-control" id="descriptions" name="descriptions" type="text" required
                                    placeholder="Description" aria-label="Name">
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Price</label>
                                <input class="form-control" id="price" name="price" required type="number"
                                    placeholder="Package Price" aria-label="price">
                            </div>
                            <div id="image-preview" class="d-flex flex-wrap"></div>
                            <div class="form-group" id="upload-images-container">
                                <label for="images">Upload Images</label>
                                <input type="file" id="images" name="images[]" class="form-control" multiple accept="image/*">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" aria-label="Close"
                                class="btn btn-secondary btn-sm">Close</button>
                            <button type="submit" class="btn btn-primary btn-sm ">Save changes</button>
                        </div>
                    </form>
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

        function showCreateForm() {
            $('#packageForm')[0].reset();
            $('#package_id').val('');
            $('#modalTitle').text('Add package');
            $('#image-preview').html("");
            $('#upload-images-container').show();
            $('#packageModal').modal('show');
        }

        $('#images').on('change', function(event) {
            let previewContainer = $('#image-preview');
            previewContainer.html("");

            Array.from(this.files).forEach(file => {
                let reader = new FileReader();
                reader.onload = function(e) {
                    let img = $("<img>").attr("src", e.target.result)
                                        .css({"width": "100px", "height": "100px", "object-fit": "cover", "margin": "5px", "border-radius": "5px"});
                    previewContainer.append(img);
                };
                reader.readAsDataURL(file);
            });
        });

        $('#packageForm').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            var id = $('#package_id').val();
            var url = id ? '/package/' + id : '/package'; // Jika edit, pakai ID
            var type = id ? 'POST' : 'POST'; // Ubah PUT jadi POST agar Laravel bisa baca file
            formData.append('_method', id ? 'PUT' : 'POST');
            
            Swal.fire({
                title: 'Simpan Data?',
                text: 'Pastikan data yang Anda masukkan benar',
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: type,
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            $('#packageModal').modal('hide');
                            location.reload();
                        },
                        error: function(xhr) {
                            alert("Error: " + xhr.responseText);
                        }
                    });
                }
            });
        });

        function editPackage(id) {
            $.get('/package/' + id, function(package) {
                $('#package_id').val(package.id);
                $('#name').val(package.name);
                $('#type_id').val(package.type_id);
                $('#car_id').val(package.car_id);
                $('#descriptions').val(package.descriptions);
                $('#status').val(package.status);
                $('#price').val(package.price);
                $('#modalTitle').text('Edit Package');

                let previewContainer = $('#image-preview');
                previewContainer.html("");

                if (package.package_images && package.package_images.length > 0) {
                    $('#upload-images-container').hide();
                    package.package_images.forEach(image => {
                        let imageWrapper = $('<div class="image-wrapper"></div>'); // Wrapper untuk efek hover
                        let img = $("<img>")
                            .attr("src", "/img/package/" + image.image)
                            .css({"width": "100px", "height": "100px", "object-fit": "cover", "margin": "5px", "border-radius": "5px"});
                        
                        let deleteBtn = $('<span class="delete-btn">&times;</span>'); // Tombol hapus (X)
                        deleteBtn.on('click', function() {
                            deleteImage(image.id, imageWrapper);
                        });

                        imageWrapper.append(img).append(deleteBtn);
                        previewContainer.append(imageWrapper);
                    });
                }

                checkImages()
                $('#packageModal').modal('show');
            });
        }

        function viewImages(packageId) {
            let imagesContainer = $('#carousel-images');
            imagesContainer.html(""); // Kosongkan isi carousel sebelum menambahkan gambar baru

            // Ambil semua gambar dari div tersembunyi
            let packageImages = $('#package-images-' + packageId).find('img');
            let totalImages = packageImages.length;

            if (totalImages === 0) {
                imagesContainer.append('<div class="text-center">No images available</div>');
            } else {
                packageImages.each(function(index) {
                    let isActive = index === 0 ? 'active' : ''; // Hanya gambar pertama yang aktif
                    let imageSrc = $(this).attr('src');

                    let carouselItem = `
                        <div class="carousel-item ${isActive}">
                            <img src="${imageSrc}" class="d-block mx-auto" style="width: 600px; height: 600px; object-fit: contain;">
                        </div>
                    `;

                    imagesContainer.append(carouselItem);
                });
            }

            // Cek jumlah gambar dan tampilkan/sembunyikan tombol navigasi
            if (totalImages > 1) {
                $('.carousel-control-prev, .carousel-control-next').show(); // Tampilkan tombol jika lebih dari 1 gambar
            } else {
                $('.carousel-control-prev, .carousel-control-next').hide(); // Sembunyikan tombol jika hanya 1 gambar
            }

            $('#imageModal').modal('show'); // Tampilkan modal
        }

        function deleteImage(imageId, imageWrapper) {
            Swal.fire({
                title: "Are you sure?",
                text: "This image will be permanently deleted!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/package/image/delete/' + imageId,
                        type: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content') // Kirim token CSRF
                        },
                        success: function(response) {
                            if (response.success) {
                                imageWrapper.remove(); // Hapus gambar dari tampilan
                                checkImages();
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Image deleted successfully.",
                                    icon: "success",
                                    timer: 1500,
                                    showConfirmButton: false
                                // }).then(() => {
                                //     location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: "Failed!",
                                    text: "Failed to delete image: " + response.message,
                                    icon: "error"
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                title: "Error!",
                                text: "Error deleting image.",
                                icon: "error"
                            });
                        }
                    });
                }
            });
        }

        function checkImages() {
            let remainingImages = $('#image-preview .image-wrapper').length;
            console.log("Remaining images:", remainingImages);
            if (remainingImages === 0) {
                $('#upload-images-container').show();
            } else {
                $('#upload-images-container').hide();
            }
        }

        function deletePackage(id) {
            Swal.fire({
                title: 'Hapus Data?',
                text: 'Data yang anda pilih akan dihapus secara permanen',
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/package/' + id,
                        method: 'DELETE',
                        success: function(response) {
                            $('#package-' + id).remove();
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

<?php echo $__env->make('layouts.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH B:\Project\Transport\transport\resources\views/staff/package/data-package.blade.php ENDPATH**/ ?>