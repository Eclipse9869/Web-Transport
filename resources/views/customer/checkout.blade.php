@extends('layouts.customer')
@section('content')

    <!-- wrapper -->
    <div class="container py-4">
        <form id="checkout-form" method="POST" action="{{ route('checkout.index') }}" enctype="multipart/form-data">
            @csrf
            <div class="container grid grid-cols-12 items-start pb-16 pt-4 gap-6">
                <div class="col-span-12 border border-gray-200 p-4 rounded">
                    <h4 class="text-gray-800 text-lg mb-4 font-medium uppercase">Order summary</h4>
                    @foreach ($cart as $key => $c)
                        <div class="space-y-2 mt-5">
                            <div class="flex justify-between">
                                <h5 class="text-gray-800 font-medium">{{ $c['name'] }}</h5>
                                <div class="">
                                    <p class="text-gray-500 text-sm">@currency($c['price'])</p>
                                    <p class="text-gray-500 text-sm">{{ $c['qty'] }} pax</p>
                                </div>
                            </div>
                            <div class="flex justify-between text-gray-800 font-medium py-3 uppercase">
                                <p>Subtotal</p>
                                <p>@currency($c['price'] * $c['qty'])</p>
                            </div>
                            <div class="flex justify-between text-gray-800 font-medium py-3 uppercase">  
                                <p>Date</p>
                                <p>{{ $c['date'] }}</p>
                            </div>
                        </div>
                    @endforeach
                    <button type="button" id="pay-button" class="block w-full py-3 px-4 text-center text-white bg-primary border border-primary rounded-md hover:bg-transparent hover:text-primary transition font-medium">
                        Checkout
                    </button>
                </div>
            </div>
        </form>
    </div>
    <script type="text/javascript">
      // For example trigger on button clicked, or any time you need
      var payButton = document.getElementById('pay-button');
      payButton.addEventListener('click', function () {
        // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
        window.snap.pay('{{$snapToken}}', {
          onSuccess: function(result){
            /* You may add your own implementation here */
            window.location.href = '/invoice/{{$transaction->id}}'
            // alert("payment success!"); 
            console.log(result);
          },
          onPending: function(result){
            /* You may add your own implementation here */
            alert("wating your payment!"); console.log(result);
          },
          onError: function(result){
            /* You may add your own implementation here */
            alert("payment failed!"); console.log(result);
          },
          // onClose: function(){
          //   /* You may add your own implementation here */
          //   alert('you closed the popup without finishing the payment');
          // }
        })
      });
    </script>
@endsection
