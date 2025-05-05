@extends('layouts.index')
@section('content')
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
                                <h4 class="card-title">Car List</h4>
                            </div>
                            <div class="header-action">
                                <button class="btn btn-sm btn-primary" onclick="showCreateForm()">Add Car</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable-1" class="table data-table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>   
                                            <th>Description</th>  
                                            <th>Images</th>                                   
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="car-table">
                                        @foreach ($cars as $item)
                                            <tr id="car-{{ $item->id }}">
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->descriptions }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary" onclick="viewImages({{ $item->id }})">
                                                        View Images
                                                    </button>
                                                    <!-- Simpan gambar dalam elemen tersembunyi -->
                                                    <div id="car-images-{{ $item->id }}" class="d-none">
                                                        @foreach ($item->carImages as $image)
                                                            <img src="{{ asset('img/car/' . $image->image) }}" alt="Car Image"
                                                                width="100" height="75" class="m-1">
                                                        @endforeach
                                                    </div>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-info" onclick="editCar({{ $item->id }})">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </button>
                                                    <!-- <button class="btn btn-sm btn-danger" onclick="deleteCar({{ $item->id }})">
                                                        <i class="fa fa-trash"></i>
                                                    </button> -->
                                                </td>
                                            </tr>
                                        @endforeach
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
                        <h5 class="modal-title">Car Images</h5>
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

        <!-- Create/Edit Modal -->
        <div class="modal fade" id="carModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Add Car</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="carForm" enctype="multipart/form-data">
                        <div class="modal-body">
                            <input type="hidden" id="car_id" name="car_id">

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="descriptions">Description</label>
                                <textarea id="descriptions" name="descriptions" class="form-control" required></textarea>
                            </div>
                            <div id="image-preview" class="d-flex flex-wrap"></div>
                            <div class="form-group" id="upload-images-container">
                                <label for="images">Upload Images</label>
                                <input type="file" id="images" name="images[]" class="form-control" multiple accept="image/*">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn btn-secondary btn-sm">Close</button>
                            <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function showCreateForm() {
        $('#carForm')[0].reset();
        $('#car_id').val('');
        $('#modalTitle').text('Add Car');
        $('#image-preview').html("");
        $('#upload-images-container').show();
        $('#carModal').modal('show');
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

    $('#carForm').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let id = $('#car_id').val();
        let url = id ? '/car/' + id : '/car';
        let type = id ? 'POST' : 'POST';
        formData.append('_method', id ? 'PUT' : 'POST');

        Swal.fire({
            title: 'Simpan Data?',
            text: 'Pastikan data yang Anda masukkan benar',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    method: type,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#carModal').modal('hide');
                        location.reload();
                    }
                });
            }
        });
    });

    function editCar(id) {
        $.get('/car/' + id, function(car) {
            $('#car_id').val(car.id);
            $('#name').val(car.name);
            $('#descriptions').val(car.descriptions);
            $('#modalTitle').text('Edit Car');

            let previewContainer = $('#image-preview');
            previewContainer.html("");

            if (car.car_images && car.car_images.length > 0) {
                $('#upload-images-container').hide();
                car.car_images.forEach(image => {
                    let imageWrapper = $('<div class="image-wrapper"></div>'); // Wrapper untuk efek hover
                    let img = $("<img>")
                        .attr("src", "/img/car/" + image.image)
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
            $('#carModal').modal('show');
        });
    }
    
    function viewImages(carId) {
        let imagesContainer = $('#carousel-images');
        imagesContainer.html(""); // Kosongkan isi carousel sebelum menambahkan gambar baru

        // Ambil semua gambar dari div tersembunyi
        let carImages = $('#car-images-' + carId).find('img');
        let totalImages = carImages.length;

        if (totalImages === 0) {
            imagesContainer.append('<div class="text-center">No images available</div>');
        } else {
            carImages.each(function(index) {
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
                    url: '/car/image/delete/' + imageId,
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

    function deleteCar(id) {
        Swal.fire({
            title: 'Hapus Data?',
            text: 'Data akan dihapus secara permanen',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/car/' + id,
                    method: 'DELETE',
                    success: function() {
                        $('#car-' + id).remove();
                        Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success');
                    }
                });
            }
        });
    }
</script>
@endsection
