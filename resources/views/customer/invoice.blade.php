@extends('layouts.customer')
@section('content')
    <!-- wrapper -->
    <div class="container py-4">
        <div class="container grid grid-cols-12 items-start pb-16 pt-4 gap-6">
            <div class="col-span-12 border border-gray-200 p-4 rounded">
                <h4 class="text-gray-800 text-lg mb-4 font-medium uppercase">Invoice</h4>
                <p class="text-gray-500">Thank you for your payment. Here is your invoice:</p>
                <div class="mt-4 border-t pt-4">
                    <p class="text-gray-700"><strong>Invoice ID:</strong> {{ $transaction->id }}</p>
                    <p class="text-gray-700"><strong>Transaction Date:</strong> {{ $transaction->date }}</p>
                </div>
                <div class="mt-4 space-y-2">
                    @foreach ($transaction->transactionDetails as $detail)
                        <div class="flex justify-between">
                            <h5 class="text-gray-800 font-medium">{{ $detail->package->name }}</h5>
                            <div>
                                <p class="text-gray-500 text-sm">Rp{{ number_format($detail->package->price, 0, ',', '.') }}</p>
                                <p class="text-gray-500 text-sm">{{ $transaction->qty }} pax</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-between text-gray-800 font-medium py-3 uppercase border-t mt-4 pt-4">
                    <p>Total Amount</p>
                    <p>Rp{{ number_format($transaction->total, 0, ',', '.') }}</p>
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('home') }}" class="inline-block px-6 py-3 bg-primary text-white rounded-md hover:bg-transparent hover:text-primary border border-primary transition">
                        Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection