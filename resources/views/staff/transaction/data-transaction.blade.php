@extends('layouts.index')
@section('content')
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
                                @foreach ($transactions as $transaction)
                                    <div class="col-md-4">
                                        <div class="card border border-primary shadow-lg"> <!-- Tambahkan border dan shadow -->
                                            <div class="card-header bg-primary text-white text-center">
                                                <h5 class="mb-0">Total: Rp {{ number_format($transaction->total, 0, ',', '.') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <p><strong>User :</strong> {{ $transaction->user->name ?? 'No User' }}</p>
                                                <hr>
                                                <p><strong>Packages :</strong></p>
                                                <ul class="list-group list-group-flush border rounded"> <!-- Tambahkan border pada list -->
                                                    @foreach ($transaction->transactionDetails as $detail)
                                                        <li class="list-group-item d-flex justify-content-between">
                                                            {{ $detail->package->name }} 
                                                            <span class="text-muted">Rp {{ number_format($detail->package->price, 0, ',', '.') }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                <hr>
                                                <div class="d-flex justify-content-between">
                                                    <p><strong>Pax :</strong></p>
                                                    <p>{{ $transaction->qty }}</p>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p><strong>Status :</strong></p>
                                                    <p>
                                                        <span class="badge 
                                                        @if($transaction->status == 'Paid') bg-success
                                                        @elseif($transaction->status == 'Unpaid') bg-warning
                                                        @else bg-danger @endif">
                                                        {{ ucfirst($transaction->status) }}
                                                        </span>
                                                    </p>
                                                </div>
                                                <hr>
                                                <div class="mt-3 text-center">
                                                    <button class="btn btn-sm btn-success border border-dark" onclick="">
                                                        <i class="fa fa-check-circle"></i>&nbsp;&nbsp;Done
                                                    </button>
                                                    <button class="btn btn-sm btn-danger border border-dark" onclick="deleteType({{ $transaction->id }})">
                                                        <i class="fa fa-trash"></i>&nbsp;&nbsp;Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- <div class="card">
                        <div class="card-body">
                            <div class="row">
                            @foreach ($transactions as $transaction)
                                <div class="col-md-4">
                                    <div class="card shadow-lg">
                                        <div class="card-body">
                                            <h5 class="card-title">Total: {{ $transaction->total }}</h5>
                                            @foreach ($transaction->transactionDetails as $detail)
                                                <p>Package: {{ $detail->package->name }} | Price: {{ $detail->package->price }}
                                            @endforeach
                                            <p>Pax : {{ $transaction->qty }}</p>
                                            <p>Status : {{ $transaction->status }}</p>
                                            <div class="mt-3">
                                                <button class="btn btn-sm btn-danger" onclick="deleteType({{ $transaction->id }})">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                        </div>
                    </div> -->
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
@endsection
