@extends('layouts.index')
@section('content')
    <div class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Staff List</h4>
                            </div>
                            <div class="header-action">
                                <button class="btn btn-sm btn-primary" onclick="showCreateForm()">Add New Staff</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable-1" class="table data-table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="staff-table">
                                        @foreach ($users as $item)
                                            <tr id="{{ $item->id }}">
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->phone }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-info"
                                                        onclick="editStaff({{ $item->id }})">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger"
                                                        onclick="deleteStaff({{ $item->id }})">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
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
        <!-- Create/Edit Modal -->
        <div class="modal fade" id="staffModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Add New Staff</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="staffForm">
                        <div class="modal-body">
                            <input type="hidden" id="users_id">
                            <div class="form-group">
                                <label>Name</label>
                                <input class="form-control" id="name" name="name" type="text" required
                                    placeholder="Name" aria-label="Name">
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input class="form-control" id="phone" name="phone" type="text" required
                                    placeholder="Phone Number" aria-label="Name">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" id="email" name="email" type="text" required
                                    placeholder="Email" aria-label="Name">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input class="form-control" id="password" name="password" type="password" required
                                    placeholder="Password" aria-label="Name">
                            </div>
                            <div class="form-group">
                                <label>Re-Password</label>
                                <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" required
                                    placeholder="Re-Password" aria-label="Name">
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
@endsection
@section('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function showCreateForm() {
            $('#staffForm')[0].reset();
            $('#users_id').val('');
            $('#modalTitle').text('Add New Staff');
            $('#staffModal').modal('show');
        }

        $('#staffForm').submit(function(e) {
            e.preventDefault();
            var id = $('#users_id').val();
            var url = id ? '/users/' + id : '/users'; // if edit, use id
            var type = id ? 'PUT' : 'POST'; // if edit, use PUT
            
            var requestData = {
                name: $('#name').val(),
                phone: $('#phone').val(),
                email: $('#email').val()
            };

            // Jika password diisi, tambahkan ke request
            if ($('#password').val()) {
                requestData.password = $('#password').val();
                requestData.password_confirmation = $('#password_confirmation').val();
            }

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
                        method: type,
                        data: requestData,
                        success: function(response) {
                            $('#staffModal').modal('hide');
                            location.reload();
                        },
                        error: function(response) {
                            if (response.status === 422) {
                                // Handle validation errors
                                Swal.fire({
                                    title: 'Gagal menyimpan data',
                                    text: 'Email Already Registered!',
                                    icon: 'info',
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'OK'
                                });
                            } else {
                                alert('An error occurred.');
                            }
                        }
                    });
                }
            });
        });


        // $('#staffForm').submit(function(e) {
        //     e.preventDefault();
        //     var id = $('#users_id').val();
        //     var url = id ? '/users/' + id : '/users'; // if edit, will using id
        //     var type = id ? 'PUT' : 'POST'; // if edit, use put
        //     Swal.fire({
        //         title: 'Simpan Data?',
        //         text: 'Pastikan data yang Anda masukkan benar',
        //         icon: 'success',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Yes'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             $.ajax({
        //                 url: url,
        //                 method: type,
        //                 data: {
        //                     name: $('#name').val(),
        //                     phone: $('#phone').val(),
        //                     email: $('#email').val(),
        //                     password: $('#password').val(),

        //                     // transaction_id: $('#transaction_id').val(),
        //                 },
        //                 success: function(response) {
        //                     $('#staffModal').modal('hide');
        //                     location.reload();
        //                 },
        //                 error: function(response) {
        //                     if (response.status === 422) {
        //                         // Handle validation errors
        //                         Swal.fire({
        //                             title: 'Gagal menyimpan data',
        //                             text: 'Email Already Registered!',
        //                             icon: 'info',
        //                             confirmButtonColor: '#3085d6',
        //                             cancelButtonColor: '#d33',
        //                             confirmButtonText: 'OK'
        //                         })
        //                     } else {
        //                         // Handle other errors
        //                         alert('An error occurred.');
        //                     }
        //                 }
        //             });
        //         }
        //     })
        // });

        function editStaff(id) {
            console.log("editStaff function called with id:", id);
            $.get('/users/' + id, function(users) {
                $('#users_id').val(users.id);
                $('#name').val(users.name);
                $('#phone').val(users.phone);
                $('#email').val(users.email).prop('disabled', true);
                $('#password').val('');
                $('#password_confirmation').val('');
                // $('#transaction_id').val(users.transaction_id);
                $('#modalTitle').text('Edit Staff');
                $('#staffModal').modal('show');
            });
        }

        // function deleteStaff(id) {
        //     Swal.fire({
        //         title: 'Hapus Data?',
        //         text: 'Data yang anda pilih akan dihapus secara permanen',
        //         icon: 'success',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Yes'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             $.ajax({
        //                 url: '/users/' + id,
        //                 method: 'DELETE',
        //                 success: function(response) {
        //                     $('#users-' + id).remove();
        //                 }
        //             });
        //         }
        //     })
        // }

        function deleteStaff(id) {
            Swal.fire({
                title: 'Hapus Data?',
                text: 'Data yang Anda pilih akan dihapus secara permanen',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/users/' + id,
                        method: 'DELETE',
                        success: function(response) {
                            // Menghapus elemen dari DOM
                            $('#users-' + id).remove();
                            // Menampilkan pesan sukses
                            Swal.fire(
                                'Terhapus!',
                                'Data telah berhasil dihapus.',
                                'success'
                            );
                        },
                        error: function(xhr, status, error) {
                            // Menampilkan pesan kesalahan
                            Swal.fire(
                                'Gagal!',
                                'Terjadi kesalahan saat menghapus data: ' + error,
                                'error'
                            );
                        }
                    });
                }
            });
        }

    </script>
@endsection
